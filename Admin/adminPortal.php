<?php

$host = 'localhost';
$db = 'stureg';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM stu_registration";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>STUDENT LIST</h1>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone Number</th><th>Date of Birth (YYYY-MM-DD)</th><th>Password</th><th>Address</th><th>Actions</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["studentname"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["contactnumber"] . "</td>";
        echo "<td>" . $row["dateofbirth"] . "</td>";
        echo "<td>" . $row["password"] . "</td>";
        echo "<td>" . $row["completeaddress"] . "</td>";
        echo "<td>";

        echo "<a href='../Student/edit.php?id=" . $row["id"] . "'><button class='btn'>Update</button></a> | ";
        echo "<a href='?id=" . $row["id"] . "'><button class='btn'>Courses</button></a> | ";
        echo "<a href='delete.php?id=" . $row["id"] . "'><button class='btn2'>Delete</button></a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table><br><hr><hr><br>";
} else {
    echo "<h1>No registered students found</h1>";
}


$sql = "SELECT * FROM faculty_reg";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<h1>FACULTY LIST</h1>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Gender</th><th>Email</th><th>Password</th><th>Actions</th><th>Courses</th></tr>";


    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["password"] . "</td>";
        echo "<td>";
        echo "<a href='../Faculty/edit.php?id=" . $row["id"] . "'><button class='btn'>Update</button></a> | ";

        echo "<a href='../Faculty/delete.php?id=" . $row["id"] . "'><button class='btn2'>Delete</button></a> |";

        echo "<button class='btn' onclick='viewCourses(" . $row["id"] . ")'>View Courses</button>";

        echo "</td>";

        echo "<td><div id='courses-container" . $row["id"] . "'></div></td>";

        echo "</tr>";
    }
    echo "</table><br><hr><hr><br>";
} else {
    echo "<h1>No registered faculty found</h1>";
}


$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Admin Portal</title>
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

        table {
            backdrop-filter: Blur(8px);
            margin: 0 auto;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
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
    </style>
</head>

<body>

    <div class="navbar">
        <a href='../Student/studentRegistration.php'><button class='btn'>Add Student</button></a>
        <a href='../Faculty/addfaculty.php'><button class='btn'>Add Faculty</button></a>
        <a href=''><button class="btn">Check Student Attendance</button></a>
        <a href='courses.php'><button class="btn">View Courses</button></a>
        <a href='addcourses.php'><button class="btn">Add Courses</button></a>
        <a href='deletecourse.php'><button class="btn2">Delete Courses</button></a>
        <a href="logout.php" class="logout-button"><button class="btn2">Logout</button></a>
    </div>
    
    <script>
        function viewCourses(facultyId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../Faculty/getcourses.php?id=' + facultyId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var container = document.getElementById('courses-container' + facultyId);
                    if (container.style.display === 'block') {
                        container.style.display = 'none';
                    } else {
                        container.style.display = 'block';
                        container.innerHTML = xhr.responseText;
                    }
                }
            };
            xhr.send();
        }
    </script>

</body>

</html>