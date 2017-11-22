<?php

class update{

  public function __construct(){}

  public function update(){
    $parent = realpath(__DIR__.'/../');
    $currentFolder = $parent.'/current';
    $updateFolder = $parent.'/update';
    $oldFolder = $parent.'/old';
    rename($currentFolder, $oldFolder);
    rename($updateFolder, $currentFolder);
    echo('[ FINISHED ]');
  }

  public function update2(){
    $date = new DateTime();
    $date = $date->format('Ymd_His');
    $parent = realpath(__DIR__.'/../');
    $pathWorking = $parent.'/current'.'/';
    $pathBackup = $parent.'/'.$date.'_backup.zip';
    $pathZip = $parent.'/tmp'.'/';
    $urlZip = $parent.'/update.zip';

    //echo($pathBackup);
    $this->zip3($pathWorking, $pathBackup);
  }

  function zip3($sourcePath, $archivePath){
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

  /**
   * copied from https://stackoverflow.com/questions/1334613/how-to-recursively-zip-a-directory-in-php
   * @param  [type] $source      [description]
   * @param  [type] $destination [description]
   * @return [type]              [description]
   */
  function zip($source, $destination){
    if(!extension_loaded('zip') || !file_exists($source)){
      return false;
    }
    $zip = new ZipArchive();
    if(!$zip->open($destination, ZIPARCHIVE::CREATE)){
      return false;
    }
    $source = str_replace('\\', '/', realpath($source));
    if(is_dir($source) === true){
      $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
      foreach ($files as $file){
        $file = str_replace('\\', '/', $file);
        // Ignore "." and ".." folders
        if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
          continue;
        $file = realpath($file);
        if(is_dir($file) === true){
          $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
        } else if (is_file($file) === true){
          $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
        }
      }
    } else if (is_file($source) === true){
      $zip->addFromString(basename($source), file_get_contents($source));
    }
    return $zip->close();
  }

  function zip2($source, $archive){
    $zip = new \ZipArchive;
    if($zip->open($archive, \ZipArchive::CREATE) === TRUE){
      $dir = preg_replace('/[\/]{2,}/', '/', $source."/");
      $dirs = [$dir];
      while(count($dirs)){
        $dir = current($dirs);
        $zip->addEmptyDir($dir);
        $dh = opendir($dir);
        while($file = readdir($dh)){
          if($file != '.' && $file != '..'){
            if(is_file($file)){
              $zip->addFile($dir.$file, $dir.$file);
            }elseif(is_dir($file)){
              $dirs[] = $dir.$file."/";
            }
          }
        }
        closedir($dh);
        array_shift($dirs);
      }
      $zip->close();
      echo 'Archiving is sucessful!';
    }else{
      echo 'Error, can\'t create a zip file!';
    }
  }

}

$u = new update();
$u->update2();

?>