<?php

require_once __DIR__.'/../lib/route.php';
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
    $this->addRoute('GET:/',        function($p){$this->getOwnAccount();});      // /api/account
    $this->addRoute('GET:/{id:i}',  function($p){$this->getAccount($p['id']);}); // /api/account/1
    $this->addRoute('POST:/',       function($p){$this->createAccount();});      // /api/account
    $this->addRoute('PUT:/',        function($p){$this->updateOwnAccount();});   // /api/account
    $this->addRoute('DELETE:/',     function($p){$this->deleteOwnAccount();});   // /api/account
    $this->addRoute('POST:/login',  function($p){$this->login();});              // /api/account/login
    $this->addRoute('GET:/logout',  function($p){$this->logout();});             // /api/account/logout
    $this->addRoute('GET:/logedIn', function($p){$this->isLoggedIn();});         // /api/account/loggedIn
  }

  private function getOwnAccount(){
    $account = $this->r->session->get('account');
    if(!$account){
      throw new Exception('You are not logged in.');
    }
    $this->r->finish($account);
  }

  private function getAccount($id){
    $account = AccountQuery::create()->findPK($id);
    if(!$account){
      throw new Exception('No account found.');
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
      throw new Exception('This e-mail is already in use.');
    }
    $account = new Account();
    $account->setForename($data['forename']);
    $account->setSurname($data['surname']);
    $account->setEmail($data['email']);
    $account->setEmailVerified(false);
    $account->setHash($this->getHash($data['password']));
    $account->save();
    $this->r->finish([
      'id'       => $account->getId(),
      'forename' => $account->getForename(),
      'surname'  => $account->getSurname(),
      'email'    => $account->getEmail()
    ]);
  }

  private function getHash($password){
    return password_hash($password, $this->hash['algo'], $this->hash['options']);
  }

  private function updateOwnAccount(){
    if(!$this->r->session->get('account')){
      throw new Exception('You are not logged in.');
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
    $account->setName($data['name']);
    $account->setHash($this->getHash($data['password']));
    $account->save();
    $this->r->session->restart();
    $this->setSession($account);
    $this->r->finish('Successfully updated the your account.');
  }

  private function deleteOwnAccount(){
    if(!$this->r->session->get('account')){
      throw new Exception('You are not logged in.');
    }
    $data = [
      'password' => $this->r->getData('password', true)
    ];
    $v = v::key('password', v::stringType()->length(8, NULL));
    $v->assert($data);
    $account = AccountQuery::create()->findPK($this->r->session->get('account')['id']);
    $hash = $account->getHash();
    if(!password_verify($data['password'], $hash)){
      throw new Exception('The password is wrong.');
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
      throw new Exception('There is no account with this e-mail.');
    }
    $hash = $account->getHash();
    if(!password_verify($data['password'], $hash)){
      throw new Exception('The password is wrong.');
    }
    if(password_needs_rehash($hash, $this->hash['algo'], $this->hash['options'])){
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
    $loggedIn = ($this->r->session->get('account') ? true : false);
    $this->r->finish(['loggedIn' => $loggedIn]);
  }

  private function logout(){
    $this->r->session->destroy();
    $this->r->finish('Successfully logged out.');
  }

}

?>