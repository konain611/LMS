<?php
session_start();

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
 
    $email = $_POST['email'];
    $password = $_POST['password'];

   
    if (!empty($email) && !empty($password)) {
        
 
        $host = 'localhost';
        $db = 'stureg';
        $user = 'root';
        $pass = '';   

   
        $conn = new mysqli($host, $user, $pass, $db);

      
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

      
        $stmt = $conn->prepare("SELECT * FROM stu_registration WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password); 

      
        $stmt->execute();

      
        $result = $stmt->get_result();

     
        if ($result->num_rows > 0) {
          
            $_SESSION['email'] = $email; 
            header("Location: user_portal.php");
            exit(); 
        } else {
            $error_message = "Invalid email or password. Please try again.";
        }

 
        $stmt->close();
        $conn->close();
        
    } else {

        $error_message = "Please enter both email and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="stylesheet" href="../CSS/index.css">
</head>
<body>

    <div class="signupbox2">
        <h1>Students Login Page</h1>
        

        <?php if (!empty($error_message)): ?>
            <div style="color: red; text-align:center;  margin-top: 20px; font-weight: Bold;"><?= $error_message ?></div>
        <?php endif; ?>


        <form action="" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <div class="submit-btn2">
                <input type="submit" value="Login" style="border: none; background: none; cursor: pointer;">
            </div>
        </form>

        <a href="studentRegistration.php">
            <div class="submit-btn1">
                Register as a Student
            </div>
        </a>

        <a href="../index.html">
            <div class="submit-btn">
                Back To Home Page
            </div>
        </a>
    </div>

</body>
</html>
