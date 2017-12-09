<?php
set_time_limit(0);

require_once __DIR__.'/../lib/route.php';
require_once __DIR__.'/../lib/file.php';
require_once __DIR__.'/../lib/http.php';
require_once __DIR__.'/../lib/propelCommandWrapper.php';
require_once __DIR__.'/../lib/zip.php';
use Propel\Runtime\Propel;

class Update2Route extends \lib\Route {

  protected $propelConfigPath = __DIR__.'/../../config/propel.json';
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
    $zipPath = __DIR__.'/../../../../update.zip';
    $tmpPath = __DIR__.'/../../update/';
    $release = $this->getReleaseByVersion($version);
    lib\downloadWebContent($release['zipball_url'], $zipPath);
    lib\unzip($zipPath, $tmpPath);
    lib\mv(realpath($tmpPath.'/'.scandir($tmpPath)[2].'/server'), $destination);
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

  private function setPropelConfig($host, $database, $user, $password){
    $config = json_decode(file_get_contents($this->propelConfigPath), true);
    $config['propel']['database']['connections']['default']['dsn']      = 'mysql:host='.$host.';dbname='.$database;
    $config['propel']['database']['connections']['default']['user']     = $user;
    $config['propel']['database']['connections']['default']['password'] = $password;
    // uncomment this only in productive mode!
    //file_put_contents($this->propelConfigPath, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    return 'finished';
  }

  private function testPropelConfig(){
    $res = $this->setPropelConfig('localhost', 'seminararbeit', 'seminararbeit', 'Proton13by');
    $this->r->finish($res);
  }

}

?>