<?php

// Include Redis extension
require 'vendor/autoload.php';  // Path to Redis autoload file

use Predis\Client as RedisClient;

// Redis connection parameters
$redis = new RedisClient();

// Clear Redis storage
$redis->flushdb();

// Respond with a success message
echo "Redis storage cleared successfully.";


?>
