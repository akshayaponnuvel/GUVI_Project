<?php

require "../assets/reg-config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = $mysqlConn->query($checkEmailQuery);


    if ($result->num_rows > 0) {
        echo "Error: Email already exists";
    } else {
        $insertSql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
        
        if ($mysqlConn->query($insertSql) === TRUE) {
            echo "\nRegistered successfully\n";
        } else {
            echo "Error: " . $insertSql . "<br>" . $mysqlConn->error;
        }
        

		$fullname = $_POST['fullname'];
		$email = $_POST['email'];
		$mobileno = $_POST['mobileno'];

		$data = array(
			"FullName" => $fullname,
			"EmailId" => $email,
			"MobileNo" => $mobileno,
		);

		$insert = $userCollection->insertOne($data);

		if ($insert->getInsertedCount() > 0) {
			echo "\nDocument inserted successfully!";
		} else {
			echo "Error inserting data: " . $insert->getMessage();
		}
    }
    $mysqlConn->close();
}
?>