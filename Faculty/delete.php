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

    echo "<h1>Delete Faculty Record?</h1>";
    echo "<p>Are you sure you want to delete the Faculty record with ID $id?</p>";
    echo "<form action='delete.php' method='post'>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<input type='submit' name='confirm' value='Yes, delete'>";
    echo " | <a href='../Admin/adminportal.php'>Cancel</a>";
    echo "</form>";
} else {
    echo "Invalid ID";
    exit;
}

if (isset($_POST['confirm'])) {
    $sql = "DELETE FROM faculty_courses WHERE faculty_id = $id";
    $conn->query($sql);
    
    $sql = "DELETE FROM faculty_reg WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Faculty with ID $id deleted successfully";
        header('Location: ../Admin/adminportal.php');
        exit;
    } else {
        echo "Error deleting faculty: " . $conn->error;
    }
}
$conn->close();
?>