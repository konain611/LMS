
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="adminPortal.php">

    <style>
        .btn2 {
            display: inline-block;
            margin: 0 10px;
        }
        .logout-button {
            position: fixed;
            top: 8;
            right: 3;
        }
    </style>
</body>

</html>
<?php

$conn = mysqli_connect("localhost", "root", "", "stureg");


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM courses";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    echo "<table>";
    echo "<tr><th>Course Code</th><th>Delete</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<tr>";
        echo "<td>" . $row["course_code"] . "</td>";
        echo "<td><form action='deletecourse.php' method='post'><input type='hidden' name='code' value='" . $row["course_code"] . "'><input  type='submit' class='btn2' value='Delete'></form></td>";

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No courses found.";
}

echo "<a href='courses.php' class='logout-button'><button class='btn2'>Back to View Courses</button></a>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["code"])) {
        $code = $_POST["code"];
        $sql = "DELETE FROM courses WHERE course_code = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $code);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: courses.php");
            echo "Course deleted successfully.";
        } else {
            echo "Error deleting course: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "No code provided.";
    }
}


mysqli_close($conn);
?>