<?php
// Include Redis extension
require '../assets/vendor/autoload.php'; // Path to Redis autoload file

use Predis\Client as RedisClient;

// Redis connection parameters
$redis = new RedisClient();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the ObjectId from localStorage
    $objectId = $_POST["objectId"];

    // Check if the ObjectId is present
    if (!empty($objectId)) {
        // Retrieve data from Redis using the ObjectId as key
        $redisData = $redis->get('user:'.$objectId);

        // Check if data exists in Redis
        if ($redisData !== null) {
            // Data found in Redis, output the details
            echo $redisData;
        } else {
            // Data not found in Redis
            echo "Data not found in Redis!";
        }
    } else {
        // ObjectId is empty or not provided
        echo "ObjectId is empty or not provided!";
    }
} else {
    // If the request method is not POST, return an error
    http_response_code(405); // Method Not Allowed
    echo "Only POST requests are allowed!";
}
?>