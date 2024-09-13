<nav class="navbar navbar-expand-md fixed-top navbar-shrink py-3" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <span>Grading System</span>
        </a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
            <span class="visually-hidden">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav mx-auto">
                <!-- Dropdown for Manage -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                        <li><a class="dropdown-item" href="manage-students.php">Manage Students</a></li>
                        <li><a class="dropdown-item" href="manage-teacher.php">Manage Teachers</a></li>
                        <li><a class="dropdown-item" href="encode-grades.php">Encode Grades</a></li>
                    </ul>
                </li>

                <!-- Dropdown for Reports -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Reports
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                        <li><a class="dropdown-item" href="generate-reports.php">Generate Reports</a></li>
                        <!-- Add more report-related items if needed -->
                    </ul>
                </li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="sign_up.php">Sign up</a>
        </div>
    </div>
</nav>
