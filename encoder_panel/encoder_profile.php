<?php
include("header.php");
include("connection.php");
// Check if the encoder is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Fetch encoder details from the session
$encoder_id = $_SESSION['id'];
$encoder_email = $_SESSION['encoder_email'];
$encoder_course = $_SESSION['encoder_course'];


$encoder = null;
if ($encoder_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM encoder WHERE id = ?");
    $stmt->bind_param("i", $encoder_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $encoder = $result->fetch_assoc();
    $stmt->close();
}

// Check if the student is found; otherwise, set an error message
if (!$encoder) {
    $error_message = "Encoder details not found.";
}


?>
<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- Add this before the closing </body> tag -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>



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
                <!-- Admin Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="manageDropdowns" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Encoder
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdowns">
     
                        <li><a class="dropdown-item" href="encoder_profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="manage-subject.php">Manage Subject</a></li>
        

                    </ul>
                </li>
                <!-- Manage Students Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Students
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                        <li><a class="dropdown-item" href="manage-students.php">Register Students</a></li>
                        <li><a class="dropdown-item" href="manage-list-students.php">Students List</a></li>
                        <li><a class="dropdown-item" href="request_grade_page.php">Request Grade</a></li>
                    </ul>
                </li>
                <!-- Other Links -->
                <li class="nav-item"><a class="nav-link" href="encode-grades.php">Encode Grades</a></li>
                <li class="nav-item"><a class="nav-link" href="generate_reports.php">Generate Reports</a></li>
            </ul>
            <a class="btn btn-primary shadow" role="button" href="logout.php">Logout</a>
        </div>
    </div>
</nav>



<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-xl-8">
                <h3 class="mb-4">Encoder Profile</h3>

                <?php if (isset($error_message)): ?>
                    <div class="alert alert-warning text-center"><?php echo $error_message; ?></div>
                <?php elseif (isset($success_message)): ?>
                    <div class="alert alert-success text-center"><?php echo $success_message; ?></div>
                <?php else: ?>
                    <div class="encoder-details mb-4">
                        <div class="row align-items-center">
                            <!-- Encoder Photo -->
                            <div class="col-md-3">
                                <img src="../picture/gfi-logo.png" alt="Encoder Image" class="img-fluid rounded" >
                            </div>

                            <!-- Encoder Info -->
                            <div class="col-md-7">
                                <h4><strong>ID:</strong>  <?php echo htmlspecialchars($encoder['id']); ?></h4>
                                <h4><strong>Name:</strong> <?php echo htmlspecialchars($encoder['first_name'] . ' ' . $encoder['last_name']); ?></h4>
                                <p><strong>Gender:</strong> <?php echo htmlspecialchars($encoder['gender']); ?></p>
                                <p><strong>Contact Info (Phone):</strong> <?php echo htmlspecialchars($encoder['phone']); ?></p>
                                <p><strong>Contact Info (Email):</strong> <?php echo htmlspecialchars($encoder['email']); ?></p>
                                <p><strong>Course:</strong> <?php echo htmlspecialchars($encoder['course']); ?></p>
                            </div>
                            <div class="col-md-2 text-end">
                                <!-- Edit Button -->
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editEncoderModal">Edit</button>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Encoder Modal -->
                    <div class="modal fade" id="editEncoderModal" tabindex="-1" aria-labelledby="editEncoderModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editEncoderModalLabel">Edit Encoder Information</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="encoder_photo" class="form-label">Profile Picture</label>
                                            <input type="file" class="form-control" id="encoder_photo" name="encoder_photo" accept="image/*">
                                        </div>

                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($encoder['first_name']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($encoder['last_name']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select" id="gender" name="gender" required>
                                                <option value="Male" <?php echo ($encoder['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                                <option value="Female" <?php echo ($encoder['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($encoder['phone']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($encoder['email']); ?>" required>
                                        </div>
                                  
                                        <div class="mb-3">
                                            <label for="course" class="form-label">Course</label>
                                            <input type="text" class="form-control" id="course" name="course" value="<?php echo htmlspecialchars($encoder['course']); ?>" required>
                                        </div>
                                        <button type="submit" name="update_encoder" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
