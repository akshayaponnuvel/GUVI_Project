<?php

require_once  __DIR__  . '/../assets/vendor/autoload.php';

$databseConn = new MongoDB\Client("mongodb://localhost:27017");

$mydb = $databseConn->guviproject;
$userCollection = $mydb->userreg;

// MySQL Database Connection
$mysqlHost = "localhost";
$mysqlUsername = "root";
$mysqlPassword = "";
$mysqlDatabase = "guvi";


?>