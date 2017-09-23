<?php
require_once __DIR__.'/../lib/route.php';

class GeoRoute extends \lib\Route {

  private $googleApiKey = 'AIzaSyCZzatd8k_zH2szRitmdp75lgRLX2lStL8';

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/place/{address}', function($p){$this->getPlace($p['address']);});
  }

  private function getPlace($address){
    $coords = $this->getCoords($address);
    if($coords){
      $altitude = $this->getAltitude($coords);
      $res = [
        'coords' => [
          'lat' => $coords['lat'],
          'lng' => $coords['lng']
        ],
        'alt' => $altitude,
        'address' => str_replace('+', ' ', $address)
      ];
      $this->r->finish($res);
    }
    throw new Exception('Could not get the location of the place ['.$address.'].');
  }

  private function getCoords($address){
    $addressParsed = preg_replace('/\s+/', '+', $address);
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$addressParsed.'&key='.$this->googleApiKey;
    $file = json_decode(file_get_contents($url), true);
    //$this->r->finish($file);
    if($file['status'] == 'OK'){
      return $file['results'][0]['geometry']['location'];
    }
    return false;
  }

  private function getAltitude($coords){
    $url = 'https://maps.googleapis.com/maps/api/elevation/json?locations='.$coords['lat'].','.$coords['lng'].'&key='.$this->googleApiKey;
    $file = json_decode(file_get_contents($url), true);
    if($file['status'] == 'OK'){
      return $file['results'][0]['elevation'];
    }
    return false;
  }

}

?>