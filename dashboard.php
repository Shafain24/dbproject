<?php
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

// Fetch device data from the database
$sql = "SELECT Device_ID, Model, Device_Type, Location FROM LabComputers";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Dashboard</title>

  <!-- Bootstrap CSS link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <!-- Header -->
  <header class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container-fluid">
      <h1 class="navbar-brand text-white">Complaint System</h1>
    </div>
  </header>

  <!-- Container for main content -->
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
        <div class="position-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#"> View Complaints </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"> Pending Complaints </a>
            </li>
            <!-- Add more sidebar options as needed -->
          </ul>
        </div>
      </nav>

      <!-- Main content area -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">User Dashboard</h1>
        </div>

        <!-- Search bar -->
        <div class="mb-3">
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search by product name" aria-label="Search" />
            <button class="btn btn-outline-success" type="submit">
              Search
            </button>
          </form>
        </div>

        <!-- Display device data -->
        <?php
        // Display device data
        if ($result->num_rows > 0) {
          echo '<div class="row">';
          while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Device ID: ' . $row['Device_ID'] . '</h5>';
            echo '<p class="card-text">Model: ' . $row['Model'] . '</p>';
            echo '<p class="card-text">Device Type: ' . $row['Device_Type'] . '</p>';
            echo '<p class="card-text">Location: ' . $row['Location'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
          echo '</div>';
        } else {
          echo '<p>No devices found.</p>';
        }

        ?>

        <!-- Content specific to the user dashboard goes here -->
      </main>
    </div>
  </div>

  <!-- Bootstrap JS scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>