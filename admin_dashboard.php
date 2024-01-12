<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin Dashboard</span>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="d-md-block col-lg-2 col-md-3 bg-light">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Reports</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Settings</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-lg-10 col-md-9 ms-sm-auto px-md-4">
                <h2>Student Complaints</h2>

                <!-- Search bar for device ID -->
                <div class="mb-3">
                    <input type="text" class="form-control" id="deviceID" placeholder="Enter Device ID">
                </div>

                <!-- Sample complaint data, replace with actual data from your backend -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Device Name: Device123</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Submitted by: John Doe</h6>
                        <a href="complaint-details.html" class="btn btn-primary">View Details</a>
                    </div>
                </div>

                <!-- Add more cards as needed -->
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>