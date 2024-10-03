<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
</head>

<body>
    <div class="navbar">
        <a href='../Student/studentRegistration.php'><button class='btn'>Add Student</button></a>
        <a href='../Faculty/addfaculty.php'><button class='btn'>Add Faculty</button></a>
        <a href=''><button class="btn">Check Student Attendance</button></a>
        <a href='addcourses.php'><button class="btn">Add Course</button></a>
        <a href='deletecourse.php'><button class="btn2">Delete Course</button></a>
        <a href="adminPortal.php" class="logout-button"><button class="btn2">Back to Admin Portal</button></a>
    </div>
    <style>
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #17416c;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            z-index: 1;
        }

        .navbar a {
            margin-right: 20px;
            color: #ffffff;
            text-decoration: none;
        }

        .navbar a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .btn,
        .btn2 {
            background-color: #17416c;
            color: #ffffff;
            border: none;
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
            border: solid black;
        }

        .btn:hover {
            background-color: black;
            color: white;
            border: solid rgb(0, 196, 26);
        }

        .btn2:hover {
            background-color: black;
            color: white;
            border: solid rgb(243, 5, 5);
            /* red */
        }

        .logout-button {
            margin-left: auto;
        }

        .table-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        table {
            flex: 1;
            min-width: 300px;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(8px);
        }
        th{
            background-color: #17416c;
        }
        th,
        td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }
    </style>
</body>
<h1>View Courses</h1>

</html>

<?php

$host = 'localhost';
$db = 'stureg';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

$courses = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $course_code = $row["course_code"];
        $course_name = $row["course_name"];

        $courses[$course_code] = array('course_name' => $course_name, 'faculty' => array());
    }

    echo "<div class='table-container'>";
    foreach ($courses as $course_code => $course_info) {
        echo "<table border='2'>";
        echo "<th>{$course_info['course_name']} ($course_code)</th>"; 

 
        $sql_faculty = "SELECT * FROM faculty_courses WHERE course_code = '$course_code'";
        $result_faculty = $conn->query($sql_faculty);

        if ($result_faculty->num_rows > 0) {
            while ($row_faculty = $result_faculty->fetch_assoc()) {
                $faculty_id = $row_faculty["faculty_id"];
                $faculty_name = $row_faculty["faculty_name"];

                echo "<tr>";
                echo "<td>Faculty ID: <b>$faculty_id</b><br> Faculty Name: <b>$faculty_name</b> 
                      <form action='../Faculty/delete_faculty.php' method='post'>
                          <input type='hidden' name='course_code' value='$course_code'>
                          <input type='hidden' name='faculty_id' value='$faculty_id'>
                          <input type='hidden' name='faculty_name' value='$faculty_name'>
                          <input type='submit' value='Delete' style='color: red; border: none; background: none; cursor: pointer; font-size: 15px;' >
                      </form></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td>No faculty assigned to this course.</td></tr>";
        }

        echo "</table>";
    }

    echo "</div>";
} else {
    echo "<h1>No courses found</h1>";
}

$conn->close();

?>
