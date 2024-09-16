<?php include("header.php"); ?>
<body>
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
                        <li><a class="dropdown-item" href="manage-subject.php">Manage Subject</a></li>
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
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="encode-grades.php">Encode Grades</a></li>
                <li class="nav-item"><a class="nav-link" href="integrations.html">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8 col-xl-6 text-center mx-auto">
                <h2 class="display-6 fw-bold mb-4">Requirements <span class="underline">Form</span></h2>
                <p class="text-muted">Please fill out the form below to register a new requirement.</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <!-- Requirements Form -->
                <form class="p-3 p-xl-4" method="post" id="requirementsForm">
                    <div class="mb-3">
                        <input class="shadow form-control" type="text" id="requirements-title" name="requirements_title" placeholder="Requirements Title" required>
                    </div>
                    <div class="mb-3">
                        <textarea class="shadow form-control" id="description" name="description" rows="4" placeholder="Description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="steps" class="form-label">Steps</label>
                        <select class="shadow form-select" id="steps" name="steps" required>
                            <option value="" disabled selected>Select Step</option>
                            <option value="Step 1">Step 1</option>
                            <option value="Step 2">Step 2</option>
                            <option value="Step 3">Step 3</option>
                            <option value="Step 4">Step 4</option>
                        </select>
                    </div>
                    <div>
                        <button class="btn btn-primary shadow d-block w-100" name="submit_requirements" type="submit">Submit Requirement</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Requirements Table -->
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-12">
                <table class="table table-striped" id="requirementsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Step</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="requirements-table-body">
                        <!-- Data will be populated here -->


                        <?php
                        // Database connection
                        $conn = mysqli_connect("localhost", "root", "", "gis_database");
                        if (!$conn) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                        $sql = "SELECT * FROM requirements";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['title']}</td>
                                    <td>{$row['description']}</td>
                                    <td>{$row['steps']}</td>

                                    <td>
                                        <button class='btn btn-warning edit-btn' data-id='{$row['id']}'>Edit</button>
                                        <button class='btn btn-danger delete-btn' data-id='{$row['id']}'>Delete</button>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No subjects found</td></tr>";
                        }
                        mysqli_close($conn);
                        ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#requirementsTable').DataTable();
// Load requirements into the table



// Form submission for requirements
$('#requirementsForm').on('submit', function(event) {
    event.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        url: 'handle-requirements.php',
        method: 'POST',
        data: formData,
        success: function(response) {
            swal("Success!", "The requirement has been submitted successfully.", "success").then(function() {
                $('#requirementsForm')[0].reset();
                location.reload(); // Refresh the page
            });
        },
        error: function() {
            swal("Error", "There was an error processing your request.", "error");
        }
    });
});


    // Delete requirement
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');

        swal({
            title: "Are you sure?",
            text: "This will delete the requirement.",
            icon: "warning",
            buttons: ["Cancel", "Delete"],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: 'delete-requirement.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(response) {
                        swal("Deleted!", "The requirement has been deleted.", "success").then(function() {
                            loadRequirements();
                        });
                    },
                    error: function() {
                        swal("Error", "There was an error processing your request.", "error");
                    }
                });
            }
        });
    });


});
</script>
</body>
