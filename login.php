<?php
$host = "localhost";
$dbname = "dbproject";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (mysqli_connect_error()) {
    die("Connection ERROR: " . mysqli_connect_error());
}

// Check if the form is submitted using POST
// ... (previous code)

// Check if the form is submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "SELECT * FROM user_info WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // Compare the entered password with the stored hashed password
        if (password_verify($password, $row['Password'])) {
            // Successful login, redirect to main page
            header("Location: trial.html");
        } else {
            echo "Incorrect password. <a href='login.php'>Try again</a>.";
        }
    } else {
        echo "User not found. <a href='register.php'>Register here</a>.";
    }
}

mysqli_close($conn);
