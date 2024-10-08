<?php

$host = 'localhost';
$db = 'stureg';
$user = 'root';
$pass = '';


$conn = new mysqli($host, $user, $pass, $db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo "Invalid ID";
    exit;

}

if (isset($id) && !empty($id)) {
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM faculty_reg WHERE id = '$id'");
    if ($result->num_rows > 0) {
        $faculty = $result->fetch_assoc();
        
    } else {
        echo "Faculty not found";
        exit;
    }

    $conn->close();
} else {
    echo "Invalid ID";
    exit;
}
?>


<?php
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE faculty_reg SET name = ?, email = ?, password = ?,  gender = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    $stmt->bind_param("ssssi", $name, $email, $password, $gender, $id);
    if (!$stmt->execute()) {
        echo "Error executing statement: " . $stmt->error;
        exit;
    }

    if ($stmt->affected_rows > 0) {
        echo "faculty record updated successfully";
        header('Location: ../Admin/adminportal.php');
        exit;
    } else {
        echo "No Changes Made. Error Updating Record " . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Edit Faculty Info</title>
</head>

<body>

    <form class="signupbox" action="edit.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="name">faculty Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $faculty['name']; ?>"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $faculty['email']; ?>"><br><br>
        <label for="password">Password:</label>
        <input type="text" id="password" name="password" value="<?php echo $faculty['password']; ?>"><br><br>
        <label for="gender">Gender:</label>
        <input type="text" id="gender" name="gender" value="<?php echo $faculty['gender']; ?>"><br><br>
        <input type="submit" name="update" value="Update">
    </form>
</body>

</html>