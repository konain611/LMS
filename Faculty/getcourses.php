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

$facultyId = $_GET['id'];

// Modify the SQL query to join with the courses table and fetch the course_code
$sql = "SELECT c.course_code 
        FROM faculty_courses fc
        JOIN courses c ON fc.course_id = c.course_id
        WHERE fc.faculty_id = '$facultyId'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul class='comma-list'>";

    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row["course_code"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No courses found for this faculty.</p>";
}

$conn->close();
?>
