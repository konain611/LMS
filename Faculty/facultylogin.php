<?php

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $email = $_POST['email'];
    
    $password = $_POST['password'];


    $conn = new mysqli('localhost', 'root', '', 'stureg');


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $stmt = $conn->prepare("SELECT * FROM faculty_reg WHERE email = ? AND password = ?");

    $stmt->bind_param("ss", $email, $password);

    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {

        $_SESSION['faculty_email'] = $email;
        header("Location: facultyportal.php");
        exit();
    } else {

        echo "<div style='color: red; font-size:21px; font-weight: bold; text-align: center; position: absolute; top: 5%; left:38%;'>

            Invalid email or password. Please try again.
          </div>";
    }


    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Login</title>
    <link rel="stylesheet" href="../CSS/index.css">
</head>

<body>

    <div class="signupbox2">
        <h1>Faculties Login Page</h1>

        <form action="" method="post">
            <label>Email</label>
            <input type="email" value="@ubit.com" name="email" required><br><br>
            <label>Password</label>
            <input type="password" placeholder="" name="password" required><br><br>
            <div class="submit-btn2">
                <input type="submit" value="Login" style="border: none; background: none; cursor: pointer;">
            </div>
        </form>

        <a href="../index.html">
            <div class="submit-btn">
                Back To Home Page
            </div>
        </a>
    </div>

</body>

</html>