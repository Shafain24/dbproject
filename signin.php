<?php
$host = "localhost";
$dbname = "dbproject";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (mysqli_connect_error()) {
    die("Connection ERROR: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary form fields are set
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["cpassword"])) {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = $_POST["password"];
        $confirm_password = $_POST["cpassword"];

        // Check if the entered passwords match
        if ($password !== $confirm_password) {
            echo "Passwords do not match. <a href='register.php'>Try again</a>.";
            exit();
        }

        $password = password_hash($password, PASSWORD_BCRYPT);

        // Check if the username already exists
        $check_user_sql = "SELECT * FROM user_info WHERE username='$username'";
        $check_user_result = mysqli_query($conn, $check_user_sql);

        if (mysqli_num_rows($check_user_result) > 0) {
            // Username already exists, display an error
            echo "Username '$username' already exists. <a href='register.php'>Try a different username</a>.";
        } else {
            // Proceed with registration
            $insert_user_sql = "INSERT INTO user_info (username, password) VALUES ('$username', '$password')";
            mysqli_query($conn, $insert_user_sql);

            // Registration successful, redirect to login page
            header("Location: login.html");
        }
    } else {
        echo "Form fields are not set.";
    }
}

mysqli_close($conn);
