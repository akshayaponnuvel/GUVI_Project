<?php

require_once  __DIR__  . '/../assets/vendor/autoload.php';

// MongoDB Connection
$databseConn = new MongoDB\Client("mongodb://localhost:27017");

if ($databseConn) {
    // echo "Connected to MongoDB successfully\n";
} else {
    // echo "Failed to connect to MongoDB";
}

$mydb = $databseConn->guviproject;
$userCollection = $mydb->userreg;

// MySQL Database Connection
$mysqlHost = "localhost";
$mysqlUsername = "root";
$mysqlPassword = "";
$mysqlDatabase = "guvi";

$mysqlConn = new mysqli($mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase);

if ($mysqlConn->connect_error) {
    die("Connection failed: " . $mysqlConn->connect_error);
} else {
    // echo "Connected to MySQL database successfully\n";
}

?>