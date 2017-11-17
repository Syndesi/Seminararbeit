<?php
set_time_limit(0);
require_once __DIR__.'/../lib/route.php';

class PropelRoute extends \lib\Route {

  public function __construct($r){
    parent::__construct($r);
    date_default_timezone_set('Europe/Berlin');
    $this->addRoute('POST:/sql/build', function($p){$this->callPropel('sql:build --overwrite');});
    $this->addRoute('POST:/sql/insert', function($p){$this->callPropel('sql:insert');});
    $this->addRoute('POST:/model/build', function($p){$this->callPropel('model:build');});
    $this->addRoute('GET:/migration/status', function($p){$this->callPropel('migration:status');});
    $this->addRoute('POST:/migrate', function($p){$this->callPropel('migrate');});
    $this->addRoute('POST:/diff', function($p){$this->callPropel('diff');});
  }

  private function callPropel($command){
    $command = realpath(__DIR__.'/../../vendor/bin/propel').' '.$command.' 2>&1';
    $res = chdir(realpath(__DIR__.'/../../'));
    $res = shell_exec($command);
    $this->r->finish($res);
  }

}

?>