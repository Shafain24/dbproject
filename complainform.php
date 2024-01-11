<?php
// Start the session
session_start();

// Check if the user is logged in

// Connect to the database (replace these values with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complainProject";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user information from the session
$user_roll_no = $_SESSION['roll_no']; // Assuming you set this session variable during login

// Retrieve device_id from URL parameters
$device_id = $_GET['device_id'];

// Process the complaint form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve other form data
    $complaint_type = $_POST["complaint_type"];
    $complaint_details = $_POST["complaint_details"];

    // Generate a unique 5-digit Complaint_ID
    $complaint_id = sprintf('%05d', rand(1, 99999));

    // Insert the complaint into the database
    $sql = "INSERT INTO user_complaints (Roll_No, Device_ID, Complaint_Type, Complaint_Issue, Status, Complaint_ID) VALUES ('$user_roll_no', '$device_id', '$complaint_type', '$complaint_details', 'Pending', '$complaint_id')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Complaint filed successfully. Your Complaint ID is: $complaint_id. Please use this ID to check the status.";
        // Set a session variable to store the success message
        $_SESSION['success_message'] = $success_message;
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
        // Set a session variable to store the error message
        $_SESSION['error_message'] = $error_message;
    }

    // Redirect to the same page to prevent form resubmission on page refresh
    header("Location: {$_SERVER['PHP_SELF']}?device_id=$device_id");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Form</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">File a Complaint</h2>

                <?php
                // Display success or error message if set
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
                    unset($_SESSION['success_message']); // Clear the session variable
                } elseif (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
                    unset($_SESSION['error_message']); // Clear the session variable
                }
                ?>

                <!-- "Go Back" button -->
                <button type="button" class="btn btn-secondary mb-3" onclick="goToHomePage()">Go Back</button>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="complaint_type" class="form-label">Complaint Type</label>
                        <select class="form-select" name="complaint_type" required>
                            <option value="issue">Issue</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="complaint_details" class="form-label">Complaint Details</label>
                        <textarea class="form-control" name="complaint_details" rows="5" required placeholder="Write a brief description"></textarea>
                    </div>

                    <!-- Hidden input fields for roll_no and device_id -->
                    <input type="hidden" name="roll_no" value="<?php echo $user_roll_no; ?>">
                    <input type="hidden" name="device_id" value="<?php echo $device_id; ?>">

                    <button type="submit" class="btn btn-primary">Submit Complaint</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        function goToHomePage() {
            window.location.href = 'dashboard.php'; // Change '/home' to the actual URL of your home page
        }
    </script>
</body>

</html>