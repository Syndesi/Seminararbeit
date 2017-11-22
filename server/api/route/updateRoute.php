<?php
set_time_limit(0);

require_once __DIR__.'/../lib/route.php';
use Propel\Runtime\Propel;

class UpdateRoute extends \lib\Route {

  protected $apiUrl = 'https://api.github.com/repos/Syndesi/Seminararbeit';

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/', function($p){$this->getAvailableUpdates();});
    $this->addRoute('GET:/update', function($p){$this->updateWebsite('0.0.3');});
   }

  private function getAvailableUpdates(){
    $url = $this->apiUrl.'/releases';
    $data = json_decode($this->getFile($url), true);
    $this->r->finish($data);
  }

  private function updateWebsite($version){
    $release = $this->getReleaseByVersion($version);
    $zipUrl = $release['zipball_url'];
    $zipPath = __DIR__.'/../../../update.zip';
    //file_put_contents($zipPath, file_get_contents($zipUrl));
    $this->downloadFile($zipUrl, $zipPath);
    $this->r->finish($zipPath);
  }

  private function getReleaseByVersion($version){
    $url = $this->apiUrl.'/releases';
    $data = json_decode($this->getFile($url), true);
    foreach($data as $i => $release){
      if($release['tag_name'] == $version){
        return $release;
      }
    }
    return false;
  }

  protected function downloadFile($url, $path){
    $f = fopen($path, 'w+');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 600);
    curl_setopt($ch, CURLOPT_FILE, $f);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_exec($ch); 
    curl_close($ch);
    fclose($f);
    return $url;
  }

  /**
   * based on https://stackoverflow.com/questions/4545790/file-get-contents-returns-403-forbidden#answer-30213850
   */
  protected function getFile($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
  }
}

?>