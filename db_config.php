<?php

// $db_host = 'localhost';
// $db_name = 'music';
// $db_username = 'marcus';
// $db_password = 'cifNJ4B4IpQ5nZG9';

$db_host = '127.0.0.1:55023';
$db_name = 'music';
$db_username = 'azure';
$db_password = '6#vWHD_$';

$dsn = "mysql:host=$db_host;dbname=$db_name";

try{
$db_connection = new PDO($dsn, $db_username, $db_password);
}catch(Exception $e){
  echo "there was a failure - " . $e->getMessage();
}


//Database=localdb;Data Source=127.0.0.1;User Id=azure;Password=6#vWHD_$


// $db_host = '127.0.0.1:54932';
