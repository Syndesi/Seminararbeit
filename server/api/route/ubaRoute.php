<?php
set_time_limit(0);

require_once __DIR__.'/../lib/route.php';
use Propel\Runtime\Propel;
use Map\UbaO3TableMap;
use Map\UbaSO2TableMap;
use Map\UbaPM10TableMap;
use Map\UbaNO2TableMap;
use Map\UbaCOTableMap;

class UbaRoute extends \lib\Route {

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/', function(){$this->getReport();});                                                   // /api/uba
    $this->addRoute('GET:/stations', function($p){$this->getStations();});                                       // /api/uba/stations
    $this->addRoute('GET:/stations/{network:a}', function($p){$this->getStationsByNetwork($p['network']);});     // /api/uba/stations/BY
    $this->addRoute('GET:/station/{id:i}', function($p){$this->getStationById($p['id']);});                      // /api/uba/station/1
    $this->addRoute('GET:/station/{code:a}', function($p){$this->getStationByCode($p['code']);});                // /api/uba/station/DEBB048
    // O3
    $this->addRoute('GET:/o3/{day}', function($p){$this->getValue('o3', $p['day']);});                           // /api/uba/o3/2017-09-08
    $this->addRoute('GET:/o3/{day}/{hour:i}', function($p){$this->getValue('o3', $p['day'], $p['hour']);});      // /api/uba/o3/2017-09-08/12
    $this->addRoute('POST:/o3/{day}', function($p){$this->importO3($p['day']);});                                // /api/uba/o3/2017-09-08
    // SO2
    $this->addRoute('GET:/so2/{day}', function($p){$this->getValue('so2', $p['day']);});                         // /api/uba/so2/2017-09-08
    $this->addRoute('GET:/so2/{day}/{hour:i}', function($p){$this->getValue('so2', $p['day'], $p['hour']);});    // /api/uba/so2/2017-09-08/12
    $this->addRoute('POST:/so2/{day}', function($p){$this->importSO2($p['day']);});                              // /api/uba/so2/2017-09-08
    // PM10
    $this->addRoute('GET:/pm10/{day}', function($p){$this->getValue('pm10', $p['day']);});                       // /api/uba/pm10/2017-09-08
    $this->addRoute('GET:/pm10/{day}/{hour:i}', function($p){$this->getValue('pm10', $p['day'], $p['hour']);});  // /api/uba/pm10/2017-09-08/12
    $this->addRoute('POST:/pm10/{day}', function($p){$this->importPM10($p['day']);});                            // /api/uba/pm10/2017-09-08
    // NO2
    $this->addRoute('GET:/no2/{day}', function($p){$this->getValue('no2', $p['day']);});                         // /api/uba/no2/2017-09-08
    $this->addRoute('GET:/no2/{day}/{hour:i}', function($p){$this->getValue('no2', $p['day'], $p['hour']);});    // /api/uba/no2/2017-09-08/12
    $this->addRoute('POST:/no2/{day}', function($p){$this->importNO2($p['day']);});                              // /api/uba/no2/2017-09-08
    // CO
    $this->addRoute('GET:/co/{day}', function($p){$this->getValue('co', $p['day']);});                           // /api/uba/co/2017-09-08
    $this->addRoute('GET:/co/{day}/{hour:i}', function($p){$this->getValue('co', $p['day'], $p['hour']);});      // /api/uba/co/2017-09-08/12
    $this->addRoute('POST:/co/{day}', function($p){$this->importCO($p['day']);});                                // /api/uba/co/2017-09-08
  }

  private function getReport(){
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
      $this->r->finish($entry->toArray());
    } else {
      throw new Exception('No station with the id ['.$id.'] found.');
    }
  }

  private function getStationByCode($code){
    $entry = UbaStationQuery::create()
      ->filterByCode($code)
      ->findOne();
    if($entry){
      $this->r->finish($entry->toArray());
    } else {
      throw new Exception('No station with the code ['.$code.'] found.');
    }
  }

  private function getStations(){
    $entrys = UbaStationQuery::create()->find();
    $res = [];
    foreach($entrys as $entry){
      $res[] = $entry->toArray();
    }
    $this->r->finish($res);
  }

  private function getStationsByNetwork($network){
    $entrys = UbaStationQuery::create()
      ->filterByNetwork(strtoupper($network))
      ->find();
    $res = [];
    foreach($entrys as $entry){
      $res[] = $entry->toArray();
    }
    $this->r->finish($res);
  }

  private function importO3($day){
    $start = DateTime::createFromFormat('Y-m-d', $day);
    if(!$start){
      throw new Exception('False DateTime format: Expected Y-m-d.');
    } else {
      $start->setTimeZone(new DateTimeZone('GMT'))->setTime(0, 0);
    }
    $end = clone $start;
    $end->setTime(24, 0);
    $url = 'https://www.umweltbundesamt.de/uaq/csv/stations/data?pollutant[]=O3&scope[]=1SMW&group[]=station&range[]='.$start->getTimestamp().','.$end->getTimestamp();
    $entrys = UbaO3Query::create()
      ->filterByTime(array('min' => $start->setTime(0, 1), 'max' => $end))
      ->count();
    if(0 < $entrys){
      throw new Exception('There are already '.$entrys.' O3-entrys for the day '.$start->format('d-m-Y').' saved.');
    }
    $con = Propel::getWriteConnection(UbaO3TableMap::DATABASE_NAME);
    $con->beginTransaction();
    $this->readFile($url, function($data){
      if(count($data) == 7){
        $ubaO3 = new UbaO3();
        $station = $this->getStation($data[0], $data[1], $data[2]);
        $ubaO3->setStationId($station);
        $ubaO3->setTime(DateTime::createFromFormat('d.m.Y H:i', $data[5]));
        $ubaO3->setValue($data[6]);
        $ubaO3->save();
      }
    });
    $con->commit();
    $this->r->finish('finished');
  }

  private function getValue($type, $date, $hour = false){
    $start = DateTime::createFromFormat('Y-m-d', $date);
    $end = clone $start;
    if($hour){
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

  private function getQuery($query){
    switch($query){
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
        throw new Exception('Query ['.$type.'] is unknown.');
    }
  }

  private function getO3($day, $hour = false){
    $start = DateTime::createFromFormat('Y-m-d', $day);
    $end = clone $start;
    if($hour){
      $start->setTime($hour, 1);
      $end->setTime($hour + 1, 0);
    } else {
      $start->setTime(0, 1);
      $end->setTime(24, 0);
    }
    $entrys = UbaO3Query::create()
      ->filterByTime(array('min' => $start, 'max' => $end))
      ->orderByTime()
      ->orderByStationId()
      ->limit(10);
    $res = [];
    foreach($entrys as $entry){
      $res[] = $entry->toArray();
    }
    $this->r->finish($res);
  }

  private function importSO2($day){
    $start = DateTime::createFromFormat('Y-m-d', $day);
    if(!$start){
      throw new Exception('False DateTime format: Expected Y-m-d.');
    } else {
      $start->setTimeZone(new DateTimeZone('GMT'))->setTime(0, 0);
    }
    $end = clone $start;
    $end->setTime(24, 0);
    $url = 'https://www.umweltbundesamt.de/uaq/csv/stations/data?pollutant[]=SO2&scope[]=1SMW&group[]=station&range[]='.$start->getTimestamp().','.$end->getTimestamp();
    $entrys = UbaSO2Query::create()
      ->filterByTime(array('min' => $start->setTime(0, 1), 'max' => $end))
      ->count();
    if(0 < $entrys){
      throw new Exception('There are already '.$entrys.' SO2-entrys for the day '.$start->format('d-m-Y').' saved.');
    }
    $con = Propel::getWriteConnection(UbaSO2TableMap::DATABASE_NAME);
    $con->beginTransaction();
    $this->readFile($url, function($data){
      if(count($data) == 7){
        $ubaSO2 = new UbaSO2();
        $station = $this->getStation($data[0], $data[1], $data[2]);
        $ubaSO2->setStationId($station);
        $ubaSO2->setTime(DateTime::createFromFormat('d.m.Y H:i', $data[5]));
        $ubaSO2->setValue($data[6]);
        $ubaSO2->save();
      }
    });
    $con->commit();
    $this->r->finish('finished');
  }

  private function importPM10($day){
    $start = DateTime::createFromFormat('Y-m-d', $day);
    if(!$start){
      throw new Exception('False DateTime format: Expected Y-m-d.');
    } else {
      $start->setTimeZone(new DateTimeZone('GMT'))->setTime(0, 0);
    }
    $end = clone $start;
    $end->setTime(24, 0);
    $url = 'https://www.umweltbundesamt.de/uaq/csv/stations/data?pollutant[]=PM10&scope[]=1SMW&group[]=station&range[]='.$start->getTimestamp().','.$end->getTimestamp();
    $entrys = UbaPM10Query::create()
      ->filterByTime(array('min' => $start->setTime(0, 1), 'max' => $end))
      ->count();
    if(0 < $entrys){
      throw new Exception('There are already '.$entrys.' PM10-entrys for the day '.$start->format('d-m-Y').' saved.');
    }
    $con = Propel::getWriteConnection(UbaPM10TableMap::DATABASE_NAME);
    $con->beginTransaction();
    $this->readFile($url, function($data){
      if(count($data) == 7){
        $ubaPM10 = new UbaPM10();
        $station = $this->getStation($data[0], $data[1], $data[2]);
        $ubaPM10->setStationId($station);
        $ubaPM10->setTime(DateTime::createFromFormat('d.m.Y H:i', $data[5]));
        $ubaPM10->setValue($data[6]);
        $ubaPM10->save();
      }
    });
    $con->commit();
    $this->r->finish('finished');
  }

  private function importNO2($day){
    $start = DateTime::createFromFormat('Y-m-d', $day);
    if(!$start){
      throw new Exception('False DateTime format: Expected Y-m-d.');
    } else {
      $start->setTimeZone(new DateTimeZone('GMT'))->setTime(0, 0);
    }
    $end = clone $start;
    $end->setTime(24, 0);
    $url = 'https://www.umweltbundesamt.de/uaq/csv/stations/data?pollutant[]=NO2&scope[]=1SMW&group[]=station&range[]='.$start->getTimestamp().','.$end->getTimestamp();
    $entrys = UbaNO2Query::create()
      ->filterByTime(array('min' => $start->setTime(0, 1), 'max' => $end))
      ->count();
    if(0 < $entrys){
      throw new Exception('There are already '.$entrys.' NO2-entrys for the day '.$start->format('d-m-Y').' saved.');
    }
    $con = Propel::getWriteConnection(UbaNO2TableMap::DATABASE_NAME);
    $con->beginTransaction();
    $this->readFile($url, function($data){
      if(count($data) == 7){
        $ubaNO2 = new UbaNO2();
        $station = $this->getStation($data[0], $data[1], $data[2]);
        $ubaNO2->setStationId($station);
        $ubaNO2->setTime(DateTime::createFromFormat('d.m.Y H:i', $data[5]));
        $ubaNO2->setValue($data[6]);
        $ubaNO2->save();
      }
    });
    $con->commit();
    $this->r->finish('finished');
  }

  private function importCO($day){
    $start = DateTime::createFromFormat('Y-m-d', $day);
    if(!$start){
      throw new Exception('False DateTime format: Expected Y-m-d.');
    } else {
      $start->setTimeZone(new DateTimeZone('GMT'))->setTime(0, 0);
    }
    $end = clone $start;
    $end->setTime(24, 0);
    $url = 'https://www.umweltbundesamt.de/uaq/csv/stations/data?pollutant[]=CO&scope[]=8SMW&group[]=station&range[]='.$start->getTimestamp().','.$end->getTimestamp();
    $entrys = UbaCOQuery::create()
      ->filterByTime(array('min' => $start->setTime(0, 1), 'max' => $end))
      ->count();
    if(0 < $entrys){
      throw new Exception('There are already '.$entrys.' CO-entrys for the day '.$start->format('d-m-Y').' saved.');
    }
    $con = Propel::getWriteConnection(UbaCOTableMap::DATABASE_NAME);
    $con->beginTransaction();
    $this->readFile($url, function($data){
      if(count($data) == 7){
        $ubaCO = new UbaCO();
        $station = $this->getStation($data[0], $data[1], $data[2]);
        $ubaCO->setStationId($station);
        $ubaCO->setTime(DateTime::createFromFormat('d.m.Y H:i', $data[5]));
        $ubaCO->setValue($data[6]);
        $ubaCO->save();
      }
    });
    $con->commit();
    $this->r->finish('finished');
  }

  private function readFile($url, $func){
    if($file = fopen($url, 'r')){
      $header = fgets($file);
      while(!feof($file)){
        $line = fgets($file);
        $line = iconv('windows-1250', 'UTF-8', $line);
        $line = str_replace("\n", '', $line);
        $line = str_replace('"', '', $line);
        $data = explode(';', $line);
        $func($data);
      }
      fclose($file);
    } else {
      throw new Exception('Could not read the file.');
    }
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

}

?>