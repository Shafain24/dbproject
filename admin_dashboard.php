<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complainproject";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$searchDeviceID = '';

$result = null;


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['searchDeviceID'])) {

    $searchDeviceID = $_GET['searchDeviceID'];


    $sql = "SELECT * FROM user_complaints WHERE (Device_ID LIKE '%$searchDeviceID%' OR Complaint_ID LIKE '%$searchDeviceID%') AND Status != 'Resolved'";
    $result = $conn->query($sql);
} else {
    $sql = "SELECT * FROM user_complaints WHERE Status != 'Resolved'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body navbar-expand-lg " data-bs-theme="dark">
        <div class="container-fluid">
            <h1 class="navbar-brand  h1">Complaint System</h1>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="d-md-block col-lg-2 col-md-3 bg-light nav-underline">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adminentry.html">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-lg-10 col-md-9 ms-sm-auto px-md-4">
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <h2>Admin Dashboard</h2>
                </div>

                <!-- Search bar -->
                <div class="mb-3">
                    <form class="d-flex" method="GET">
                        <input class="form-control me-2" type="search" placeholder="Search by Device ID or Complaint ID" aria-label="Search" name="searchDeviceID" value="<?php echo $searchDeviceID; ?>" />
                        <button class="btn btn-outline-success" type="submit">
                            Search
                        </button>
                    </form>
                </div>

                <?php
                //  search results
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $viewDetailsURL = 'solvecomplaint.php?Device_ID=' . urlencode($row['Device_ID']) .
                            '&Roll_No=' . urlencode($row['Roll_No']) .
                            '&Complaint_ID=' . urlencode($row['Complaint_ID']) .
                            '&Status=' . urlencode($row['Status']) .
                            '&Complaint_Type=' . urlencode($row['Complaint_Type']) .
                            '&Complaint_Info=' . urlencode($row['Complaint_Issue']);

                        echo '
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Device Name: ' . $row['Device_ID'] . '</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Submitted by: ' . $row['Roll_No'] . '</h6>
                                <a href="' . $viewDetailsURL . '" class="btn btn-primary">View Details</a>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p>No complaints found.</p>';
                }
                ?>


            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<?php

$conn->close();
?>