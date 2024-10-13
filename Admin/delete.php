<link rel="stylesheet" href="../CSS/index.css">

<!-- to delete Student record -->

<?php


$host = 'localhost';
$db = 'stureg';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['confirm'])) {
    $id = $_POST['id'];
} elseif (isset($_GET['id'])) {
    $id = $_GET['id']; 
} else {
    echo "Invalid ID";
    exit;
}

if (is_numeric($id) && $id > 0) {

    echo "<h1>Delete Student Record?</h1>";
    echo "<p style='text-align:center; font-size:35px; color:Yellow;';>Are you sure you want to delete the student record with ID $id?</p>";
    echo "<form action='delete.php' method='post'>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<input type='submit' name='confirm' value='Yes, delete'>";
    echo " | <a href='adminportal.php'>Cancel</a>";
    echo "</form>";
} else {
    echo "Invalid ID";
    exit;
}

if (isset($_POST['confirm'])) {
    $sql = "DELETE FROM stu_registration WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Student with ID $id deleted successfully";
        header('Location: adminportal.php');
        exit;
    } else {
        echo "Error deleting student: " . $conn->error;
    }
}

$conn->close();
?>
