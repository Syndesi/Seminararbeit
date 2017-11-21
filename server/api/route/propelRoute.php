<?php
set_time_limit(0);
require_once __DIR__.'/../lib/route.php';
require_once __DIR__.'/../lib/propelCommandWrapper.php';


class PropelRoute extends \lib\Route {

  public function __construct($r){
    parent::__construct($r);
    date_default_timezone_set('Europe/Berlin');
    $this->addRoute('POST:/sql/build', function($p){$this->cmd(['command' => 'sql:build', '--overwrite' => null]);});
    $this->addRoute('POST:/sql/insert', function($p){$this->cmd(['command' => 'sql:insert']);});
    $this->addRoute('POST:/model/build', function($p){$this->cmd(['command' => 'model:build']);});
    $this->addRoute('GET:/migration/status', function($p){$this->cmd(['command' => 'migration:status']);});
    $this->addRoute('POST:/migrate', function($p){$this->cmd(['command' => 'migrate']);});
    $this->addRoute('POST:/diff', function($p){$this->cmd(['command' => 'diff']);});
  }

  private function cmd($input){
    $wrapper = new \lib\PropelCommandWrapper();
    $res = $wrapper->run($input);
    $this->r->finish($res);
  }

}

?>