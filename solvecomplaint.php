<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complainproject";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['Complaint_ID'])) {
    $complaintID = $_GET['Complaint_ID'];


    $sql = "SELECT * FROM user_complaints WHERE Complaint_ID = '$complaintID'";
    $result = $conn->query($sql);


    if ($result && $result->num_rows > 0) {
        $complaintDetails = $result->fetch_assoc();
    } else {
        $complaintDetails = null;
    }
} else {
    $complaintDetails = null;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resolve'])) {
    $resolveSQL = "UPDATE user_complaints SET Status = 'Resolved' WHERE Complaint_ID = '$complaintID'";
    $conn->query($resolveSQL);


    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Complaint Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <h1 class="navbar-brand h1">Complaint System</h1>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Complaint Details</h2>

        <?php if ($complaintDetails) : ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Device Name: <?php echo $complaintDetails['Device_ID']; ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Submitted by: <?php echo $complaintDetails['Roll_No']; ?></h6>
                    <h6 class="card-subtitle mb-2 text-muted">Complaint-ID: <?php echo $complaintDetails['Complaint_ID']; ?></h6>
                    <p class="card-text">Complaint Type: <?php echo $complaintDetails['Complaint_Type']; ?></p>
                    <p class="card-text">Description: <?php echo $complaintDetails['Complaint_Issue']; ?></p>
                    <p class="card-text">Status: <?php echo $complaintDetails['Status']; ?></p>

                    <?php if ($complaintDetails['Status'] != 'Resolved') : ?>

                        <form method="POST">
                            <button type="submit" class="btn btn-primary" name="resolve">Resolve</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php else : ?>
            <p>No details found for the provided complaint ID.</p>
        <?php endif; ?>
        <a class="btn btn-secondary mt-3" href="admin_dashboard.php">Back</a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<?php

$conn->close();
?>