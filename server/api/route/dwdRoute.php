<?php
set_time_limit(0);

require_once __DIR__.'/../lib/route.php';
require_once __DIR__.'/../lib/ftp.php';

class DwdRoute extends \lib\Route {

  public function __construct($r){
    parent::__construct($r);
    $this->ftp = new \lib\FTP('ftp-cdc.dwd.de');
    $this->ftp->login();
    $this->ftp->pasv(true);
    $this->addRoute('POST:/airTemperature/{station}', function($p){$this->importAirTemperature($p['station']);}); // /api/uba/o3/2017-09-08
  }

  private function importAirTemperature($station){
    // ftp://ftp-cdc.dwd.de/pub/CDC/observations_germany/climate/hourly/air_temperature/
    // ftp://ftp-cdc.dwd.de/pub/CDC/observations_germany/climate/hourly/air_temperature/recent/stundenwerte_TU_00071_akt.zip
    $path = 'pub/CDC/observations_germany/climate/hourly/air_temperature/recent/stundenwerte_TU_'.$station.'_akt.zip';
    $tmp = $this->ftp->downloadZip($path);
    $this->r->finish([$tmp, scandir($tmp)]);
    //$list = $this->ftp->scandir('pub/CDC/observations_germany/climate/hourly/air_temperature/recent/');
    //$this->r->finish($list);
  }

}

?>