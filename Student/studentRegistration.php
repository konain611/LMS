<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentname = $_POST["studentname"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $contactnumber = $_POST["contactnumber"];
    $dateofbirth = $_POST["dateofbirth"];
    $password = $_POST["password"];
    $completeaddress = $_POST["completeaddress"];


    $host = 'localhost';
    $db = 'stureg';
    $user = 'root';
    $pass = '';   


    $conn = new mysqli($host, $user, $pass, $db);
    

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $sql = "INSERT INTO stu_registration (studentname, email, gender, contactnumber, dateofbirth, password, completeaddress)
                VALUES ('$studentname', '$email', '$gender', '$contactnumber', '$dateofbirth', '$password', '$completeaddress')";
    
        if ($conn->query($sql) === TRUE) {
            echo "<h3>Form submitted successfully!</h3>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="../CSS/registation.css">
</head>
<body>
    <div class="signupbox3">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <header>Student Registration Form</header>
            <p style="text-align: center; margin-top: -60px; margin-bottom: 40px;">Fields with an ( * ) are required</p>

            <div class="form-row">
                <div class="form-group">
                    <label>Full Name <span>*</span></label>
                    <input type="text" name="studentname" required>
                </div>
                <div class="form-group">
                    <label>Email <span>*</span></label>
                    <input type="email" name="email" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="gender">Gender <span>*</span></label>
                    <select name="gender" required>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Contact Number <span></span></label>
                    <input type="text" name="contactnumber" pattern="^[0-9]{11}" title="Required format 03xxxxxxxxx">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Date of Birth <span>*</span></label>
                    <input type="date" name="dateofbirth" required>
                </div>
                <div class="form-group">
                    <label>Password <span>*</span></label>
                    <input type="password" name="password">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Complete Address <span></span></label>
                    <input type="text" name="completeaddress">
                </div>
            </div>

            <button type="submit" class="submit-btn2">Submit</button>

            <a href="stulogin.php">
                <div class="submit-btn3">
                    Back To Login Page
                </div>
            </a>
        </form>
    </div>
</body>
</html>