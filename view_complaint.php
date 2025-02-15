<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complainProject";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$complaintID = isset($_GET['complaintID']) ? $_GET['complaintID'] : '';


$sql = "SELECT * FROM user_complaints WHERE Complaint_ID = '$complaintID'";
$result = $conn->query($sql);


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Complaint</title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>

    <header class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container-fluid">
            <h1 class="navbar-brand text-white">Complaint System</h1>
        </div>
    </header>


    <div class="container-fluid">
        <div class="row">

            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar nav-pills">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php"> Home </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-currnt="page" href="view_complaint.php"> View Complaints </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"> Logout </a>
                        </li>

                    </ul>
                </div>
            </nav>


            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">View Complaint</h1>
                </div>


                <div class="mb-3">
                    <form class="d-flex" method="GET">
                        <input class="form-control me-2" type="search" placeholder="Search by Complaint ID" aria-label="Search" name="complaintID" value="<?php echo $complaintID; ?>" />
                        <button class="btn btn-outline-success" type="submit">
                            Search
                        </button>
                    </form>
                </div>


                <?php
                if ($result->num_rows > 0) {
                    $complaint = $result->fetch_assoc();
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h4>Complaint ID: ' . $complaint['Complaint_ID'] . '</h4>';
                    echo '<p>Roll-No: ' . $complaint['Roll_No'] . '</p>';
                    echo '<p>Status: ' . $complaint['Status'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<p>No complaint found with the specified ID.</p>';
                }
                ?>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>