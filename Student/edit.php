<?php

$host = 'localhost';
$db = 'stureg';
$user = 'root';
$pass = '';   


$conn = new mysqli($host, $user, $pass, $db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo "Invalid ID";
    exit;
}

if (isset($id) && !empty($id)) {
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM stu_registration WHERE id = '$id'"); 
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found";
        exit;
    }

    $conn->close();
} else {
    echo "Invalid ID";
    exit;
}
?>


<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['studentname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $completeaddress = $_POST['completeaddress']; 
    $contactnumber = $_POST['contactnumber'];

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE stu_registration SET studentname = ?, email = ?, password = ?, completeaddress = ?, contactnumber = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    $stmt->bind_param("sssssi", $name, $email, $password, $completeaddress, $contactnumber, $id);
    if (!$stmt->execute()) {
        echo "Error executing statement: " . $stmt->error;
        exit;
    }

    if ($stmt->affected_rows > 0) {
        echo "Student record updated successfully";
        header('Location: ../Admin/adminportal.php');
        exit;
    } else {
        echo "No Changes Made. Error updating student record: " . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Edit Student Info</title>
</head>
<body>
    
    <form class="signupbox" action="edit.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
        <label for="studentname">Student Name:</label>
        <input type="text" id="studentname" name="studentname" value="<?php echo $student['studentname']; ?>"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $student['email']; ?>"><br><br>
        <label for="password">Password:</label>
        <input type="text" id="password" name="password" value="<?php echo $student['password']; ?>"><br><br>
        <label for="completeaddress">Address:</label>
        <input type="text" id="completeaddress" name="completeaddress" value="<?php echo $student['completeaddress']; ?>"><br><br>
        <label for="contactnumber">Phone Number:</label>
        <input type="tel" id="contactnumber" name="contactnumber" value="<?php echo $student['contactnumber']; ?>"><br><br>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>