<?php
// Include MongoDB extension
require '../assets/vendor/autoload.php';

use MongoDB\Client;

// MongoDB connection parameters
$mongoClient = new Client("mongodb://localhost:27017");
$mongoDatabase = $mongoClient->selectDatabase('guviproject'); 
$mongoCollection = $mongoDatabase->selectCollection('userreg'); 

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $fullname = $_POST["fullname"];
    $age = $_POST["age"];
    $dob = $_POST["dob"];
    $mobileno = $_POST["mobileno"];
    $email = $_POST["email"];
    $bio = $_POST["bio"];

    // Update the user profile in MongoDB
    $result = $mongoCollection->updateOne(
        ['EmailId' => $email], // Filter condition (e.g., email)
        ['$set' => [
            'FullName' => $fullname,
            'age' => $age,
            'dob' => $dob,
            'MobileNo' => $mobileno,
            'bio' => $bio
        ]]
    );

    // Check if the update was successful
    if ($result->getModifiedCount() > 0) {
        // Return success response
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
    } else {
        // Return error response
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
    }
} else {
    // If the request method is not POST, return an error
    http_response_code(405); // Method Not Allowed
    echo "Only POST requests are allowed!";
}
?>
