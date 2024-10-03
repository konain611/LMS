<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['faculty_email'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the faculty's email from the session
$facultyEmail = $_SESSION['faculty_email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .portal-container {
            text-align: center;
            background-color: #fff;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
        }
        .logout-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>

    <div class="portal-container">
        <h1>Welcome to Faculty Portal</h1>
        <p>You are logged in as: <strong><?php echo $facultyEmail; ?></strong></p>

        <h2>Faculty Dashboard</h2>
        <p>Here you can manage your courses, view student attendance, and more.</p>

        <form action="facultylogin.php">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

</body>
</html>
