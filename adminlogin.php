<?php
// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complainproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to authenticate admin
function authenticateAdmin($conn, $username, $password, $adminKey)
{
    $sql = "SELECT * FROM admin_accounts WHERE Username = '$username' AND Password = '$password' AND Admin_Key = '$adminKey'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['admin_username'];
    $password = $_POST['admin_password'];
    $adminKey = $_POST['admin_key'];

    if (authenticateAdmin($conn, $username, $password, $adminKey)) {
        // Successful login, redirect to the admin dashboard or wherever you want
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Failed login, you may display an error message
        echo "Invalid credentials. Please try again.";
    }
}

$conn->close();
