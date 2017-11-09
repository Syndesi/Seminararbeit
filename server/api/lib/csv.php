<?php
namespace lib;

class CSV {

  private $path = null;

  public function __construct($path){
    $this->path = $path;
  }

  public function parseNormalCSV(){
    $header = [];
    if($file = fopen($this->path, 'r')){
      $header  = explode(' ', trim($this->readLine($file)));
      if($divider){
        $divider = $this->readLine($file);
      }
      $lines = [];
      while(!feof($file)){
        $line = $this->readLine($file);
        if(trim($line) != ''){
          $lines[] = $line;
        }
      }
    }
  }

  public function parse($divider = true){
    $header = [];
    if($file = fopen($this->path, 'r')){
      $header  = explode(' ', trim($this->readLine($file)));
      if($divider){
        $divider = $this->readLine($file);
      }
      $lines = [];
      while(!feof($file)){
        $line = $this->readLine($file);
        if(trim($line) != ''){
          $lines[] = $line;
        }
      }
      $spaces = $this->getSpaces(array_slice($lines, 0, 10));
      $res = [];
      foreach($lines as $line){
        $res[] = $this->splitLine($line, $header, $spaces);
      }
      fclose($file);
      return $res;
    } else {
      throw new Exception('Could not read the file.');
    }
  }


  private function getSpaces($lines){
    $spaces       = [];
    $leftAligned  = [];
    $rightAligned = [];
    $res          = [];
    foreach($lines as $line){
      foreach(str_split($line) as $i => $char){
        if(!array_key_exists($i, $spaces)){
          $spaces[$i] = [0, 0];  // [number of spaces, number of lines]
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
      $left = $leftAligned[$i];
      if(array_key_exists($i, $rightAligned)){
        $res[$i] = $rightAligned[$i] - 1; // I don't know why -1, but it works ¯\_(ツ)_/¯
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

  private function readLine($file){
    $line = fgets($file);
    $line = iconv('windows-1250', 'UTF-8', $line);
    $line = str_replace("\n", '', $line);
    $line = str_replace("\r", '', $line);
    $line = str_replace('"', '', $line);
    return $line;
  }
}