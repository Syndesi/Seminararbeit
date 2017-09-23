<?php
require_once __DIR__.'/../lib/route.php';
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class UserRoute extends \lib\Route {

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('POST:/', function(){$this->createUser();});
    $this->addRoute('GET:/{id:i}', function($p){$this->getUserById($p['id']);});
  }

  private function getUserById($id){
    $user = UserQuery::create()->findPK($id);
    if($user){
      $data = [
        'id' => $id,
        'forename'   => $user->getForename(),
        'surname'    => $user->getSurname(),
        'nickname'   => $user->getNickname(),
        'created_at' => $user->getCreatedAt('Y-m-d H:i:s')
      ];
      $this->r->finish($data);
    }
    throw new Exception('This user does not exist.');
  }

  private function createUser(){
    $data = [
      "forename"         => $this->r->getData('forename', true),
      "surname"          => $this->r->getData('surname', true),
      "nickname"         => $this->r->getData('nickname'),
      "email"            => $this->r->getData('email', true),
      "mobile"           => $this->r->getData('mobile'),
      "password"         => $this->r->getData('password', true)
    ];
    $v = v::key('forename', v::stringType()->length(1, 64))
          ->key('surname', v::stringType()->length(1, 64))
          ->key('nickname', v::optional(v::stringType()->length(0, 64)))
          ->key('email', v::stringType()->email()->length(1, 256))
          ->key('mobile', v::optional(v::stringType()->phone()->length(1, 16)))
          ->key('password', v::stringType()->length(8, NULL));
    $v->assert($data);

    $count = UserQuery::create()->filterByEmail($data['email'])->count();
    if($count > 0){
      throw new Exception('This e-mail is already in use.');
    }

    $user = new User();
    $user->setForename($data['forename']);
    $user->setSurname($data['surname']);
    $user->setNickname($data['nickname']);
    $user->setEmail($data['email']);
    $user->setMobile($data['mobile']);
    $user->setHash($data['password']);
    $user->save();

    $this->r->finish($user->toArray());
  }

}

?>