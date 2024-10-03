<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "stureg";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];


    $stmt = $conn->prepare("INSERT INTO courses (course_code, course_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $course_code, $course_name);

    if ($stmt->execute()) {
        echo "New course added successfully!";
        header("Location: adminportal.php");
    } else {
        echo "Error: " . $stmt->error;
    }


    $stmt->close();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Add Course</title>
</head>
<body>
    
    <h2 style="text-align: center; font-size: 40px;">Add a New Course</h2>
    <form class="signupbox" method="POST" action="">
        <label for="course_code">Course Code:</label>
        <input type="text" id="course_code" placeholder="PF" name="course_code" required><br><br>

        <label for="course_name">Course Name:</label>
        <input type="text" id="course_name" placeholder="Programming Fundamentals" name="course_name" required><br><br>

        <input  type="submit" value="Add Course">
    </form>
</body>
</html>
