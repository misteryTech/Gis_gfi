<?php
    include("header.php");
?>

<body>
<style>
    /* Card Colors */
    .card.sales-card {
        background-color: #007bff; /* Blue */
        color: #fff;
    }

    .card.revenue-card {
        background-color: #28a745; /* Green */
        color: #fff;
    }

    .card.customers-card {
        background-color: #dc3545; /* Red */
        color: #fff;
    }

    .card-icon {
        background-color: #fff;
        color: #000;
    }
</style>
<nav class="navbar navbar-expand-md fixed-top navbar-shrink py-3" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
            <span>Grade Inquiry System</span>
        </a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
            <span class="visually-hidden">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav mx-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="manageDropdowns" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administrator
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
                        <li><a class="dropdown-item" href="admin-panel.php">Admin Panel</a></li>
                    </ul>
                </li>

             

                <li class="nav-item"><a class="nav-link " href="manage-course.php">Manage Course</a></li>
                <li class="nav-item"><a class="nav-link " href="encoder-manage.php">Manage Encoder</a></li>
                <li class="nav-item"><a class="nav-link" href="manage-list-encoders.php">Encoders List</a></li>

                <li class="nav-item"><a class="nav-link" href="generate_reports.php">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<!-- Cards Section -->
<div class="container mt-5 pt-5">
    <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start"><h6>Filter</h6></li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Student <span>| Registered</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light text-dark">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
<?php

// Database connection
$conn = mysqli_connect("localhost", "root", "", "gis_database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



                        // SQL to count total customers
    $sqlTotalStudents = "
        SELECT COUNT(*) AS total_students
        FROM students
    ";
    $resultTotalStudents = $conn->query($sqlTotalStudents);
    $totalStudents = $resultTotalStudents->fetch_assoc()['total_students'];



    $sqlTotalRequest = "
    SELECT COUNT(*) AS total_request
    FROM grade_access_requests_db
";
$resultTotalRequest = $conn->query($sqlTotalRequest);
$totalRequest = $resultTotalRequest->fetch_assoc()['total_request'];



$sqlTotalPrint = "
SELECT COUNT(*) AS total_print
FROM grade_access_requests_db
";
$resultTotalPrint = $conn->query($sqlTotalPrint);
$totalPrint = $resultTotalPrint->fetch_assoc()['total_print'];






    ?>


                            <h6><?php echo $totalStudents; ?></h6>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start"><h6>Filter</h6></li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Request <span>| This Month</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light text-dark">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="ps-3">
                            <h6><?php echo $totalRequest; ?></h6>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card">
                <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start"><h6>Filter</h6></li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Release <span></span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light text-dark">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6><?php echo $totalPrint; ?></h6>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
    include("footer.php");
?>
