<?php
// Connect to database
$conn = mysqli_connect("localhost", "root", "", "stureg");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve course code and student id from form
$course_code = $_POST["course_code"];
$student_id = $_POST["student_id"];

// Query to delete course for student
$sql = "DELETE FROM stu_courses WHERE course_code = '$course_code' AND student_id = '$student_id'";
$result = mysqli_query($conn, $sql);

// Check if query is successful
if ($result) {
    echo "<script>alert('Course deleted successfully!');</script>";
    echo "<script>window.location.href='stucourses.php';</script>";
} else {
    echo "<script>alert('Failed to delete course!');</script>";
    echo "<script>window.location.href='stucourses.php';</script>";
}

// Close connection
mysqli_close($conn);
?>