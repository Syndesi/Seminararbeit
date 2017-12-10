<?php
require_once __DIR__.'/../lib/route.php';
require_once __DIR__.'/../lib/point.php';

class GeoRoute extends \lib\Route {

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/place/{address}', function($p){$this->getPlace($p['address']);});
    $this->config = lib\getConfig();
  }

  private function getPlace($address){
    $point = new lib\point();
    $point = $point->fromAddress($address);
    $res = [
      'coords' => [
        'lat' => $point->lat,
        'lng' => $point->lng
      ],
      'alt' => $point->alt,
      'address' => str_replace('+', ' ', $address)
    ];
    $this->r->finish($res);
  }

}

?>