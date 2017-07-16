<?php
namespace lib;

/**
 * returnes a new PDO-handle
 * @param  string $database false: use the default database, string: use this database
 * @return object            the PDO-handle
 */
function db(){
  $file = file_get_contents(__DIR__."/../config.json");
  $config = json_decode($file, true);
  $db = false;
  $c = $config['db'];
  $db = new \PDO('mysql:host='.$c['host'].';dbname='.$c['database'].';charset=utf8;', $c['username'], $c['password']);
  $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  return $db;
}

?>