<?php
set_time_limit(0);

require_once __DIR__.'/../lib/route.php';

class UbaRoute extends \lib\Route {

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/', function(){$this->r->finish('UBA API');});
    $this->addRoute('POST:/o3/{day}', function($p){$this->importO3($p['day']);}); // /api/uba/o3/2017-09-08
    $this->addRoute('POST:/so2/{day}', function($p){$this->importSO2($p['day']);}); // /api/uba/so2/2017-09-08
    $this->addRoute('POST:/pm10/{day}', function($p){$this->importPM10($p['day']);}); // /api/uba/pm10/2017-09-08
    $this->addRoute('POST:/no2/{day}', function($p){$this->importNO2($p['day']);}); // /api/uba/no2/2017-09-08
    $this->addRoute('POST:/co/{day}', function($p){$this->importCO($p['day']);}); // /api/uba/co/2017-09-08
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
    $this->r->finish('finished');
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