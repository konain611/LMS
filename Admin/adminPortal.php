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
    echo "<h1>Students List</h1>";
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
        echo "<a href='edit.php?id=" . $row["id"] . "'><button class='btn'>Edit</button></a> | ";
        echo "<a href='delete.php?id=" . $row["id"] . "'><button class='btn2'>Delete</button></a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<h1>No registered students found</h1>";
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
        .btn2,
        .btn3 {
            background-color: #17416c;
            color: #ffffff;
            border: none;
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: black;
            color: white;
            border: solid rgb(0, 196, 26);
        }

        .btn2:hover, .btn3:hover {
            background-color: black;
            color: white;
            border: solid rgb(243, 5, 5);
        }

        .logout-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

<body>
<a href="logout.php" class="logout-button"><button class="btn3">Logout</button></a>
</body>

</html>