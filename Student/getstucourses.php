
<style>
    .comma-list {
        list-style-type: none;
        padding: 0;
        font-family:sans-serif;
        font-weight: bold;
    }

    .comma-list li {
        display: inline;
    }

    .comma-list li::after {
        content: ", ";
    }

    .comma-list li:last-child::after {
        content: " ";
    }
</style>
<?php
$host = 'localhost';
$db = 'stureg';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$studentId = $_GET['id'];

$sql = "SELECT * FROM stu_courses WHERE student_id = '$studentId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul class='comma-list'>";
    while ($row = $result->fetch_assoc()) {
        $courseCode = $row['course_code'];
        $sql2 = "SELECT * FROM courses WHERE course_code = '$courseCode'";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        echo "<li>" . $row["course_code"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "No courses found";
}

$conn->close();
?>