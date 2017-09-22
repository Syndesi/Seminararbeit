<?php
require_once __DIR__.'/../lib/route.php';

class GeoRoute extends \lib\Route {

  private $googleApiKey = 'AIzaSyCZzatd8k_zH2szRitmdp75lgRLX2lStL8';

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/', function(){$this->info();});
    $this->addRoute('GET:/{route}', function($p){$this->getPlace($p['route']);});
  }

  private function getPlace($address){
    $place = $this->getLocationByGoogle($address);
    if($place){
      $this->r->finish($place);
    } else {
      throw new Exception('Could not get the location of the place ['.$address.'].');
    }
  }

  private function getLocationByGoogle($address){
    $addressParsed = preg_replace('/\s+/', '+', $address);
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$addressParsed.'&key='.$this->googleApiKey;
    $file = json_decode(file_get_contents($url), true);
    if($file['status'] == 'OK'){
      return $file['results'][0]['geometry']['location'];
    }
    return false;
  }

  private function info(){
    $this->r->finish('Hello world :D');
  }

}

?>