<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complainproject";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function authenticateAdmin($conn, $username, $passworda, $adminKey)
{
    $sql = "SELECT * FROM admin_accounts WHERE Username = '$username' AND Password = '$passworda' AND Admin_Key = '$adminKey'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['admin_username'];
    $passworda = $_POST['admin_password'];
    $adminKey = $_POST['admin_key'];

    if (authenticateAdmin($conn, $username, $passworda, $adminKey)) {
        header("Location: admin_dashboard.php");
        exit();
    } else {

        echo "Invalid credentials. Please try again.";
    }
}

$conn->close();
