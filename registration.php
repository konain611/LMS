<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'studentregistration';


$conn = new mysqli($db_host, $db_username, $db_password, $db_name);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $contactnumber = $_POST["contactnumber"];
    $dateofbirth = $_POST["dateofbirth"];
    $hsscboardname = $_POST["hsscboardname"];
    $hsscobtainedmarks = $_POST["hsscobtainedmarks"];
    $hssctotalmarks = $_POST["hssctotalmarks"];
    $completeaddress = $_POST["completeaddress"];


    $stmt = $conn->prepare("INSERT INTO studentregistration (studentname, email, gender, contactnumber, dateofbirth, hsscboardname, hsscobtainedmarks, hssctotalmarks, completeaddress) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    

    $stmt->bind_param("ssisssssss", $fullname, $email, $gender, $contactnumber, $dateofbirth, $hsscboardname, $hsscobtainedmarks, $hssctotalmarks, $completeaddress);

    if ($stmt->execute()) {
        echo "Data Inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

  
    $stmt->close();
}


$conn->close();

?>
