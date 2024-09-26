<?php
if (isset($_POST['studentname'], $_POST['email'], $_POST['gender'], $_POST['contactnumber'], $_POST['dateofbirth'], $_POST['password'], $_POST['completeaddress'])) {
    $studentname = $_POST['studentname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $contactnumber = $_POST['contactnumber'];
    $dateofbirth = $_POST['dateofbirth'];
    $password = $_POST['password'];
    $completeaddress = $_POST['completeaddress'];

    $conn = new mysqli('localhost', 'root', '', 'stureg');

    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("Insert into stu_registration(studentname, email, gender, contactnumber, dateofbirth, password, completeaddress)
        values(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $studentname, $email, $gender, $contactnumber, $dateofbirth, $password, $completeaddress);
        $stmt->execute();

        echo "Student registered successfully!";
        echo '<a href="stulogin.php">Back to Login page</a>';
        


        $stmt->close();
        $conn->close();
    }
} else {
    echo "Please fill in all the fields.";
}
?>

