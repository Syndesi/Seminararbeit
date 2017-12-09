<?php
namespace lib;

/**
 * Downloads a file from the web over HTTP to the given path.
 * @param  string  $url     The URL of the file.
 * @param  string  $path    The intended local path of the downloaded file.
 * @param  int     $timeout After which time the download will break.
 * @param  string  $agent   The user-agent in the HTTP-request.
 * @return boolean          True, could be improved.
 */
function downloadWebContent($url, $path, $timeout = 600, $agent = false){
  if(!$agent){
    $agent = $_SERVER['HTTP_USER_AGENT'];
  }
  $f = fopen($path, 'w+');
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
  curl_setopt($ch, CURLOPT_FILE, $f);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_exec($ch); 
  curl_close($ch);
  fclose($f);
  return true;
}

/**
 * Gets the content of file from the internet, like file_get_contents.
 * Should be only used for smaller files.
 * @param  string $url   The URL of the file.
 * @param  string $agent The user-agent in the HTTP-request.
 * @return string        The content of the given URL.
 */
function getWebContent($url, $agent = false){
  if(!$agent){
    $agent = $_SERVER['HTTP_USER_AGENT'];
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  $res = curl_exec($ch);
  curl_close($ch);
  return $res;
}

?>