<?php
namespace lib;

function getConfig(){
  return json_decode(file_get_contents(__DIR__.'/../../config.json'), true);
}

function setConfig($config){
  file_put_contents(__DIR__.'/../../config.json', json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
  return true;
}

?>