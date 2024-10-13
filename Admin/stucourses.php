<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <style>
        .student-box {
            display: inline-block;
            width: 300px;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(8px);
        }
       
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
</head>

<body>
    <div class="navbar">
        <a href='../Student/studentRegistration.php'><button class='btn'>Add Student</button></a>
        <a href='../Faculty/addfaculty.php'><button class='btn'>Add Faculty</button></a>
        <a href='courses.php'><button class="btn">View Courses (Faculty)</button></a>
        <a href='addcourses.php'><button class="btn">Add Course</button></a>
        <a href='deletecourse.php'><button class="btn2">Delete Course</button></a>
        <a href="adminPortal.php" class="logout-button"><button class="btn2">Back to Admin Portal</button></a>
    </div>

    <h1>View Students and Assigned Courses</h1>

    <?php
    // Connect to database
    $conn = mysqli_connect("localhost", "root", "", "stureg");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT id, studentname FROM stu_registration";
    $result = mysqli_query($conn, $sql);
    
    // Check if query is successful
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='table-container'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $student_id = $row["id"];
            $student_name = $row["studentname"];
    
            // Query to retrieve assigned courses for each student
            $course_sql = "SELECT course_code FROM stu_courses WHERE student_id = '$student_id'";
            $course_result = mysqli_query($conn, $course_sql);
    
            $courses = array();
            while ($course_row = mysqli_fetch_assoc($course_result)) {
                $courses[] = $course_row["course_code"];
            }
    
            echo "<table border='2'>";
            echo "<th>$student_name</th>";
            foreach ($courses as $course) {
                echo "<tr><td>Course Code: <b>$course</b> 
                      <form action='delete_course.php' method='post'>
                          <input type='hidden' name='course_code' value='$course'>
                          <input type='hidden' name='student_id' value='$student_id'>
                          <input type='submit' value='Delete' style='color: red; border: none; background: none; cursor: pointer; font-size: 15px;' >
                      </form></td></tr>";
            }
            echo "</table>";
        }
        echo "</div>";
    } else {
        echo "<h1>No students found.</h1>";
    }
    
    // Close connection
    mysqli_close($conn);
    
?>
</body>
</html>