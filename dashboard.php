<?php
// Connect to the database (replace these values with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complainProject";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$searchDeviceID = isset($_GET['searchDeviceID']) ? $_GET['searchDeviceID'] : '';


$sql = "SELECT * FROM labcomputers";
if (!empty($searchDeviceID)) {
  $sql .= " WHERE Device_ID LIKE '%$searchDeviceID%'";
}
$result = $conn->query($sql);


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Dashboard</title>


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
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar nav-pills mt-1 ">
        <div class="position-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="dashboard.php"> Home </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="view_complaint.php"> Complaint Status </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php"> Logout </a>
            </li>
          </ul>
        </div>
      </nav>


      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">User Dashboard</h1>
        </div>


        <div class="mb-3">
          <form class="d-flex" method="GET">
            <input class="form-control me-2" type="search" placeholder="Search by Device ID" aria-label="Search" name="searchDeviceID" value="<?php echo $searchDeviceID; ?>" />
            <button class="btn btn-outline-success" type="submit">
              Search
            </button>
          </form>
        </div>


        <div class="row">
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<div class="col-md-4 mb-4">';
              echo '<div class="card">';
              echo '<div class="card-body">';
              echo '<h5 class="card-title">Device ID: ' . $row['Device_ID'] . '</h5>';
              echo '<p class="card-text">Model: ' . $row['Model'] . '</p>';
              echo '<p class="card-text">Device Type: ' . $row['Device_Type'] . '</p>';
              echo '<p class="card-text">Location: ' . $row['Location'] . '</p>';



              echo '<a href="complainform.php?device_id=' . $row['Device_ID'] . '" class="btn btn-primary">File a Complaint</a>';

              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
          } else {
            echo '<p>No devices found.</p>';
          }
          ?>
        </div>




      </main>
    </div>
  </div>

  <!-- Bootstrap JS scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>