<?php
// Start the session to manage user login state
session_start();

// Initialize error message
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get the submitted email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Ensure that email and password are not empty
    if (!empty($email) && !empty($password)) {
        
        // Database connection details
        $host = 'localhost';
        $db = 'stureg'; // Your database name
        $user = 'root'; // Your database username
        $pass = '';     // Your database password

        // Create a new connection
        $conn = new mysqli($host, $user, $pass, $db);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL query to fetch the user data
        $stmt = $conn->prepare("SELECT * FROM stu_registration WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);  // "ss" means we expect two strings: email and password

        // Execute the query
        $stmt->execute();

        // Get the result of the query
        $result = $stmt->get_result();

        // Check if any row matches the email and password
        if ($result->num_rows > 0) {
            // If credentials match, set session and redirect to the student portal
            $_SESSION['email'] = $email; // Store email in session to remember the logged-in user
            header("Location: user_portal.php"); // Redirect to the student portal page
            exit(); // Stop further script execution
        } else {
            // If credentials do not match, show an error message
            $error_message = "Invalid email or password. Please try again.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        
    } else {
        // If email or password is empty, show an error message
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
        
        <!-- Display error message, if any -->
        <?php if (!empty($error_message)): ?>
            <div style="color: red; text-align:center; margin-bottom: -50px; margin-top: -50px;"><?= $error_message ?></div>
        <?php endif; ?>

        <!-- The form will submit data to the same file -->
        <form action="" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            
            <div class="submit-btn2">
                <input type="submit" value="Login" style="border: none; background: none; cursor: pointer;">
            </div>
        </form>

        <a href="studentRegistration.html">
            <div class="submit-btn1">
                Register as a Student
            </div>
        </a>

        <a href="index.html">
            <div class="submit-btn">
                Back To Home Page
            </div>
        </a>
    </div>

</body>
</html>
