<?php

require_once __DIR__.'/../lib/route.php';
use Propel\Runtime\Propel;

class UpdateRoute extends \lib\Route {

  protected $apiUrl = 'https://api.github.com/repos/Syndesi/Seminararbeit';

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/', function($p){$this->getAvailableUpdates();});
   }

  private function getAvailableUpdates(){
    $url = $this->apiUrl.'/releases';
    //$data = file_get_contents($url);
    $data = json_decode($this->getFile($url));
    $this->r->finish($data);
  }

  /**
   * based on https://stackoverflow.com/questions/4545790/file-get-contents-returns-403-forbidden#answer-30213850
   */
  protected function getFile($url){
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($c, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64; rv:10.0) Gecko/20100101 Firefox/10.0');
    curl_setopt($c, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    $res = curl_exec($c);
    curl_close($c);
    return $res;
  }
}

?>