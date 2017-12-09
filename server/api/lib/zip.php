<?php
namespace lib;

/**
 * Creates a new Zip-archive from the given path
 * @param  string  $pathZip The path to the (not yet created) zip-archive.
 * @param  string  $from    The path to the directory/file which should be added to the archive.
 * @return boolean          True: Archive created, False: Error occurred.
 */
function zip($pathZip, $from){
  $zip = new \ZipArchive();
  if(!$zip || !is_dir($from)){
    return false;
  }
  touch($pathZip);
  if($zip->open($pathZip) !== true){
    return false;
  }
  zipAddFile($zip, $from, '');
  $zip->close();
  return true;
}

/**
 * Helper function to add all files of an directory recursively to an zip-archive.
 * @param  \ZipArchive $zip      The zip-archive where the files should be added to.
 * @param  string      $basePath The path of the Zip-archive's parent directory. Needed to have put all files relative to the zip-archive into the later.
 * @param  string      $zipPath  The path inside the Zip-archive.
 * @return void
 */
function zipAddFile($zip, $basePath, $zipPath){
  $files = scandir($basePath.'/'.$zipPath);
  foreach($files as $i => $name){
    if($name == '.' || $name == '..'){
      continue;
    }
    $path = $basePath.'/'.$zipPath.'/'.$name;
    if(is_dir($path)){
      zipAddFile($zip, $basePath, $zipPath.'/'.$name);
    } else {
      $zip->addFile($path, ltrim($zipPath.'/'.$name, '/'));
    }
  }
}

/**
 * Unzips a Zip-Archive into a folder.
 * @param  string  $pathZip     The path to the Zip-archive.
 * @param  string  $destination The path to the place where the Zip should be extracted.
 * @return boolean             True: Everything worked, False: An error occurred.
 */
function unzip($pathZip, $destination){
  $zip = new \ZipArchive();
  if($zip->open($pathZip) !== true){
    return false;
  }
  $res = $zip->extractTo($destination);
  $zip->close();
  return true;
}

?>