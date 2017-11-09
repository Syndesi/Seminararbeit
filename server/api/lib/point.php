<?php
namespace lib;

class Point implements \JsonSerializable {

  public $lng;
  public $lat;
  public $alt;
  protected $precision = 5;

  private $googleKey = 'AIzaSyCZzatd8k_zH2szRitmdp75lgRLX2lStL8'; // for Google-API's

  public function __construct($lng = 0, $lat = 0, $alt = false){
    $this->lng = $lng;
    $this->lat = $lat;
    $this->alt = $alt;
    return $this;
  }

  /**
   * Code from https://derickrethans.nl/spatial-indexes-calculating-distance.html
   */
  public function distanceTo(Point $point){
    $latA = deg2rad($this->lat);
    $lonA = deg2rad($this->lng);
    $latB = deg2rad($point->lat);
    $lonB = deg2rad($point->lng);
    $dLat = $latA - $latB;
    $dLon = $lonA - $lonB;
    $d = pow(sin($dLat/2), 2) + cos($latA) * cos($latB) * pow(sin($dLon/2), 2);
    $d = 2 * asin(sqrt($d));
    return round($d * 6371, 1); // distance in km
  }

  /**
   * Deserializes this point into an associative array for JSON.
   * @return array an array containing all necessary informations for this point.
   */
  public function jsonSerialize(){
    $res = [
      'lng' => round($this->lng, $this->precision),
      'lat' => round($this->lat, $this->precision),
      'alt' => round($this->alt, $this->precision)
    ];
    if($this->alt === false){
      unset($res['alt']);
    }
    return $res;
  }

  /**
   * Creates a new point based on an address.
   * @param  string $address The address which should be send to Google.
   * @return Point           The resulting point or false, if an error occurred.
   */
  public function fromAddress(string $address){
    $address = preg_replace('!\s+!', '+', trim($address));
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$this->googleKey;
    if(!$file = file_get_contents($url)){
      throw new Exception('The url ['.$url.'] can not be loaded.');
    }
    $file = json_decode($file, true);
    if($file['status'] != 'OK' || count($file['results']) == 0){
      return false; // no result
    }
    $lng = $file['results'][0]['geometry']['location']['lng'];
    $lat = $file['results'][0]['geometry']['location']['lat'];
    $point = new Point($lng, $lat);
    $point = $this->loadAltitude($point);
    return $point;
  }

  /**
   * Loads the altitude for the given point from the Google Elevation API.
   * @param  Point  $point The point which altitude should be updated.
   * @return Point         The point with updated altitude or false if an error occurred.
   */
  public function loadAltitude(Point $point){
    $url = 'https://maps.googleapis.com/maps/api/elevation/json?locations='.$point->lat.','.$point->lng.'&key='.$this->googleKey;
    if(!$file = file_get_contents($url)){
      throw new Exception('The url ['.$url.'] can not be loaded.');
    }
    $file = json_decode($file, true);
    if($file['status'] != 'OK' || count($file['results']) == 0){
      return false; // no result
    }
    $alt = round($file['results'][0]['elevation']);
    $point->alt = $alt;
    return $point;
  }

}

?>