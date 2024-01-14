<?php
$host = "localhost";
$dbname = "complainProject";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (mysqli_connect_error()) {
    die("Connection ERROR: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST["roll_no"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM user_accounts WHERE Roll_No='$roll_no'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {

        if (password_verify($password, $row['Password'])) {

            session_start();
            $_SESSION['roll_no'] = $roll_no;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Incorrect password. <a href='login.html'>Try again</a>.";
        }
    } else {
        echo "User not found. <a href='signup.html'>Register here</a>.";
    }
}

mysqli_close($conn);
