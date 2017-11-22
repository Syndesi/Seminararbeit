<?php
set_time_limit(0);
namespace lib;

class Update {

  public function __construct(){}

  public function update($version, $updateFile){
    $date              = new DateTime();
    $date              = $date->format('Ymd_His');
    $parent            = realpath(__DIR__.'/../../../');  // parent directory
    $pathWorking       = realpath(__DIR__.'/../../');     // the current directory/project folder
    $pathToDelete      = $parent.'/to_delete';            // tmp-folder
    $pathBackup        = $parent.'/'.$date.'_backup.zip'; // path to the backup-file of the current (=old) project folder
    $pathZip           = $parent.'/tmp';                  // tmp-folder
    $pathUpdate        = $parent.'/update';               // tmp-folder
    $pathConfigWorking = $pathWorking.'/config.json';     // config-file which should be copied too
    $pathConfigUpdate  = $pathUpdate.'/config.json';      // config file, new destination
    // save current working directory in a ZIP-file (backup)
    if(is_dir($pathZip)){
      $this->deleteFolder($pathZip);
    }
    $this->zip($pathWorking, $pathBackup);
    // extract update into a new folder
    $zip = new \ZipArchive();
    if($zip->open($updateFile) !== true){
      return false;
    }
    $res = $zip->extractTo($pathZip);
    $zip->close();
    // move the server-part of the file to a seperate folder
    $pathServer = $pathZip.'/'.scandir($pathZip)[2].'/server'; // 0: '.', 1: '..', 2: first "real" file/folder
    if(is_dir($pathUpdate)){
      $this->deleteFolder($pathUpdate);
    }
    $this->copyFolder($pathServer, $pathUpdate);
    $this->deleteFolder($pathZip);
    // copy config.json from the working folder into the new one
    copy($pathConfigWorking, $pathConfigUpdate);
    $config = json_decode(file_get_contents($pathConfigUpdate), true);
    $config['previousVersions'][$config['version']] = $date;
    $config['version'] = $version;
    file_put_contents($pathConfigUpdate, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    // rename current working directory into tmp
    rename($pathWorking, $pathToDelete);
    // rename temporary update-folder into the working directory
    rename($pathUpdate, $pathWorking);
    // delete tmp
    $this->deleteFolder($pathToDelete);
    unlink($urlZip);
    return true;
  }

  function copyFolder($from, $to){
    $files = scandir($from);
    if(is_dir($from)){
      mkdir($to);
    }
    foreach($files as $i => $name){
      if($name == '.' || $name == '..'){
        continue;
      }
      if(is_dir($from.'/'.$name)){
        $this->copyFolder($from.'/'.$name, $to.'/'.$name);
      } else {
        copy($from.'/'.$name, $to.'/'.$name);
      }
    }
    return true;
  }

  function deleteFolder($path){
    $files = scandir($path);
    foreach($files as $i => $name){
      if($name == '.' || $name == '..'){
        continue;
      }
      $tmp = $path.'/'.$name;
      if(is_dir($tmp)){
        $this->deleteFolder($tmp);
      } else {
        unlink($tmp);
      }
    }
    rmdir($path);
    return true;
  }

  function zip($sourcePath, $archivePath){
    $zip = new \ZipArchive();
    if(!$zip || !is_dir($sourcePath)){
      return false;
    }
    touch($archivePath);
    if($zip->open($archivePath) !== true){
      return false;
    }
    $this->addFilesToZip($zip, $sourcePath, '');
    $zip->close();
    return true;
  }

  function addFilesToZip($zip, $basePath, $zipPath){
    $files = scandir($basePath.'/'.$zipPath);
    foreach($files as $i => $name){
      if($name == '.' || $name == '..'){
        continue;
      }
      $path = $basePath.'/'.$zipPath.'/'.$name;
      if(is_dir($path)){
        $this->addFilesToZip($zip, $basePath, $zipPath.'/'.$name);
      } else {
        $zip->addFile($path, ltrim($zipPath.'/'.$name, '/'));
      }
    }
  }

}

?>