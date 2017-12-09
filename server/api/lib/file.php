<?php
namespace lib;

/**
 * Copys a folder's content to a new location.
 * @param  string  $from The path of the original folder.
 * @param  string  $to   The new location.
 * @return boolean       True: Everything worked, False: An error occurred.
 */
function cp($from, $to){
  if(is_dir($from)){
    mkdir($to);
  } else {
    return false;
  }
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

/**
 * Deletes a folder with it's content.
 * @param  string  $path The path to the folder which should be deleted.
 * @return boolean       True: Everything worked, False: An error occurred.
 */
function rm($path){
  if(!($path = realpath($path))){
    return false;
  }
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
  return true;
}

/**
 * Moves a folder with it's content to a new location.
 * Shorthand for PHP's 'rename'-function.
 * @param  string  $from The original path.
 * @param  string  $to   The new path
 * @return boolean       True: Everything worked. False: An error occurred.
 */
function mv($from, $to){
  return rename($from, $to);
}

?>