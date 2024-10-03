<?php

$conn = mysqli_connect("localhost", "root", "", "stureg");


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM courses";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Course Name</th><th>Delete</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["course_code"] . "</td>";
        echo "<td><form action='deletecourse.php' method='post'><input type='hidden' name='code' value='" . $row["course_code"] . "'><input type='submit' value='Delete'></form></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No courses found.";
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["code"])) {
        $code = $_POST["code"];
        $sql = "DELETE FROM courses WHERE course_code = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $code);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: adminPortal.php");
            echo "Course deleted successfully.";
        } else {
            echo "Error deleting course: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "No code provided.";
    }
}

// Close the database connection
mysqli_close($conn);
?>