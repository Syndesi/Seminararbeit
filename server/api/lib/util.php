<?php
namespace lib;

/**
 * returns the formated size in KB, MB, GB and so on
 * @source  https://stackoverflow.com/a/2510459/4417327 The original code, slightly modified
 * @param  [type]  $bytes     [description]
 * @param  integer $precision [description]
 * @return [type]             [description]
 */
function formatBytes($bytes, $precision = 2){
  $units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
  $bytes = max($bytes, 0);
  $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
  $pow = min($pow, count($units) - 1);
  return round($bytes/pow(1024, $pow), $precision).' '.$units[$pow]; 
}

?>