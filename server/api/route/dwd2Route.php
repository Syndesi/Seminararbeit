<?php
set_time_limit(0);
require_once __DIR__.'/../lib/route.php';
use Propel\Runtime\Propel;

class Dwd2Route extends \lib\Route {

  private $types = [
    'TU' => 'air_temperature/recent',
    'N'  => 'cloudiness',
    'RR' => 'precipitation',
    'P0' => 'pressure',
    'EB' => 'soil_temperature',
    'ST' => 'solar',
    'SD' => 'sun',
    'FF' => 'wind'
  ];

  private $types2 = [
    'TU' => ['air_temperature/historical', 'air_temperature/recent'],
    'N'  => ['cloudiness/historical', 'cloudiness/recent'],
    'RR' => ['precipitation/historical', 'precipitation/recent'],
    'P0' => ['pressure/historical', 'pressure/recent'],
    'EB' => ['soil_temperature/historical', 'soil_temperature/recent'],
    'ST' => ['solar'],
    'SD' => ['sun/historical', 'sun/recent'],
    'FF' => ['wind/historical', 'wind/recent']
  ];

  private $tmp         = __DIR__.'/../../tmp/';
  private $ftp         = 'ftp-cdc.dwd.de';
  private $maxTmpFiles = 20;

  public function __construct($r){
    parent::__construct($r);
    date_default_timezone_set('Europe/Berlin');
    $this->addRoute('POST:/import/{station:i}/{type:a}', function($p){$this->importData($p['station'], $p['type']);});
    // import functions
    //$this->addRoute('POST:/{type:a}/{station:i}', function($p){$this->importStationData($p['type'], $p['station']);});
    // display functions
    //$this->addRoute('GET:/{type:a}', function($p){$this->displayDataOverview($p['type']);});
    //$this->addRoute('GET:/{type:a}/{station:i}', function($p){$this->displayDataOverview($p['type']);});
  }

  // routes

  private function timestampToDateTime(string $ts){
    // 2016042801
    $dateTime = new \DateTime();
    $dateTime->setDate(substr($ts, 0, 4), substr($ts, 4, 2), substr($ts, 6, 2));
    $dateTime->setTime(substr($ts, 8, 2), 0);
    return $dateTime;
  }

  private function getStationId($id, $name = 'unknown'){
    $station = DwdStationQuery::create()->findPK($id);
    if(!$station){
      $station = new DwdStation();
      $station->setId($id);
      $station->setName($name);
      $station->save();
    }
    return $station->getId();
  }

  private function filterFalse($value){
    if($value == '-999'){
      return null;
    }
    return $value;
  }

  private function getFileUrl($type, $station){
    $dir = 'pub/CDC/observations_germany/climate/hourly/'.$type;
    $ftp = $this->getFtpConnection();
    $paths = ftp_nlist($ftp, $dir);
    $paths = preg_grep('/_'.$station.'_/', $paths);
    if(!$paths){
      return false;
    }
    return array_shift($paths);
  }

  private function importData(string $station, string $type){
    $type = strtoupper($type);
    if(!array_key_exists($type, $this->types2)){
      throw new Exception('Unknown type ['.$type.'].');
    }
    $insertedEntrys = 0;
    $minDate = new \DateTime();
    $minDate->setDate(2007, 1, 1);
    $minDate->setTime(0, 0);
    foreach($this->types2[$type] as $i => $part){
      $url = $this->getFileUrl($part, $station);
      if(!$url){
        throw new Exception('The station ['.$station.'] does not have the type ['.$type.'].');
      }
      $directory = $this->downloadZip($url);
      $path = $this->searchPathsForFile($directory, 'produkt', 'txt');
      if($file = fopen($path, 'r')){
        $header = $this->parseCsvLine($file);
        $data   = [];
        $i = 0;
        $stationId = $this->getStationId(intval($station));
        Propel::disableInstancePooling(); // needed for 100k+ inserted rows...
        $con = Propel::getWriteConnection(Map\DwdAirTemperatureTableMap::DATABASE_NAME);
        $con->beginTransaction();
        while(!feof($file)){
          $values = $this->parseCsvLine($file);
          if($values){
            $data = array_combine($header, $values);
            $time = $this->timestampToDateTime($data['MESS_DATUM']);
            if($minDate <= $time){
              switch($type){
                case 'TU':
                  $entry = new DwdAirTemperature();
                  $entry->setQuality($data['QN_9']);
                  $entry->setTtTu($this->filterFalse($data['TT_TU']));
                  $entry->setRfTu($this->filterFalse($data['RF_TU']));
                  break;
                case 'N':
                  $entry = new DwdCloudines();
                  $entry->setQuality($data['QN_8']);
                  $entry->setVNI($data['V_N_I']);
                  $entry->setVN($data['V_N']);
                  break;
                case 'RR':
                  $entry = new DwdPrecipitation();
                  $entry->setQuality($data['QN_8']);
                  $entry->setR1($data['R1']);
                  $entry->setRsInd($data['RS_IND']);
                  $entry->setWrtr($data['WRTR']);
                  break;
                case 'P0':
                  $entry = new DwdPressure();
                  $entry->setQuality($data['QN_8']);
                  $entry->setP($data['P']);
                  $entry->setP0($data['P0']);
                  break;
                case 'EB':
                  $entry = new DwdSoilTemperature();
                  $entry->setQuality($data['QN_2']);
                  $entry->setVTe002($data['V_TE002']);
                  $entry->setVTe005($data['V_TE005']);
                  $entry->setVTe010($data['V_TE010']);
                  $entry->setVTe020($data['V_TE020']);
                  $entry->setVTe050($data['V_TE050']);
                  $entry->setVTe100($data['V_TE100']);
                  break;
                case 'ST':
                  $entry = new DwdSolar();
                  $entry->setQuality($data['QN_592']);
                  $entry->setAtmoLberg($data['ATMO_LBERG']);
                  $entry->setFdLberg($data['FD_LBERG']);
                  $entry->setFgLberg($data['FG_LBERG']);
                  $entry->setSdLberg($data['SD_LBERG']);
                  $entry->setZenit($data['ZENIT']);
                  break;
                case 'SD':
                  $entry = new DwdSun();
                  $entry->setQuality($data['QN_7']);
                  $entry->setSdSo($data['SD_SO']);
                  break;
                case 'FF':
                  $entry = new DwdWind();
                  $entry->setQuality($data['QN_3']);
                  $entry->setF($data['F']);
                  $entry->setD($data['D']);
                  break;
                default:
                  throw new Exception('Unknown type ['.$type.'].');
                  break;
              }
              $entry->setStationId($stationId);
              $entry->setTime($time);
              $entry->save();
              $insertedEntrys++;
              $i++;
              if($i >= 250){
                $i = 0;
                $con->commit();
                $con->beginTransaction();
              }
            }
          }
        }
        $con->commit();
      }
    }
    //$url = $this->getFile();
    //$url = 'pub/CDC/observations_germany/climate/hourly/'.$this->getType($type).'/stundenwerte_'.strtoupper($type).'_'.$station.'_akt.zip';
    $this->r->finish('Inserted entrys: '.$insertedEntrys);
  }

  private function searchPathsForFile($directory, $key, $extension){
    if(!is_dir($directory)){
      return false;
    }
    foreach(scandir($directory) as $path){
      if(strstr($path, $key) && pathinfo($path, PATHINFO_EXTENSION) == $extension){
        return realpath($directory.'/'.$path);
      }
    }
    return false;
  }

  private function importStations($type){
    $path = 'SD_Stundenwerte_Beschreibung_Stationen.txt';
  }

  private function getType($type){
    $type = trim(strtoupper($type));
    if(!array_key_exists($type, $this->types2)){
      return false;
    }
    return $this->types2[$type];
  }

  private function importStationData($type, $station){
    $path = 'stundenwerte_FF_{station}_akt.zip';
  }

  // helper-functions

  // FTP-helper-functions

  private function getFtpConnection(){
    $ftp = ftp_connect($this->ftp);
    if(!$ftp){
      throw new Exception('FTP: Connection could not be created.');
    }
    if(!ftp_login($ftp, 'anonymous', '')){
      throw new Exception('FTP: Unable to login.');
    }
    if(!ftp_pasv($ftp, true)){
      throw new Exception('FTP: Could not enable passive-mode.');
    }
    return $ftp;
  }

  /**
   * Downloads a file from a FTP-Server and returns the path to the temporary file.
   * @param  string      $urlPath The file-path on the FTP-server.
   * @return string|bool          The file-path to the local, temporary file or false in case of an error.
   */
  private function downloadFile($urlPath){
    $ftp = $this->getFtpConnection();
    $tmpPath = $this->tmp.basename($urlPath);
    $status = ftp_get($ftp, $tmpPath, $urlPath, FTP_BINARY);
    if($status){
      return realpath($tmpPath);
    }
    if(is_file($tmpPath)){
      unlink($tmpPath);
    }
    return false;
  }

  /**
   * Downloads a ZIP-file, extracts it and returns the path to it.
   * @param  string      $urlPath The file-path on the FTP-server.
   * @return string|bool          The path to the generated folder or false in case of an error.
   */
  private function downloadZip($urlPath){
    $this->cleanTmpFolder();
    $path = $this->downloadFile($urlPath);
    $folder = $this->tmp.date('Ymd-His').'-'.uniqid().' '.pathinfo($urlPath, PATHINFO_FILENAME); // .'_'.pathinfo($urlPath, PATHINFO_FILENAME)
    if($path){
      $zip = new \ZipArchive;
      if($zip->open($path) === true){
        $zip->extractTo($folder);
        $zip->close();
        unlink($path);
        return realpath($folder);
      }
    }
    return false;
  }

  private function cleanTmpFolder(){
    $paths = scandir($this->tmp);
    unset($paths[0]);
    unset($paths[1]);
    asort($paths);
    $length = count($paths) - $this->maxTmpFiles;
    if($length > 0){
      $toDelete = array_slice($paths, 0, $length);
      foreach($toDelete as $path){
        $path = realpath($this->tmp.$path);
        if(is_dir($path)){
          $this->delTree($path);
        }
      }
    }
  }

  /**
   * from http://php.net/manual/de/function.rmdir.php#110489
   */
  public static function delTree($dir){
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file){
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
  }

  // CSV-helper-functions

  /**
   * Reads a CSV-file line by line and returns the data as a associative array.
   * @param  string     $path The path to the CSV-file.
   * @return array|bool       The resulting array or false if an error occurred.
   */
  private function readCsvFile($path){
    if($file = fopen($path, 'r')){
      $header = $this->parseCsvLine($file);
      $data   = [];
      while(!feof($file)){
        $data[] = array_combine($header, $this->parseCsvLine($file));
      }
      return $data;
    }
    return false;
  }

  /**
   * Parses a single line of the given CSV-file and returns an array of it's trimed values.
   * @param  handle $file The file-handle.
   * @return array        An array of the values writen in the line.
   */
  private function parseCsvLine($file){
    $line = fgets($file);
    if(!$line || trim($line) == ''){
      return false;
    }
    $line = iconv('windows-1250', 'UTF-8', $line);
    $line = str_replace("\n",   '', $line);
    $line = str_replace("\r",   '', $line);
    $line = str_replace('"',    '', $line);
    $line = str_replace(';eor', '', $line);
    $line = array_map('trim', explode(';', $line));
    return $line;
  }

}

?>