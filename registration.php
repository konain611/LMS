<?php

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'studentregistration';


$conn = new mysqli_connect($db_host, $db_username, $db_password, $db_name);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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


    $sql = "INSERT INTO studentregistration (studentname, email, gender, contactnumber, dateofbirth, hsscboardname, hsscobtainedmarks,
     hssctotalmarks, completeaddress) 
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

if(mysqli_query($conn, $sql_qurey)){
    echo "Data Inserted successfully"
}
else{
    echo "Error: " . sql . "" . mysqli_connect_error($conn);
}

mysqli_close($conn);

?>