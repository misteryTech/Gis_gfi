<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gis_database";
$redirectPage = "404.php"; // Specify the page to redirect to if no connection

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the requirements
    $stmt = $conn->prepare("SELECT steps, title, description FROM requirements ORDER BY steps ASC");
    $stmt->execute();
    $requirements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Start the HTML output
    include("header.php"); // Include header

    echo '<body>';
    include("topnav.php"); // Include top navigation

    echo '<section class="py-5 my-5">
        <div class="container py-5">
            <div class="row mb-2">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="display-6 fw-bold mb-5">Requirements <span class="pb-3 underline">Procedures<br></span></h2>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-8 mx-auto">
                    <div class="accordion text-muted" role="tablist" id="accordion-1">';

    foreach ($requirements as $index => $requirement) {
        $step = htmlspecialchars($requirement['steps']);
        $title = htmlspecialchars($requirement['title']);
        $description = htmlspecialchars($requirement['description']);
        $isActive = $index === 0 ? 'show' : '';
        echo '<div class="accordion-item">
                <h2 class="accordion-header" role="tab">
                    <button class="accordion-button ' . ($index === 0 ? '' : 'collapsed') . '" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-1 .item-' . ($index + 1) . '" aria-expanded="' . ($index === 0 ? 'true' : 'false') . '" aria-controls="accordion-1 .item-' . ($index + 1) . '">' . $step . '. ' . $title . '</button>
                </h2>
                <div class="accordion-collapse collapse ' . $isActive . ' item-' . ($index + 1) . '" role="tabpanel" data-bs-parent="#accordion-1">
                    <div class="accordion-body">
                        <p>' . $description . '</p>
                    </div>
                </div>
            </div>';
    }

    echo '        </div>
            </div>
        </div>
    </section>';

    include("footer.php"); // Include footer
    echo '</body></html>';

} catch (PDOException $e) {
    // Redirect to the specified page in case of error
    header("Location: $redirectPage");
    exit();
}
?>
