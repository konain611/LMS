<?php
$host = 'localhost';
$db = 'stureg';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get course_code and faculty_id from the POST request
$course_code = $_POST['course_code'];
$faculty_id = $_POST['faculty_id'];

// Prepare and execute the delete query
$sql = "DELETE FROM faculty_courses WHERE course_code = ? AND faculty_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $course_code, $faculty_id);

if ($stmt->execute()) {
    // If the deletion was successful, redirect to the courses page
    echo "Faculty deleted successfully!";
    header("Location: ../Admin/courses.php");
    exit(); // Ensure the script stops after the redirect
} else {
    // Handle any errors that occur during deletion
    echo "Error deleting faculty: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
