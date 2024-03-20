<?php

require 'vendor/autoload.php'; // Include Composer's autoloader

use Predis\Client;

// Create a new Predis client instance
$client = new Client();

try {
    // Attempt to ping the Redis server
    $response = $client->ping();

    if ($response == 'PONG') {
        echo "Redis is running.";
    } else {
        echo "Redis is not running.";
    }
} catch (Exception $e) {
    echo "Unable to connect to Redis. Error: " . $e->getMessage();
}

?>
