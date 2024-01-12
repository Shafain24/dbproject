<?php
// Replace these with your actual database credentials
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch complaints based on device ID or complaint ID
function getComplaints($conn, $searchTerm)
{
    $sql = "SELECT * FROM complaints WHERE device_id LIKE '%$searchTerm%' OR complaint_id LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return array();
    }
}

// Function to insert a new complaint
function insertComplaint($conn, $deviceID, $complaint)
{
    $sql = "INSERT INTO complaints (device_id, complaint) VALUES ('$deviceID', '$complaint')";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin Dashboard</span>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- ... Your existing navigation and main content ... -->

            <main class="col-lg-10 col-md-9 ms-sm-auto px-md-4">
                <h2>Student Complaints</h2>

                <!-- Search bar for device ID or complaint ID -->
                <form method="GET">
                    <div class="mb-3">
                        <label for="searchTerm" class="form-label">Search by Device ID or Complaint ID:</label>
                        <input type="text" class="form-control" id="searchTerm" name="searchTerm" placeholder="Enter Device ID or Complaint ID">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>

                <?php
                // Handle search
                if (isset($_GET['searchTerm'])) {
                    $searchTerm = $_GET['searchTerm'];
                    $complaints = getComplaints($conn, $searchTerm);

                    if (count($complaints) > 0) {
                        foreach ($complaints as $complaint) {
                            echo '
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Device Name: ' . $complaint['device_id'] . '</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Submitted by: ' . $complaint['complaint_id'] . '</h6>
                                    <a href="complaint-details.php?id=' . $complaint['complaint_id'] . '" class="btn btn-primary">View Details</a>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '<p>No complaints found.</p>';
                    }
                }
                ?>

                <!-- Add more cards as needed -->

                <!-- Form to submit a new complaint -->
                <h2>Submit a New Complaint</h2>
                <form method="POST">
                    <div class="mb-3">
                        <label for="deviceID" class="form-label">Device ID:</label>
                        <input type="text" class="form-control" id="deviceID" name="deviceID" required>
                    </div>
                    <div class="mb-3">
                        <label for="complaint" class="form-label">Complaint:</label>
                        <textarea class="form-control" id="complaint" name="complaint" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Complaint</button>
                </form>

                <?php
                // Handle form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $deviceID = $_POST['deviceID'];
                    $complaint = $_POST['complaint'];

                    if (insertComplaint($conn, $deviceID, $complaint)) {
                        echo '<p class="text-success">Complaint submitted successfully.</p>';
                    } else {
                        echo '<p class="text-danger">Error submitting complaint.</p>';
                    }
                }
                ?>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>