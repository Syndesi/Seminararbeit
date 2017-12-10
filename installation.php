<?php
set_time_limit(0);

/* This standalone file is used to install the software from https://github.com/Syndesi/Seminararbeit */


$installationPath = __DIR__;
if(count(scandir($installationPath)) > 3){
  echo('The installation folder isn´t empty. Aborting installation.');
  exit;
}

$releases = json_decode(getWebContent('https://api.github.com/repos/Syndesi/Seminararbeit/releases'), true);
$latestRelease = $releases[0];
$zipPath = __DIR__.'/installation.zip';
$tmpPath = __DIR__.'/tmp';
downloadWebContent($latestRelease['zipball_url'], $zipPath);
unzip($zipPath, $tmpPath);
cp(realpath($tmpPath.'/'.scandir($tmpPath)[2].'/server'), __DIR__);

unlink($zipPath);
rm($tmpPath);

echo('Installation finished.');
echo('You can now open the website and complete this installation.');
exit;


/* Functions copied from different libs in order to create a standalone installation script */

function cp($from, $to){
  foreach(scandir($from) as $i => $name){
    if($name == '.' || $name == '..'){
      continue;
    }
    if(is_dir($from.'/'.$name)){
      cp($from.'/'.$name, $to.'/'.$name);
    } else {
      copy($from.'/'.$name, $to.'/'.$name);
    }
  }
  return true;
}

function rm($path){
  if(!($path = realpath($path))){
    return false;
  }
  if(!is_dir($path)){
    unlink($path);
  } else {
    foreach(scandir($path) as $i => $name){
      if($name == '.' || $name == '..'){
        continue;
      }
      $tmp = $path.'/'.$name;
      if(is_dir($tmp)){
        rm($tmp);
      } else {
        unlink($tmp);
      }
    }
    rmdir($path);
  }
  return true;
}

function unzip($pathZip, $destination){
  $zip = new \ZipArchive();
  if($zip->open($pathZip) !== true){
    return false;
  }
  $res = $zip->extractTo($destination);
  $zip->close();
  return true;
}

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