<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "stureg");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_SESSION['email'];
$query = "SELECT id, studentname FROM stu_registration WHERE email = '$email'"; 
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['id'] = $row['id'];
    $name = $row['studentname'];
    $id = $_SESSION['id'];
} else {
    $email = 'No email found';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['courses'])) {
        $selected_courses = $_POST['courses'];
        foreach ($selected_courses as $course_id) {
            $stmt = $conn->prepare("INSERT INTO stu_courses (student_id, course_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $id, $course_id);
            $stmt->execute();
        }
        header("Location: user_portal.php");
        exit;
    }
}

$query = "SELECT * FROM courses";
$courses_result = mysqli_query($conn, $query);
if ($courses_result && mysqli_num_rows($courses_result) > 0) {
?>
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../Faculty/facultyportal.php">
  
    <div class="portal-container">
        <form action="stulogin.php">
            <button type="submit" class="logout-btn">Logout</button>
        </form>

        <h1>Welcome <?php echo htmlspecialchars($name); ?></h1>
        <p>You are logged in as: <strong style="color: yellow;"><?php echo htmlspecialchars($email); ?></strong></p>
        <h2>Enrolled Courses</h2>

        <?php
        $stmt = $conn->prepare("SELECT c.* FROM courses c INNER JOIN stu_courses e ON c.course_id = e.course_id WHERE e.student_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
        ?>
            <table border="2">
                <tr>
                    <th>Course ID</th>
                    <th>Course Code</th>
                    <th>Course Name</th>

                </tr>
                <?php while ($enrolled_course = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $enrolled_course['course_id']; ?></td>
                        <td><?php echo $enrolled_course['course_code']; ?></td>
                        <td><?php echo $enrolled_course['course_name']; ?></td>

                    </tr>
                <?php } ?>
            </table>
        <?php
        } else {
            echo "<div style='color: red; text-align:center; font-size: 25px; font-weight:bold;'>You have not enrolled in any courses yet.</div>";
        }
        ?>
    
    <h2>Available Courses <button id="show-hide-btn" onclick="toggleAvailableCourses()" style="background-color: grey; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; transition: background-color 0.3s;">
    Show Available Courses
</button></h2>

<div id="available-courses" style="display: none;"><span style="color: red; font-weight:bold;">Note: Once enrolled, Only Admin can delete your course<br></span>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table border="2">
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Select</th>
            </tr>
            <?php while ($course = mysqli_fetch_assoc($courses_result)) { ?>
                <tr>
                    <td><?php echo $course['course_code']; ?></td>
                    <td><?php echo $course['course_name']; ?></td>
                    <td><input type="checkbox" name="courses[]" value="<?php echo $course['course_id']; ?>"></td>
                </tr>
            <?php } ?>
        </table>
        <input style="margin-top: 15px;"  type="submit" value="Enroll in Selected Courses">
    </form>
</div>

<script>
    function toggleAvailableCourses() {
        var availableCoursesDiv = document.getElementById("available-courses");
        if (availableCoursesDiv.style.display === "none") {
            availableCoursesDiv.style.display = "block";
            document.getElementById("show-hide-btn").innerHTML = "Hide Available Courses";
        } else {
            availableCoursesDiv.style.display = "none";
            document.getElementById("show-hide-btn").innerHTML = "Show Available Courses";
        }
    }
</script>

<?php
} else {
    echo "No courses found.";
}
?>