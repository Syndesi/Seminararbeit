<?php
$dbh = new PDO('mysql:host=localhost;dbname=seminararbeit', 'seminararbeit', 'wMHo60z1HhTnVVq5');

if($dbh){
  echo('worked');
} else {
  echo('error');
}
?>