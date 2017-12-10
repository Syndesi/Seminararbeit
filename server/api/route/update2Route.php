<?php
set_time_limit(0);

require_once __DIR__.'/../lib/route.php';
require_once __DIR__.'/../lib/file.php';
require_once __DIR__.'/../lib/http.php';
require_once __DIR__.'/../lib/propelCommandWrapper.php';
require_once __DIR__.'/../lib/zip.php';
use Propel\Runtime\Propel;

class Update2Route extends \lib\Route {

  protected $propelConfigPath = 'config/propel.json';
  protected $apiUrl           = 'https://api.github.com/repos/Syndesi/Seminararbeit';

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/', function($p){$this->getAvailableUpdates();});
    //$this->addRoute('GET:/update', function($p){$this->updateWebsite('0.0.3');});
    //$this->addRoute('GET:/demo', function($p){$this->demo();});
    $this->addRoute('GET:/config', function($p){$this->testPropelConfig();});
    $this->addRoute('POST:/update/{version}', function($p){$this->update($p['version']);});
  }

  private function update($version, $destination = false){
    if(!$destination){
      $destination = realpath(__DIR__.'/../../../../').'/seminararbeit_updated'.'/';
    }
    $zipPath = __DIR__.'/../../update.zip';
    $tmpPath = __DIR__.'/../../update/';
    $release = $this->getReleaseByVersion($version);
    lib\downloadWebContent($release['zipball_url'], $zipPath);
    lib\unzip($zipPath, $tmpPath);
    lib\cp(realpath($tmpPath.'/'.scandir($tmpPath)[2].'/server'), $destination);
    $this->copyConfig(__DIR__.'/../../', $destination);
    lib\rm($zipPath);
    lib\rm($tmpPath);
    $this->r->finish($release);
  }

  private function getAvailableUpdates(){
    $url = $this->apiUrl.'/releases';
    $data = json_decode(lib\getWebContent($url), true);
    $this->r->finish($data);
  }

  private function getReleaseByVersion($version){
    $url = $this->apiUrl.'/releases';
    $data = json_decode(lib\getWebContent($url), true);
    foreach($data as $i => $release){
      if($release['tag_name'] == $version){
        return $release;
      }
    }
    return false;
  }

  private function copyConfig($from, $to){
    // Propel config
    $oldConfig = json_decode(file_get_contents($from.$this->propelConfigPath), true);
    $newConfig = json_decode(file_get_contents($to.$this->propelConfigPath), true);
    $oldConfig = $oldConfig['propel']['database']['connections']['default'];
    $newConfig['propel']['database']['connections']['default']['dsn']      = $oldConfig['dsn'];
    $newConfig['propel']['database']['connections']['default']['user']     = $oldConfig['user'];
    $newConfig['propel']['database']['connections']['default']['password'] = $oldConfig['password'];
    file_put_contents($to.$this->propelConfigPath, json_encode($newConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
  }

  private function initConfig($host, $database, $user, $password){
    $config = json_decode(file_get_contents(__DIR__.'/../../'.$this->propelConfigPath), true);
    $config['propel']['database']['connections']['default']['dsn']      = 'mysql:host='.$host.';dbname='.$database;
    $config['propel']['database']['connections']['default']['user']     = $user;
    $config['propel']['database']['connections']['default']['password'] = $password;
    file_put_contents(__DIR__.'/../../'.$this->propelConfigPath, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
  }

  private function testPropelConfig(){
    $res = $this->setPropelConfig('localhost', 'seminararbeit', 'seminararbeit', 'Proton13by');
    $this->r->finish($res);
  }

}

?>