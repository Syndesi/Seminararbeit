<?php
require_once 'vendor/autoload.php';
require_once 'lib/request.php';
require_once 'lib/db.php';


$r = new \lib\request();

$apiName = $r->api;
if(!ctype_alnum($apiName)){
  $r->abort(\lib\request::INVALID_REQUEST, 'The API-name must be alphanumeric.');
}
$apiPath = 'api/'.$apiName.'.php';
if(file_exists($apiPath)){
  include_once($apiPath);
  $a = new $apiName($r);
} else {
  $r->abort(\lib\request::INVALID_REQUEST, 'This API does not exist.');
}

exit;
?>