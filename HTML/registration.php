<?php 
    $studentname = $_POST['studentname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $contactnumber = $_POST['contactnumber'];
    $dateofbirth = $_POST['dateofbirth'];
    $password = $_POST['password'];
    $completeaddress = $_POST['completeaddress'];

    $conn = new mysqli('localhost','root','','stureg');

    if($conn->connect_error){
        die('Connection Failed : ' .$conn->connect_error);
    }
    
    else{
        $stmt = $conn->prepare("Insert into stu_registration(studentname, email, gender, contactnumber, dateofbirth, password, completeaddress)
        values(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $studentname, $email, $gender, $contactnumber, $dateofbirth, $password, $completeaddress);
        $stmt->execute();

        echo "Student registered successfully!";

        $stmt->close();
        $conn->close();
    } 
    ?>