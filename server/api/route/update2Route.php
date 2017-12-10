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
    $this->addRoute('GET:/config', function($p){$this->testPropelConfig();});
    $this->addRoute('POST:/update/{version}', function($p){$this->update($p['version']);});
    $this->addRoute('POST:/postupdate', function($p){$this->applyingUpdate();});
  }


  /* OLD SOFTWARE: DOWNLOADING UPDATE AND MIGRATING CONFIG */

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
    $this->migrateConfig(__DIR__.'/../../', $destination);
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

  private function migrateConfig($from, $to){
    $oldConfig = json_decode(file_get_contents($from.'config.json'), true);
    $newConfig = json_decode(file_get_contents($to.'config.json'), true);
    $this->migrateObject($oldConfig, $newConfig);
    file_put_contents($to.'config.json', json_encode($newConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    return true;
  }

  /**
   * Merges two objects in a way, that old settings overwrite new settings but only if they still exists.
   * @param  object  $old The old object.
   * @param  object  $new The new object.
   * @return object       The unified object.
   */
  private function migrateObject($old, $new){
    $res = $new;
    foreach($old as $i => $element){
      if(array_key_exists($i, $new)){
        if(!is_array($element)){
          $res[$i] = $element;
        } else {
          $res[$i] = migrateObject($element, $new[$i]);
        }
      }
    }
    return $res;
  }


  /* NEW SOFTWARE: APPLYING THE NEW CONFIG */

  private function applyingUpdate(){
    $config = json_decode(file_get_contents(__DIR__.'/../../config.json'), true);
    $res = [
      'config' => $config,
      'propel' => [
        'config'  => false,
        'diff'    => false,
        'migrate' => false
      ]
    ];
    // updating Propel's config
    $tmp = $config['settings']['database'];
    $propel = json_decode(file_get_contents(__DIR__.'/../../config/propel.json'), true);
    $propel['propel']['database']['connections']['default']['dsn']      = 'mysql:host='.$tmp['host'].';dbname='.$tmp['database'];
    $propel['propel']['database']['connections']['default']['user']     = $tmp['user'];
    $propel['propel']['database']['connections']['default']['password'] = $tmp['password'];
    file_put_contents(__DIR__.'/../../config/propel.json', json_encode($propel, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    $res['propel']['config'] = $propel;
    // Calling Propel's migration commands
    $propel = new \lib\PropelCommandWrapper();
    $res['propel']['diff']    = $propel->run(['command' => 'diff']);
    $res['propel']['migrate'] = $propel->run(['command' => 'migrate']);
    $this->r->finish($res);
  }

  private function initConfig($host, $database, $user, $password){
    $config = json_decode(file_get_contents(__DIR__.'/../../'.$this->propelConfigPath), true);
    $config['propel']['database']['connections']['default']['dsn']      = 'mysql:host='.$host.';dbname='.$database;
    $config['propel']['database']['connections']['default']['user']     = $user;
    $config['propel']['database']['connections']['default']['password'] = $password;
    file_put_contents(__DIR__.'/../../'.$this->propelConfigPath, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
  }

}

?>