<?php

require_once __DIR__.'/../lib/route.php';

class MapRoute extends \lib\Route {

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/{z:i}/{x:i}/{y:i}', function($p){$this->getMap($p['z'], $p['x'], $p['y']);});
  }

  protected function getMap($z, $x, $y){
    $url = 'https://api.mapbox.com/v4/mapbox.terrain-rgb/'.$z.'/'.$x.'/'.$y.'.pngraw?access_token=pk.eyJ1Ijoic29lcmVua2xlaW4iLCJhIjoiTFhjai1qcyJ9.JvmV0WKbbrySeFyHJQYRfg';
    //$image = file_get_contents($url);
    $img = @imagecreatefrompng($url)
          or die('Cannot Initialize new GD image stream 1');
    $width = imagesx($img);
    $height = imagesy($img);
    $img2 = @imagecreate($width, $height)
          or die('Cannot Initialize new GD image stream 2');
    for($y = 0;$y < $height;$y++){
      for($x = 0;$x < $width;$x++){
        $rgb = imagecolorat($img, $x, $y);
        //$r = ($rgb >> 16) & 0xFF;
        //$g = ($rgb >> 8) & 0xFF;
        //$b = $rgb & 0xFF;
        // 1 unit = 0.1m
        // equation based on https://blog.mapbox.com/global-elevation-data-6689f1d0ba65
        $height = -10000 + ($rgb * 0.1);
        // map to -1km ... 7km
        $bw = round(($height + 10000)/80000 * 256);
        imagesetpixel($img2, $x, $y, imagecolorallocate($img2, $bw, $bw, $bw));
        imagesetpixel($img2, $x, $y, $rgb);
      }
    }

    $text_color = imagecolorallocate($img, 233, 14, 91);
    header ('Content-Type: image/png');
    header('X-Powered-By: Syndesi');
    header('Access-Control-Allow-Origin: *');
    //$origin = '*';
    //if(array_key_exists('HTTP_ORIGIN', $_SERVER)){
    //  $origin = $_SERVER['HTTP_ORIGIN'];
    //}
    //header('Access-Control-Allow-Origin: '.$origin);
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization, X-Requested-With, Accept, Client-Security-Token');
    header('Accept: application/json, application/xml, text/xml, application/x-yaml, text/yaml, application/x-www-form-urlencoded, multipart/form-data');
    imagestring($img2, 1, 5, 5,  'demo', $text_color);
    imagepng($img2);
    imagedestroy($img);
    imagedestroy($img2);
    exit;
  }

}

?>