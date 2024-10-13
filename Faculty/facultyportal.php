<?php
// Start session
session_start();

if (!isset($_SESSION['faculty_email'])) {
    header("Location: facultylogin.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "stureg");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$facultyEmail = $_SESSION['faculty_email'];

$query = "SELECT id FROM faculty_reg WHERE email = ?";
$stmt = mysqli_prepare($conn, $query);
if ($stmt === false) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $facultyEmail);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($result === false) {
    die("Query execution failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$facultyId = $row['id'];

if (!$facultyId) {
    die("Faculty ID not found for email: " . $facultyEmail);
}

$query = "SELECT course_name FROM faculty_courses WHERE faculty_id = ?";
$stmt = mysqli_prepare($conn, $query);
if ($stmt === false) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $facultyId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($result === false) {
    die("Query execution failed: " . mysqli_error($conn));
}

$courses = array();
while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row['course_name'];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Faculty Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .portal-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;

            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .portal-container h1 {
            margin-top: 0;
            
        }

        .logout-btn {
            background-color: #d9534f;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #c9302c;
        }

        .course-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .course-list li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .course-list li:last-child {
            border-bottom: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="portal-container">
        <h1>Welcome to Faculty Portal</h1>
        <p>You are logged in as: <strong><?php echo htmlspecialchars($facultyEmail); ?></strong></p>

        <h2>Faculty Dashboard</h2>

        <form action="facultylogin.php">
            <button type="submit" class="logout-btn">Logout</button>
        </form>

        <table>
            <tr>
                <th>Courses Assigned to You:</th>
            </tr>
            <tr>
                <td>
                    <ul class="course-list">
                        <?php foreach ($courses as $course) { ?>
                            <li><?php echo htmlspecialchars($course); ?></li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>