<?php include("header.php"); ?>

<body>
<nav class="navbar navbar-expand-md fixed-top navbar-shrink py-3" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php"><span>Grading System</span></a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
            <span class="visually-hidden">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="manageDropdowns" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Encoder
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
               
                        <li><a class="dropdown-item" href="manage-subject.php">Manage Subject</a></li>
                        <li><a class="dropdown-item" href="manage-requirements.php">Requirements</a></li>
                        <li><a class="dropdown-item" href="requirements.php">Requirements List</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Students
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                        <li><a class="dropdown-item" href="manage-students.php">Register Students</a></li>
                        <li><a class="dropdown-item" href="manage-list-students.php">Students List</a></li>
                        <li><a class="dropdown-item" href="student_requirements.php">Requirements</a></li>
                        <li><a class="dropdown-item" href="request_grade_page.php">Request Grade</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="encode-grades.php">Encode Grades</a></li>
                <li class="nav-item"><a class="nav-link active" href="integrations.html">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5">
        <h2 class="mb-4">Monthly Print Attempts of Grades</h2>

        <?php
    include ("connection.php");


        // Query to fetch the total print attempts per month for all students
        $attempts_query = "
            SELECT MONTH(date_print) AS month, YEAR(date_print) AS year, COUNT(*) AS attempts 
            FROM print_attempts 
            GROUP BY YEAR(date_print), MONTH(date_print) 
            ORDER BY YEAR(date_print), MONTH(date_print);
        ";

        $attempts_result = mysqli_query($conn, $attempts_query);

        $data = []; // Associative array to hold data by year

        if (mysqli_num_rows($attempts_result) > 0) {
            while ($row = mysqli_fetch_assoc($attempts_result)) {
                $year = $row['year'];
                $month_name = date("F", mktime(0, 0, 0, $row['month'], 1));
                
                // Initialize the year if it doesn't exist
                if (!isset($data[$year])) {
                    $data[$year] = [];
                }
                
                // Add month and attempts to the corresponding year
                $data[$year][$month_name] = (int)$row['attempts'];
            }

            // Prepare data for Chart.js
            $months = [];
            $attempts = [];

            foreach ($data as $year => $months_data) {
                foreach ($months_data as $month => $attempt) {
                    $months[] = "$month $year";
                    $attempts[] = $attempt;
                }
            }
            
            // Convert data to JSON for Chart.js
            $months_json = json_encode($months);
            $attempts_json = json_encode($attempts);
            
            echo "<h3 class='mt-4'>Total Print Attempts:</h3>";
            echo "<canvas id='attemptsChart' style='max-width: 600px; height: 400px;'></canvas>";
            echo "
                <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
                <script>
                    const ctx = document.getElementById('attemptsChart').getContext('2d');
                    const attemptsChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: $months_json,
                            datasets: [{
                                label: 'Total Print Attempts',
                                data: $attempts_json,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1 // Set the step size to ensure whole numbers on Y-axis
                                    }
                                }
                            }
                        }
                    });
                </script>
            ";

            // Display data in a table format
            echo "<h3 class='mt-4'>Print Attempts per Month:</h3>";
            echo "<button class='btn btn-secondary mb-3' onclick='printTable()'>Print Table</button>";
            echo "<table class='table table-bordered mt-2' id='attemptsTable'>";
            echo "<thead><tr><th>Year</th><th>Month</th><th>Attempts</th></tr></thead><tbody>";
            
            foreach ($data as $year => $months_data) {
                foreach ($months_data as $month => $attempt) {
                    echo "<tr><td>$year</td><td>$month</td><td>$attempt</td></tr>";
                }
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No print attempts found.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>
</section>

<script>
    function printTable() {
        // Get the table element
        var table = document.getElementById('attemptsTable');
        
        // Create a new window
        var printWindow = window.open('', '', 'height=500,width=800');
        
        // Write the HTML for the print window
        printWindow.document.write('<html><head><title>Print Table</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write('<h3>Monthly Print Attempts of Grades</h3>');
        printWindow.document.write(table.outerHTML);
        printWindow.document.write('</body></html>');
        
        // Close the document and print
        printWindow.document.close();
        printWindow.print();
    }
</script>

<?php include("footer.php"); ?>

</body>
</html>
