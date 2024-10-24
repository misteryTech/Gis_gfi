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
                <li class="nav-item"><a class="nav-link active" href="encode-grades.php">Encode Grades</a></li>
                <li class="nav-item"><a class="nav-link" href="generate_reports.php">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div>
                    <!-- Search form -->
                    <div class="mb-3">
                        <input class="shadow form-control" type="text" id="student-search" placeholder="Search Student">
                    </div>
                </div>
            </div>
        </div>

        <!-- Table to display search results -->
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <table class="table table-bordered" id="students-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Year Level</th>
                            <th>Course</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="students-table-body">
                        <!-- Results will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Autocomplete for the search input
    $('#student-search').on('input', function() {
        var query = $(this).val();

        if (query.length > 2) {
            $.ajax({
                url: "search-students.php",
                method: "POST",
                data: { query: query },
                success: function(data) {
                    var students = JSON.parse(data);
                    var rows = '';

                    if (students.length > 0) {
                        students.forEach(function(student) {
                            rows += '<tr>' +
                                '<td>' + student.id + '</td>' +
                                '<td>' + student.first_name + ' ' + student.last_name + '</td>' +
                                '<td>' + student.year_level + '</td>' +
                                '<td>' + student.course + '</td>' +
                                '<td><a class="btn btn-primary" href="encoding_grade.php?student_id=' + student.id + '">Encode Grades</a></td>' +
                                '</tr>';
                        });
                    } else {
                        rows = '<tr><td colspan="5" class="text-center">No students found</td></tr>';
                    }

                    $('#students-table-body').html(rows);
                }
            });
        } else {
            $('#students-table-body').html('');
        }
    });
});
</script>
</body>
</html>
