<?php
set_time_limit(0);

require_once __DIR__.'/../lib/route.php';
use Propel\Runtime\Propel;

class UbaRoute extends \lib\Route {

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/count', function($p){$this->count();});                                                                              // /api/count
    $this->addRoute('GET:/stations', function($p){$this->getStations();});                                                                     // /api/uba/stations
    $this->addRoute('GET:/stations/{network:a}', function($p){$this->getStationsByNetwork($p['network']);});                                   // /api/uba/stations/BY
    $this->addRoute('GET:/station/{id:i}', function($p){$this->getStationById($p['id']);});                                                    // /api/uba/station/1
    $this->addRoute('GET:/station/{id:i}/{day:d}', function($p){$this->getStationValue($p['id'], $p['day']);});                                // /api/uba/station/1/2017-09-20
    $this->addRoute('GET:/station/{id:i}/{day:d}/{hour:i}', function($p){$this->getStationValue($p['id'], $p['day'], $p['hour']);});           // /api/uba/station/1/2017-09-20/7
    $this->addRoute('GET:/station/{code:a}', function($p){$this->getStationByCode($p['code']);});                                              // /api/uba/station/DEBB048
    // substances (o3, no3, pm10, so2, co)
    $this->addRoute('GET:/{substance:a}/{day:d}', function($p){$this->getValue($p['substance'], $p['day']);});                                 // /api/uba/o3/2017-09-08
    $this->addRoute('GET:/{substance:a}/{day:d}/{hour:i}', function($p){$this->getValue($p['substance'], $p['day'], $p['hour']);});            // /api/uba/o3/2017-09-08/12
    $this->addRoute('GET:/{substance:a}/report/{day:d}', function($p){$this->getReport($p['substance'], $p['day']);});                         // /api/uba/o3/report/2017-09-08
    $this->addRoute('GET:/{substance:a}/report/{day:d}/{hour:i}', function($p){$this->getReport($p['substance'], $p['day'], $p['hour']);});    // /api/uba/o3/report/2017-09-08/7
    $this->addRoute('POST:/{substance:a}/{day:d}', function($p){$this->importSubstance($p['substance'], $p['day']);});                         // /api/uba/o3/2017-09-08
  }

  private function count(){
    $tables = [
      "NO2"  => UbaNO2Query::create()->count(),
      "PM10" => UbaPM10Query::create()->count(),
      "O3"   => UbaO3Query::create()->count(),
      "SO2"  => UbaSO2Query::create()->count(),
      "CO"   => UbaCOQuery::create()->count()
    ];
    $data = [
      "total"  => $tables["NO2"]+$tables["PM10"]+$tables["O3"]+$tables["CO"]+$tables["SO2"],
      "tables" => $tables
    ];
    $this->r->finish($data);
  }

  private function getStationById($id = 0){
    $entry = UbaStationQuery::create()->findPK($id);
    if($entry){
      $this->r->finish($this->stationToArray($entry));
    } else {
      throw new Exception('No station with the id ['.$id.'] found.');
    }
  }

  private function getStationByCode($code){
    $entry = UbaStationQuery::create()
      ->filterByCode($code)
      ->findOne();
    if($entry){
      $this->r->finish($this->stationToArray($entry));
    } else {
      throw new Exception('No station with the code ['.$code.'] found.');
    }
  }

  private function stationToArray($station){
    return [
      'id'         => $station->getId(),
      'name'       => $station->getName(),
      'code'       => $station->getCode(),
      'network'    => $station->getNetwork(),
      'coordinate' => [
        'lat'      => $station->getLat(),
        'lng'      => $station->getLng(),
        'alt'      => $station->getAlt()
      ]
    ];
  }

  private function getStationValue($station, $day, $hour = false){
    $start = DateTime::createFromFormat('Y-m-d', $day);
    $end = clone $start;
    if($hour !== false){
      $start->setTime($hour, 1);
      $end->setTime($hour + 1, 0);
    } else {
      $start->setTime(0, 1);
      $end->setTime(24, 0);
    }
    $res = [
      'o3'   => $this->getStationSubstanceValue($station, 'o3', $start, $end),
      'no2'  => $this->getStationSubstanceValue($station, 'no2', $start, $end),
      'so2'  => $this->getStationSubstanceValue($station, 'so2', $start, $end),
      'co'   => $this->getStationSubstanceValue($station, 'co', $start, $end),
      'pm10' => $this->getStationSubstanceValue($station, 'pm10', $start, $end),
    ];
    foreach($res as $i => $a){
      if($a === false){
        unset($res[$i]);
      }
    }
    $this->r->finish($res);
  }

  private function getStationSubstanceValue($station, $substance, $start, $end){
    $entrys = $this->getQuery($substance)
      ->filterByStationId($station)
      ->filterByTime(array('min' => $start, 'max' => $end))
      ->orderByTime()
      ->orderByStationId();
    $res = [];
    foreach($entrys as $entry){
      $res[$entry->getTime()->format('d.m.Y H:i')] = $entry->getValue();
    }
    if(count($res) == 0){
      $res = false;
    }
    return $res;
  }

  private function getStations(){
    $entrys = UbaStationQuery::create()->find();
    $res = [];
    foreach($entrys as $entry){
      $res[$entry->getId()] = $this->stationToArray($entry);
    }
    $this->r->finish($res);
  }

  private function getStationsByNetwork($network){
    $entrys = UbaStationQuery::create()
      ->filterByNetwork(strtoupper($network))
      ->find();
    $res = [];
    foreach($entrys as $entry){
      $res[$entry->getId()] = $this->stationToArray($entry);
    }
    $this->r->finish($res);
  }

  private function importSubstance($substance, $day){
    $start = DateTime::createFromFormat('Y-m-d', $day);
    if(!$start){
      throw new Exception('False DateTime format: Expected Y-m-d.');
    } else {
      $start->setTimeZone(new DateTimeZone('GMT'))->setTime(0, 0);
    }
    $end = clone $start;
    $end->setTime(24, 0);
    switch($substance){
      case 'o3':
        $urlParam        = 'pollutant[]=O3&scope[]=1SMW';
        $database        = Map\UbaO3TableMap::DATABASE_NAME;
        $substanceObject = 'UbaO3';
        break;
      case 'so2':
        $urlParam        = 'pollutant[]=SO2&scope[]=1SMW';
        $database        = Map\UbaSO2TableMap::DATABASE_NAME;
        $substanceObject = 'UbaSO2';
        break;
      case 'no2':
        $urlParam        = 'pollutant[]=NO2&scope[]=1SMW';
        $database        = Map\UbaNO2TableMap::DATABASE_NAME;
        $substanceObject = 'UbaNO2';
        break;
      case 'co':
        $urlParam        = 'pollutant[]=CO&scope[]=8SMW';
        $database        = Map\UbaCOTableMap::DATABASE_NAME;
        $substanceObject = 'UbaCO';
        break;
      case 'pm10':
        $urlParam        = 'pollutant[]=PM10&scope[]=1SMW';
        $database        = Map\UbaPM10TableMap::DATABASE_NAME;
        $substanceObject = 'UbaPM10';
        break;
      default:
        throw new Exception('The substance ['.$substance.'] is unknown.');
        break;
    }
    $url = 'https://www.umweltbundesamt.de/uaq/csv/stations/data?'.$urlParam.'&group[]=station&range[]='.$start->getTimestamp().','.$end->getTimestamp();
    $entrys = $this->getQuery($substance)
      ->filterByTime(array('min' => $start->setTime(0, 1), 'max' => $end))
      ->count();
    if(0 < $entrys){
      throw new Exception('There are already '.$entrys.' '.strtoupper($substance).'-entrys for the day '.$start->format('d-m-Y').' saved.');
    }
    $con = Propel::getWriteConnection($database);
    $con->beginTransaction();
    if($file = fopen($url, 'r')){
      $header = fgets($file);
      while(!feof($file)){
        $line = fgets($file);
        $line = iconv('windows-1250', 'UTF-8', $line);
        $line = str_replace("\n", '', $line);
        $line = str_replace('"', '', $line);
        $data = explode(';', $line);
        if(count($data) == 7){
          // import one line
          $substanceEntry = new $substanceObject();
          $station = $this->getStation($data[0], $data[1], $data[2]);
          $substanceEntry->setStationId($station);
          $substanceEntry->setTime(DateTime::createFromFormat('d.m.Y H:i', $data[5]));
          $substanceEntry->setValue($data[6]);
          $substanceEntry->save();
        }
      }
      fclose($file);
    } else {
      throw new Exception('Could not read the file.');
    }
    $con->commit();
    $this->r->finish('finished');
  }

  private function getStation($code, $name, $network){
    $station = UbaStationQuery::create()
      ->filterByCode($code)
      ->findOne();
    if(!$station){
      $station = new UbaStation();
      $station->setName($name);
      $station->setCode($code);
      $station->setNetwork($network);
      $station->save();
    }
    return $station->getId();
  }

  private function getValue($type, $date, $hour = false){
    $start = DateTime::createFromFormat('Y-m-d', $date);
    $end = clone $start;
    if($hour !== false){
      $start->setTime($hour, 1);
      $end->setTime($hour + 1, 0);
    } else {
      $start->setTime(0, 1);
      $end->setTime(24, 0);
    }
    $entrys = $this->getQuery($type)
      ->filterByTime(array('min' => $start, 'max' => $end))
      ->orderByTime()
      ->orderByStationId();
    $res = [];
    foreach($entrys as $entry){
      $time = $entry->getTime()->format('d.m.Y H:i');
      if(!array_key_exists($time, $res)){
        $res[$time] = [];
      }
      $res[$time][$entry->getStationId()] = $entry->getValue();
    }
    $this->r->finish($res);
  }

  private function getReport($type, $date, $hour = false){
    $start = DateTime::createFromFormat('Y-m-d', $date);
    $end = clone $start;
    if($hour !== false){
      $start->setTime($hour, 1);
      $end->setTime($hour + 1, 0);
    } else {
      $start->setTime(0, 1);
      $end->setTime(24, 0);
    }
    $entrys = $this->getQuery($type)
      ->filterByTime(array('min' => $start, 'max' => $end))
      ->orderByTime()
      ->orderByValue();
    $tmp = [];
    foreach($entrys as $entry){
      $time = $entry->getTime()->format('d.m.Y H:i');
      if(!array_key_exists($time, $tmp)){
        $tmp[$time] = [];
      }
      $tmp[$time][] = $entry->getValue();
    }
    if(count($tmp) == 0){
      throw new Exception('No data for the date ['.$start->format('Y-m-d').'] available.');
    }
    $res = [];
    foreach($tmp as $time => $v){
      $el = count($v);
      asort($v);
      $average = 0;
      foreach($v as $value){
        $average += $value;
      }
      $res[$time] = [
        '0.00' => $v[0],
        '0.25' => $v[round($el * 0.25 - 1)],
        '0.50' => $v[round($el * 0.50 - 1)],
        '0.75' => $v[round($el * 0.75 - 1)],
        '1.00' => $v[$el - 1],
        'trimean' => round(($v[round($el * 0.25 - 1)] + 2*$v[round($el * 0.50 - 1)] + $v[round($el * 0.75 - 1)]) / 4, 2),
        'average' => round($average / $el, 2)
      ];
    }
    $this->r->finish($res);
  }

  private function getQuery($substance){
    switch($substance){
      case 'o3':
        return UbaO3Query::create();
      case 'no2':
        return UbaNO2Query::create();
      case 'pm10':
        return UbaPM10Query::create();
      case 'so2':
        return UbaSO2Query::create();
      case 'co':
        return UbaCOQuery::create();
      default:
        throw new Exception('Substance ['.$substance.'] is unknown.');
    }
  }

}

?>