<?php
// Only admin can access this page

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stureg";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $courses = $_POST['courses'];

    $sql = "INSERT INTO faculty_reg (name, email, password, gender) VALUES ('$name', '$email', '$password', '$gender')";

    if ($conn->query($sql) === TRUE) {
        $faculty_id = $conn->insert_id;
        $faculty_name = $name;

        foreach ($courses as $course) {
            $course_name = mysqli_real_escape_string($conn, $_POST['course_names'][$course]);
            $course_code = mysqli_real_escape_string($conn, $_POST['course_codes'][$course]);

            $sql_courses = "INSERT INTO faculty_courses (faculty_id, course_id, course_name, faculty_name, course_code) 
                            VALUES ($faculty_id, '$course', '$course_name', '$faculty_name', '$course_code')";

            if (!$conn->query($sql_courses)) {
                echo "Error: " . $sql_courses . "<br>" . $conn->error;
            }
        }

        header("Location: ../Admin/adminportal.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$sql_courses = "SELECT * FROM courses";
$result = $conn->query($sql_courses);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Registration</title>
    <link rel="stylesheet" href="../CSS/registation.css">
    <style>
        .course-column {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            font-size: 20px;
        }

        .course-item {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .course-item input[type="checkbox"] {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="signupbox3">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <header>Faculty Registration</header>
            <p style="text-align: center; margin-top: -60px; margin-bottom: 40px;">Fields with an ( * ) are required</p>

            <div class="form-row">
                <div class="form-group">
                    <label>Full Name <span>*</span></label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email <span>*</span></label>
                    <input type="email" value="@ubit.com" name="email" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Password <span>*</span></label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender <span>*</span></label>
                    <select name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="course-column">
                    <label for="courses">Courses (Select multiple):&nbsp;</label>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?><div class="course-item">
                            <br><input type="checkbox" name="courses[]" value="<?php echo $row['course_id']; ?>">
                            <?php echo $row['course_name']; ?>
                            <input type="hidden" name="course_names[<?php echo $row['course_id']; ?>]" value="<?php echo $row['course_name']; ?>">
                            <input type="hidden" name="course_codes[<?php echo $row['course_id']; ?>]" value="<?php echo $row['course_code']; ?>">
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>

            <button type="submit" class="submit-btn2">Submit</button>
        </form>
       <a  href="../Admin/adminPortal.php"><button  class="submit-btn3">Back To Admin Panel</button></a> 
    </div>
</body>

</html>

<?php
$conn->close();
?>