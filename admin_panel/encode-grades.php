<?php
include("header.php");
?>
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
                <li class="nav-item"><a class="nav-link " href="manage-students.php">Manage Students</a></li>
                <li class="nav-item"><a class="nav-link" href="manage-teacher.php">Manage Teacher</a></li>
                <li class="nav-item"><a class="nav-link active" href="encode-grades.php">Encode Grades</a></li>
                <li class="nav-item"><a class="nav-link" href="generate-reports.php">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="sign_up.php">Sign up</a>
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
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Course</th>
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
                                '<td>' + student.gender + '</td>' +
                                '<td>' + student.phone + '</td>' +
                                '<td>' + student.email + '</td>' +
                                '<td>' + student.course + '</td>' +
                                '</tr>';
                        });
                    } else {
                        rows = '<tr><td colspan="6" class="text-center">No students found</td></tr>';
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
