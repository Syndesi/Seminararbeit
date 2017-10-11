<?php
set_time_limit(0);

require_once __DIR__.'/../lib/route.php';
require_once __DIR__.'/../lib/ftp.php';
require_once __DIR__.'/../lib/csv.php';

class DwdRoute extends \lib\Route {

  public function __construct($r){
    parent::__construct($r);
    $this->ftp = new \lib\FTP('ftp-cdc.dwd.de');
    $this->ftp->login();
    $this->ftp->pasv(true);
    $this->addRoute('POST:/airTemperature/{station}', function($p){$this->importAirTemperature($p['station']);});
    $this->addRoute('GET:/airTemperature', function($p){$this->importAirTemperatureStations();});
  }

  private function getStations($type){
    switch($type){
      case 'air_temp':
        $middle = 'air_temperature/recent/TU';
        break;
      case 'cloudiness':
        $middle = 'cloudiness/recent/N';
        break;
      case 'precipitation':
        $middle = 'precipitation/recent/RR';
        break;
      case 'pressure':
        $middle = 'pressure/recent/P0';
        break;
      case 'soil_temp':
        $middle = 'soil_temperature/recent/EB';
        break;
      case 'solar':
        $middle = 'solar/ST';
        break;
      case 'sun':
        $middle = 'sun/recent/SD';
        break;
      case 'wind':
        $middle = 'wind/recent/FF';
        break;
      default:
        throw new Exception('This type of data does not exist.');
        break;
    }
    $url = 'pub/CDC/observations_germany/climate/hourly/'.$middle.'_Stundenwerte_Beschreibung_Stationen.txt';
  }

  private function importAirTemperatureStations(){
    $path = 'pub/CDC/observations_germany/climate/hourly/air_temperature/recent/TU_Stundenwerte_Beschreibung_Stationen.txt';
    $path = $this->ftp->download($path);
    $res = new \lib\CSV($path);
    $res = $res->parse();
    $this->r->finish($res);
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

  private function getSpaces($lines){
    $spaces       = [];
    $leftAligned  = [];
    $rightAligned = [];
    $res          = [];
    foreach($lines as $line){
      foreach(str_split($line) as $i => $char){
        if(!array_key_exists($i, $spaces)){
          $spaces[$i] = [0, 0];
        }
        if($char == ' '){
          $spaces[$i][0]++;
        }
        $spaces[$i][1]++;
      }
    }
    foreach($spaces as $i => $space){
      $spaces[$i] = $space[0] / $space[1];
    }
    foreach($spaces as $i => $space){
      if(array_key_exists($i - 1, $spaces)){
        if($spaces[$i - 1] == 0 && $spaces[$i] > 0){
          $leftAligned[] = $i;
        }
      }
      if(array_key_exists($i + 1, $spaces)){
        if($spaces[$i + 1] == 0 && $spaces[$i] > 0){
          $rightAligned[] = $i;
        }
      }
    }
    foreach($leftAligned as $i => $pos){
      $left    = $leftAligned[$i];
      if(array_key_exists($i, $rightAligned)){
        $res[$i] = $rightAligned[$i];
      }
      if($spaces[$left - 1] == 0 && $spaces[$left] == 1){
        $res[$i] = $left;
      }
    }
    return $res;
  }

  private function splitLine($line, $headers, $spaces){
    $res = [];
    $start = 0;
    $length = 0;
    foreach($headers as $i => $header){
      if(array_key_exists($i - 1, $spaces)){
        $start = $spaces[$i - 1];
      }
      if(array_key_exists($i, $spaces)){
        $length = $spaces[$i] - $start;
      } else {
        $length = strlen($line) - $start;
      }
      $res[$header] = trim(substr($line, $start, $length));
    }
    return $res;
  }

  private function parseCSV($path){
    $header = [];
    /*
Stations_id von_datum bis_datum Stationshoehe geoBreite geoLaenge Stationsname Bundesland
----------- --------- --------- ------------- --------- --------- ----------------------------------------- ----------
00003 19500401 20110331            202     50.7827    6.0941 Aachen                                   Nordrhein-Westfalen                                                                               
00044 20070401 20171006             44     52.9335    8.2370 Großenkneten                             Niedersachsen                                                                                     
00052 19760101 19880101             46     53.6623   10.1990 Ahrensburg-Wulfsdorf                     Schleswig-Holstein                                                                                
00071 20091201 20171006            759     48.2156    8.9784 Albstadt-Badkap                          Baden-Württemberg                                                                                 
00073 20070401 20171006            340     48.6159   13.0506 Aldersbach-Kriestorf                     Bayern                                                                                            
00078 20041101 20171006             65     52.4853    7.9126 Alfhausen                                Niedersachsen                                                                                     
00091 20040901 20171006            300     50.7446    9.3450 Alsfeld-Eifa                             Hessen                                                                                            
00102 20020101 20171006             32     53.8617    8.1266 Leuchtturm Alte Weser                    Niedersachsen                                                                                     
     */
    if($file = fopen($path, 'r')){
      $header  = explode(' ', trim($this->readLine($file)));
      $divider = $this->readLine($file);
      $lines = [$this->readLine($file), $this->readLine($file), $this->readLine($file), $this->readLine($file), $this->readLine($file), $this->readLine($file), $this->readLine($file), $this->readLine($file)];
      $spaces = $this->getSpaces($lines);
      $res = [];
      foreach($lines as $line){
        $res[] = $this->splitLine($line, $header, $spaces);
      }
      /*
      while(!feof($file)){
        $line = $this->readLine($file);

        //$data = explode(';', $line);
      }*/
      fclose($file);
    } else {
      throw new Exception('Could not read the file.');
    }
    return $res;
  }

  private function readLine($file){
    $line = fgets($file);
    $line = iconv('windows-1250', 'UTF-8', $line);
    $line = str_replace("\n", '', $line);
    $line = str_replace("\r", '', $line);
    $line = str_replace('"', '', $line);
    return $line;
  }

}

?>