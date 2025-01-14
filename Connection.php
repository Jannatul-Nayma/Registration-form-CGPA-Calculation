<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "university";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Database connection failed :".$conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'] ?? '';
    $student_id = $_POST['student_id'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $religion = $_POST['religion'] ?? '';
    $department = $_POST['department'] ?? '';
    $number = $_POST['number'] ?? '';

    if (empty($fullname) || empty($student_id)||empty($email) || empty($password) || empty($dob) || empty($gender) || empty($religion) || empty($department)|| empty($number)) {
        die("<p style='color: red;'>All fields are required!</p>");
    }

    $password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO students (fullname,student_id, email, password, dob, gender, religion, department,number) VALUES (?, ?, ?, ?, ?, ?, ?,?,?)");
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("sisssssss", $fullname,$student_id, $email, $password, $dob, $gender, $religion, $department,$number);

    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Registration Response</title>";
    echo "<link rel='stylesheet' href='output_style.css'>"; 
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";

    if ($stmt->execute()) {
        echo "<p style='background: red'><big>Registration successful!</big></p>";
        echo "<p style='color: #433878' >Your submitted data:</p>";
        echo "<ul>";
        echo "<li>Full Name: $fullname</li>";
        echo "<li>Student ID: $student_id</li>";
        echo "<li>Email: $email</li>";
        echo "<li>Password: $password</li>";
        echo "<li>Date of Birth: $dob</li>";
        echo "<li>Gender: $gender</li>";
        echo "<li>Religion: $religion</li>";
        echo "<li>Department: $department</li>";
        echo "<li>Phone Number: $number</li>";
        echo "</ul>";
        echo "<br><a href='cgpacalculator.html'><button>CGPA Calculation</button></a>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    echo "</div>";
    echo "</body>";
    echo "</html>";

    $stmt->close();
}

$conn->close();

?>
