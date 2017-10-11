<?php
require_once __DIR__.'/../lib/route.php';

class Dwd2Route extends \lib\Route {

  private $types = [
    'TU' => 'airtemperature',
    'N'  => 'cloudiness',
    'RR' => 'precipitation',
    'P0' => 'pressure',
    'EB' => 'soil_temperature',
    'ST' => 'solar',
    'SD' => 'sun',
    'FF' => 'wind'
  ];

  private $tmp = __DIR__.'/../../tmp/';
  private $ftp = 'ftp-cdc.dwd.de';

  public function __construct($r){
    parent::__construct($r);
    $this->addRoute('GET:/demo', function(){$this->demo();});
    // import functions
    //$this->addRoute('POST:/{type:a}/{station:i}', function($p){$this->importStationData($p['type'], $p['station']);});
    // display functions
    //$this->addRoute('GET:/{type:a}', function($p){$this->displayDataOverview($p['type']);});
    //$this->addRoute('GET:/{type:a}/{station:i}', function($p){$this->displayDataOverview($p['type']);});
  }

  // routes

  private function demo(){
    $path = $this->downloadZip('pub/CDC/observations_germany/climate/hourly/air_temperature/recent/stundenwerte_TU_00102_akt.zip');
    if($file = fopen($path.'/produkt_tu_stunde_20160409_20171010_00102.txt', 'r')){
      $header = $this->parseCsvLine($file);
      $data   = [];
      $i = 0;
      while(!feof($file)){
        $data[] = array_combine($header, $this->parseCsvLine($file));
        $i++;
        if($i >= 100){
          $this->r->finish($data);
        }
      }
    }
    $this->r->finish($res);
  }

  private function importStations($type){
    $path = 'SD_Stundenwerte_Beschreibung_Stationen.txt';
  }

  private function getType($type){
    //
    return true;
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
    $path = $this->downloadFile($urlPath);
    $folder = $this->tmp.pathinfo($urlPath, PATHINFO_FILENAME).'_'.uniqid();
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