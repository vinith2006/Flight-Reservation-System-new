<?php
// Start output buffering at the very beginning
ob_start();

// Include necessary files
require_once 'helpers/helper.php';
require 'helpers/init_conn_db.php';

// Check if form was submitted
if (!isset($_POST['search_but'])) {
    header("Location: index.php");
    exit();
}

// Get form data
$dep_city = $_POST['dep_city'] ?? '';
$arr_city = $_POST['arr_city'] ?? '';
$dep_date = $_POST['dep_date'] ?? '';
$type = $_POST['type'] ?? '';
$f_class = $_POST['f_class'] ?? 'E';
$passengers = $_POST['passengers'] ?? 1;

// For round trips
if ($type === 'round') {
    $ret_date = $_POST['ret_date'] ?? '';
}

// Now we can safely output content
subview('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyJourney - Available Flights</title>
    <!-- CSS Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        /* Your existing CSS styles */
        .flight-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem;
            border-radius: 16px 16px 0 0;
            margin-bottom: 2rem;
        }
        
        /* Add all your other CSS styles here */
        /* ... */
    </style>
</head>
<body>
    <div class="main-container">
        <div class="flight-header">
            <h1><i class="fas fa-plane-departure me-2"></i>Available Flights</h1>
            <p>Find and book your perfect flight</p>
        </div>
        
        <div class="container">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="filter-title"><i class="fas fa-filter"></i> Filter Flights</h4>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="index.php" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Search
                        </a>
                    </div>
                </div>
                <!-- Filter controls -->
                <!-- ... -->
            </div>
            
            <!-- Flight Listing -->
            <?php
            try {
                // Query flights from database
                $sql = "SELECT * FROM flight WHERE departure_city = ? AND arrival_city = ? 
                        AND departure_date = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $dep_city, $arr_city, $dep_date);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while ($flight = $result->fetch_assoc()) {
                        $price = ($f_class === 'E') ? $flight['price_econ'] : $flight['price_bus'];
                        $total_price = $price * $passengers;
                        ?>
                        <div class="flight-card">
                            <!-- Flight card HTML -->
                            <!-- ... -->
                        </div>
                        <?php
                    }
                } else {
                    // No flights found
                    ?>
                    <div class="no-flights">
                        <i class="fas fa-plane-slash"></i>
                        <h3>No Flights Available</h3>
                        <p>We couldn't find any flights matching your search criteria.</p>
                        <a href="index.php" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i> Try Another Search
                        </a>
                    </div>
                    <?php
                }
            } catch (Exception $e) {
                // Handle database errors
                error_log("Database error: " . $e->getMessage());
                ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    There was an error retrieving flight information. Please try again later.
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="container">
            <!-- Footer content -->
            <!-- ... -->
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Your JavaScript code
        $(document).ready(function() {
            // Filter and sorting functionality
            // ...
        });
    </script>
</body>
</html>

<?php
subview('footer.php');
// End output buffering and send output
ob_end_flush();
?>