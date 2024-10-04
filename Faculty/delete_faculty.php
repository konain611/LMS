<?php
$host = 'localhost';
$db = 'stureg';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$course_code = $_POST['course_code'];
$faculty_id = $_POST['faculty_id'];


$sql = "DELETE FROM faculty_courses WHERE course_code = ? AND faculty_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $course_code, $faculty_id);

if ($stmt->execute()) {
    echo "Faculty deleted successfully!";
    header("Location: ../Admin/courses.php");
    exit(); 
} else {
    echo "Error deleting faculty: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
