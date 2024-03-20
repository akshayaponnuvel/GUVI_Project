<?php
require "../assets/log-config.php";

// Include MongoDB extension
require '../assets/vendor/autoload.php';

use MongoDB\Client;
use Predis\Client as RedisClient;

// MongoDB connection parameters
$mongoClient = new Client("mongodb://localhost:27017");
$mongoDatabase = $mongoClient->selectDatabase('guviproject');
$mongoCollection = $mongoDatabase->selectCollection('userreg');

$redis = new RedisClient();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the email and password from the POST data
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Database connection parameters
    $conn = new mysqli($mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to retrieve user information based on email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user with the provided email exists in MySQL
    if ($result->num_rows == 1) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify password (plain text comparison)
        if ($password === $user["password"]) {
            // Authentication successful
            // Retrieve ObjectId from MongoDB based on email
            
            $mongoDocument = $mongoCollection->findOne(['EmailId' => $email]);
            if ($mongoDocument !== null) {
                // Retrieve ObjectId from MongoDB document
                $objectId = (string) $mongoDocument['_id'];
                // Output success message along with ObjectId
                // echo "$objectId";
                echo json_encode(['status' => 'success', 'objectId' => $objectId]);
                $redis->set('user:'.$objectId, json_encode($mongoDocument));
            } else {
                // User not found in MongoDB
                echo json_encode(['status' => 'User not found in MongoDB!']);
            }
        } else {
            // Authentication failed (password mismatch)
            echo json_encode(['status' => 'Invalid email or password!']);
        }
    } else {
        // User with the provided email not found in MySQL
        echo json_encode(['status' => 'User not found!']);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If the request method is not POST, return an error
    http_response_code(405); // Method Not Allowed
    echo "Only POST requests are allowed!";
}
?>