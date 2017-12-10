<?php

require_once __DIR__.'/../lib/route.php';
require_once __DIR__.'/../lib/config.php';
require_once __DIR__.'/../lib/email.php';
use Propel\Runtime\Propel;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class AccountRoute extends \lib\Route {

  private $hash = [
    'algo' => PASSWORD_DEFAULT,
    'options' => [
      'cost' => 12
    ]
  ];
  private $dateFormat = 'Y-m-d H:i:s';

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/',                 function($p){$this->getOwnAccount();});             // /api/account
    $this->addRoute('GET:/{id:i}',           function($p){$this->getAccount($p['id']);});        // /api/account/1
    $this->addRoute('POST:/',                function($p){$this->createAccount();});             // /api/account
    $this->addRoute('PUT:/',                 function($p){$this->updateOwnAccount();});          // /api/account
    $this->addRoute('DELETE:/',              function($p){$this->deleteOwnAccount();});          // /api/account
    $this->addRoute('GET:/verify/{verify}',  function($p){$this->verifyAccount($p['verify']);}); // /api/account
    $this->addRoute('POST:/login',           function($p){$this->login();});                     // /api/account/login
    $this->addRoute('GET:/logout',           function($p){$this->logout();});                    // /api/account/logout
    $this->addRoute('GET:/status',           function($p){$this->isLoggedIn();});                // /api/account/loggedIn
    $this->config = \lib\getConfig();
  }

  private function getOwnAccount(){
    $account = $this->r->session->get('account');
    if(!$account){
      $this->r->abort('notLogedIn', 'You are not logged in.');
    }
    $this->r->finish($account);
  }

  private function getAccount($id){
    $account = AccountQuery::create()->findPK($id);
    if(!$account){
      $this->r->abort('userDoesNotExist', 'There is no account with this ID.');
    }
    $this->r->finish([
      'id'       => $account->getId(),
      'forename' => $account->getForename(),
      'surname'  => $account->getSurname(),
      'created'  => $account->getCreatedAt($this->dateFormat)
    ]);
  }

  private function createAccount(){
    $data = [
      'forename' => $this->r->getData('forename', true),
      'surname'  => $this->r->getData('surname', true),
      'email'    => $this->r->getData('email', true),
      'password' => $this->r->getData('password', true)
    ];
    $v = v::key('forename', v::stringType()->length(1, 64))
          ->key('surname',  v::stringType()->length(1, 64))
          ->key('email',    v::stringType()->email()->length(1, 256))
          ->key('password', v::stringType()->length(8, NULL));
    $v->assert($data);
    $account = AccountQuery::create()->findOneByEmail($data['email']);
    if($account !== null){
      $this->r->abort('emailAlreadyUsed', 'This e-mail is already in use.');
    }
    // create the account
    $account = new Account();
    $account->setForename($data['forename']);
    $account->setSurname($data['surname']);
    $account->setEmail($data['email']);
    $account->setEmailVerified(false);
    $account->setHash($this->getHash($data['password']));
    $account->save();
    // create a verification link
    $verify_link = md5($account->getId().'_'.time().'_'.random_int(0, 10000000));
    $verify = new AccountVerification();
    $verify->setAccountId($account->getId());
    $verify->setLink($verify_link);
    $verify->save();
    // send email
    $email = new \lib\email();
    $email->setSubject('Verify your account');
    $verify_id = 's1Ui5KAznkWAepaej4yRrDOp1SSxlx4q4QeSl6F9kQFhaDCyvC';
    $link = $this->config['apiUrl'].'/account/verify/'.$verify_link;
    $email->setBody(
       '<h2>Hello,</h2>'
      .'<p>Thank you for creating an account on Project-Ozone. But in order to use it, you will need to click on the following link to verify it:</p>'
      .'<a href="'.$link.'">Verify your account</a>'
    );
    $email->addAddress($account->getEmail(), $account->getForename().' '.$account->getSurname());
    $email->send();
    $this->r->finish([
      'id'       => $account->getId(),
      'forename' => $account->getForename(),
      'surname'  => $account->getSurname(),
      'email'    => $account->getEmail()
    ]);
  }

  private function verifyAccount($code){
    $verify = AccountVerificationQuery::create()->findOneByLink($code);
    if($verify == null){
      $this->r->abort('verificationCodeDoesNotExist', 'The given verification code does not exist.');
    }
    $account = AccountQuery::create()->findPk($verify->getAccountId());
    $account->setEmailVerified(true);
    $account->save();
    $verify->delete();
    // send email
    $email = new \lib\email();
    $email->setSubject('Your account is verified');
    $email->setBody(
       '<h2>Hello,</h2>'
      .'<p>Thank you for verifying your account, it is now fully usable.</p>'
    );
    $email->addAddress($account->getEmail(), $account->getForename().' '.$account->getSurname());
    $email->send();
    $this->r->finish('Account is verified.');
  }

  private function getHash($password){
    return password_hash($password, constant($this->config['settings']['account']['algo']), ['cost' => $this->config['settings']['account']['cost']]);
  }

  private function updateOwnAccount(){
    if(!$this->r->session->get('account')){
      $this->r->abort('notLogedIn', 'You are not logged in.');
    }
    $data = [
      'forename' => $this->r->getData('forename', true),
      'surname'  => $this->r->getData('surname', true),
      'password' => $this->r->getData('password', true)
    ];
    $v = v::key('forename', v::stringType()->length(1, 64))
          ->key('surname',  v::stringType()->length(1, 64))
          ->key('password', v::stringType()->length(8, NULL));
    $v->assert($data);
    $account = AccountQuery::create()->findPK($this->r->session->get('account')['id']);
    $account->setForename($data['forename']);
    $account->setSurname($data['surname']);
    $account->setHash($this->getHash($data['password']));
    $account->save();
    $this->r->session->restart();
    $this->setSession($account);
    $this->r->finish('Successfully updated the your account.');
  }

  private function deleteOwnAccount(){
    if(!$this->r->session->get('account')){
      $this->r->abort('notLogedIn', 'You are not logged in.');
    }
    $data = [
      'password' => $this->r->getData('password', true)
    ];
    $v = v::key('password', v::stringType()->length(8, NULL));
    $v->assert($data);
    $account = AccountQuery::create()->findPK($this->r->session->get('account')['id']);
    $hash = $account->getHash();
    if(!password_verify($data['password'], $hash)){
      $this->r->abort('passwordIsWrong', 'The password is wrong.');
    }
    $account->delete();
    $this->r->session->destroy();
    $this->r->finish($account->isDeleted());
  }

  private function login(){
    $this->r->session->restart();
    $data = [
      'email'    => $this->r->getData('email', true),
      'password' => $this->r->getData('password', true)
    ];
    $v = v::key('email',    v::stringType()->email()->length(1, 256))
          ->key('password', v::stringType()->length(8, NULL));
    $v->assert($data);
    $account = AccountQuery::create()->findOneByEmail($data['email']);
    if($account === null){
      $this->r->abort('userDoesNotExist', 'There is no account with this e-mail.');
    }
    $hash = $account->getHash();
    if(!password_verify($data['password'], $hash)){
      $this->r->abort('passwordIsWrong', 'The password is wrong.');
    }
    if(password_needs_rehash($hash, constant($this->config['settings']['account']['algo']), ['cost' => $this->config['settings']['account']['cost']])){
      $newHash = $this->getHash($data['password']);
      $account->setHash($newHash);
      $account->save();
    }
    $this->setSession($account);
    $this->r->finish('Successfully logged in.');
  }

  private function setSession($account){
    $this->r->session->set('account', [
      'id'            => $account->getId(),
      'forename'      => $account->getForename(),
      'surname'       => $account->getSurname(),
      'email'         => $account->getEmail(),
      'emailVerified' => $account->getEmailVerified(),
      'created'       => $account->getCreatedAt($this->dateFormat),
      'updated'       => $account->getUpdatedAt($this->dateFormat)
    ]);
  }

  private function isLoggedIn(){
    if($account = $this->r->session->get('account')){
      $this->r->finish($account);
    }
    $this->r->abort('notLogedIn', 'You are not logged in.');
  }

  private function logout(){
    $this->r->session->destroy();
    $this->r->finish('Successfully logged out.');
  }

}

?>