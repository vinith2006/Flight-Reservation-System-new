<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); 
require 'helpers/init_conn_db.php';                      
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyJourney - Flight Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* CSS Variables */
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --accent: #f72585;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --gray: #6c757d;
            --success: #4cc9f0;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') no-repeat center center fixed;
            background-size: cover;
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Main Container */
        .booking-container {
            background-color: rgba(255, 255, 255, 0.96);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            margin: 2rem auto;
            max-width: 1200px;
            width: 90%;
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
            position: relative;
            z-index: 10;
        }

        /* Header */
        .booking-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.75rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .booking-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0.15) 0%,
                rgba(255, 255, 255, 0) 60%
            );
            transform: rotate(30deg);
            animation: shine 6s infinite;
        }

        .booking-header img {
            height: 80px;
            margin-right: 1rem;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
            transition: transform 0.4s ease;
        }

        .booking-header:hover img {
            transform: rotate(15deg) scale(1.1);
        }

        .booking-header h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 2.25rem;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Tabs */
        .booking-tabs {
            display: flex;
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            position: relative;
        }

        .booking-tab {
            flex: 1;
            padding: 1.25rem;
            text-align: center;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            border: none;
            background: transparent;
            font-size: 1.05rem;
            letter-spacing: 0.5px;
            z-index: 1;
        }

        .booking-tab::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 4px;
            background-color: white;
            transition: var(--transition);
            border-radius: 2px 2px 0 0;
        }

        .booking-tab:hover::after {
            width: 80%;
        }

        .booking-tab.active {
            background: rgba(255, 255, 255, 0.15);
        }

        .booking-tab.active::after {
            width: 80%;
        }

        /* Forms */
        .booking-form {
            padding: 2.5rem;
        }

        .form-section {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .form-section.active {
            display: block;
        }

        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.75rem;
            color: var(--dark);
            font-weight: 500;
            font-size: 1rem;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: var(--transition);
            background-color: white;
            box-shadow: var(--shadow-sm);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
            outline: none;
        }

        /* Passenger Counter */
        .passenger-counter {
            display: flex;
            align-items: center;
        }

        .counter-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: var(--primary);
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
        }

        .counter-btn:hover {
            background: var(--secondary);
            transform: scale(1.1);
        }

        .counter-value {
            margin: 0 1.5rem;
            font-size: 1.25rem;
            font-weight: 600;
            min-width: 30px;
            text-align: center;
        }

        /* Submit Button */
        .submit-btn {
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            color: white;
            border: none;
            padding: 1rem 1.75rem;
            font-size: 1.1rem;
            border-radius: 10px;
            transition: var(--transition);
            width: 100%;
            margin-top: 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        .submit-btn:hover {
            background: linear-gradient(to right, var(--secondary), var(--primary));
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        /* Destinations Section */
        .destinations-section {
            background-color: rgba(255, 255, 255, 0.96);
            padding: 4rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            color: var(--dark);
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
            font-size: 2.25rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }

        .destination-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            height: 100%;
            position: relative;
        }

        .destination-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .destination-img {
            height: 250px;
            object-fit: cover;
            width: 100%;
            transition: var(--transition);
        }

        .destination-card:hover .destination-img {
            transform: scale(1.05);
        }

        .destination-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
            padding: 1.75rem;
            transform: translateY(100%);
            transition: var(--transition);
        }

        .destination-card:hover .destination-overlay {
            transform: translateY(0);
        }

        .destination-info {
            padding: 1.5rem;
        }

        .destination-info h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-family: 'Montserrat', sans-serif;
        }

        .destination-info p {
            color: var(--gray);
            font-size: 0.95rem;
        }

        /* Footer */
        .booking-footer {
            background-color: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
            margin-top: auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .footer-logo img {
            height: 50px;
            filter: brightness(0) invert(1);
            margin-right: 1rem;
        }

        .footer-logo h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.75rem;
            margin: 0;
        }

        .footer-about p {
            color: #cbd5e1;
            font-size: 0.95rem;
            line-height: 1.7;
        }

        .footer-links h3,
        .footer-contact h3 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .footer-links h3::after,
        .footer-contact h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--primary);
            border-radius: 2px;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.95rem;
            display: inline-block;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }

        .footer-contact p {
            color: #cbd5e1;
            margin-bottom: 1rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .footer-contact i {
            margin-right: 0.75rem;
            color: var(--primary);
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .social-links a:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 3rem;
            margin-top: 3rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInUp {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shine {
            0% { transform: rotate(30deg) translate(-30%, -30%); }
            100% { transform: rotate(30deg) translate(30%, 30%); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .booking-container {
                width: 95%;
            }
        }

        @media (max-width: 992px) {
            .destination-img {
                height: 200px;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .booking-header {
                flex-direction: column;
                text-align: center;
            }
            
            .booking-header img {
                margin-right: 0;
                margin-bottom: 1.5rem;
            }
            
            .booking-header h1 {
                font-size: 2rem;
            }
            
            .booking-tabs {
                flex-direction: column;
            }
            
            .booking-tab {
                padding: 1rem;
            }
            
            .booking-form {
                padding: 1.75rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .footer-links h3::after,
            .footer-contact h3::after {
                left: 50%;
                transform: translateX(-50%);
            }
        }

        @media (max-width: 576px) {
            .booking-header h1 {
                font-size: 1.75rem;
            }
            
            .section-title {
                font-size: 1.75rem;
            }
            
            .destination-img {
                height: 180px;
            }
            
            .submit-btn {
                padding: 0.875rem 1.5rem;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php
    if(isset($_GET['error'])) {
        $error_messages = [
            'sameval' => 'Please select different departure and arrival cities',
            'seldep' => 'Please select a departure city',
            'selarr' => 'Please select an arrival city'
        ];
        
        if(isset($error_messages[$_GET['error']])) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
            Swal.fire({
                title: "Error",
                text: "'.$error_messages[$_GET['error']].'",
                icon: "error",
                confirmButtonColor: "#4361ee",
                background: "#ffffff",
                showClass: {
                    popup: "animate__animated animate__fadeInDown"
                },
                hideClass: {
                    popup: "animate__animated animate__fadeOutUp"
                }
            });
            </script>';
        }
    }
    ?>

    <div class="booking-container">
        <div class="booking-header d-flex flex-column flex-md-row align-items-center justify-content-center">
            <img src="assets/images/plane-logo.png" alt="Flight Logo">
            <h1>SkyJourney Flight Booking</h1>
        </div>
        
        <div class="booking-tabs">
            <button class="booking-tab active" data-tab="roundtrip">Round Trip</button>
            <button class="booking-tab" data-tab="oneway">One Way</button>
        </div>
        
        <div class="booking-form">
            <!-- Round Trip Form -->
            <div id="roundtrip" class="form-section active">
                <form action="book_flight.php" method="post">
                    <input type="hidden" name="type" value="round">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">From</label>
                                <select class="form-select" name="dep_city" required>
                                    <option value="" selected disabled>Select Departure City</option>
                                    <?php
                                    $sql = 'SELECT * FROM Cities';
                                    $stmt = mysqli_stmt_init($conn);
                                    mysqli_stmt_prepare($stmt,$sql);         
                                    mysqli_stmt_execute($stmt);          
                                    $result = mysqli_stmt_get_result($stmt);    
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['city']}'>{$row['city']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">To</label>
                                <select class="form-select" name="arr_city" required>
                                    <option value="" selected disabled>Select Arrival City</option>
                                    <?php
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['city']}'>{$row['city']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Departure Date</label>
                                <input type="date" class="form-control" name="dep_date" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Return Date</label>
                                <input type="date" class="form-control" name="ret_date" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Class</label>
                                <select class="form-select" name="f_class" required>
                                    <option value="E">Economy</option>
                                    <option value="B">Business</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Passengers</label>
                                <div class="passenger-counter">
                                    <button type="button" class="counter-btn minus-btn">-</button>
                                    <span class="counter-value">1</span>
                                    <input type="hidden" name="passengers" class="input-val" value="1">
                                    <button type="button" class="counter-btn plus-btn">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" name="search_but" class="submit-btn">
                        Search Flights <i class="fas fa-search ms-2"></i>
                    </button>
                </form>
            </div>
            
            <!-- One Way Form -->
            <div id="oneway" class="form-section">
                <form action="book_flight.php" method="post">
                    <input type="hidden" name="type" value="one">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">From</label>
                                <select class="form-select" name="dep_city" required>
                                    <option value="" selected disabled>Select Departure City</option>
                                    <?php
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['city']}'>{$row['city']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">To</label>
                                <select class="form-select" name="arr_city" required>
                                    <option value="" selected disabled>Select Arrival City</option>
                                    <?php
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['city']}'>{$row['city']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Departure Date</label>
                                <input type="date" class="form-control" name="dep_date" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Class</label>
                                <select class="form-select" name="f_class" required>
                                    <option value="E">Economy</option>
                                    <option value="B">Business</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Passengers</label>
                        <div class="passenger-counter">
                            <button type="button" class="counter-btn minus-btn">-</button>
                            <span class="counter-value">1</span>
                            <input type="hidden" name="passengers" class="input-val" value="1">
                            <button type="button" class="counter-btn plus-btn">+</button>
                        </div>
                    </div>
                    
                    <button type="submit" name="search_but" class="submit-btn">
                        Search Flights <i class="fas fa-search ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="destinations-section">
        <div class="container">
            <h2 class="section-title">Popular Destinations</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="destination-card">
                        <img src="https://images.unsplash.com/photo-1587474260584-136574528ed5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" class="destination-img" alt="Delhi">
                        <div class="destination-overlay">
                            <h3>Delhi</h3>
                            <p>India's vibrant capital city</p>
                        </div>
                        <div class="destination-info">
                            <h3>Delhi</h3>
                            <p>Explore India's historic capital with its rich culture and modern attractions</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="destination-card">
                        <img src="https://images.unsplash.com/photo-1529253355930-ddbe423a2ac7?ixlib=rb-4.0.3&auto=format&fit=crop&w=2065&q=80" class="destination-img" alt="Mumbai">
                        <div class="destination-overlay">
                            <h3>Mumbai</h3>
                            <p>The city that never sleeps</p>
                        </div>
                        <div class="destination-info">
                            <h3>Mumbai</h3>
                            <p>Experience the bustling energy of India's financial and entertainment capital</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="destination-card">
                        <img src="https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80" class="destination-img" alt="Goa">
                        <div class="destination-overlay">
                            <h3>Goa</h3>
                            <p>Beach paradise</p>
                        </div>
                        <div class="destination-info">
                            <h3>Goa</h3>
                            <p>Relax on beautiful beaches and enjoy the vibrant nightlife</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="booking-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <div class="footer-logo">
                        <img src="assets/images/plane-logo.png" alt="Logo">
                        <h2>SkyJourney</h2>
                    </div>
                    <p>Your trusted partner for seamless travel experiences across the globe. We make your journey memorable from takeoff to landing.</p>
                </div>
                
                <div class="footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i>Home</a></li>
                       
                        <li><a href="about.php"><i class="fas fa-chevron-right me-2"></i>About Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-contact">
                    <h3>Contact Us</h3>
                    <p><i class="fas fa-envelope"></i> vinithmurugan275@gmail.com.com</p>
                    <p><i class="fas fa-phone"></i>+91 7904169086</p>
                    <p><i class="fas fa-map-marker-alt"></i> SkyJourney Airport City</p>
                    <div class="social-links">
                        
                        <a href="https://www.x.com/kosjajsko_"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/mr.chuckle_champ"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/vinith05?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                &copy; <?php echo date('Y'); ?> SkyJourney Flight Booking System. All rights reserved.|Developed by VINITH|
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        // Tab switching with animation
        $('.booking-tab').click(function() {
            const tabId = $(this).data('tab');
            
            // Fade out current active tab
            $('.form-section.active').fadeOut(300, function() {
                $(this).removeClass('active');
                
                // Fade in new tab
                $(`#${tabId}`).fadeIn(300).addClass('active');
            });
            
            // Update active tab button
            $('.booking-tab').removeClass('active');
            $(this).addClass('active');
        });

        // Passenger counter with animation
        $('.plus-btn').click(function() {
            const counter = $(this).siblings('.counter-value');
            const input = $(this).siblings('.input-val');
            let value = parseInt(counter.text());
            
            counter.css('transform', 'scale(1.2)');
            setTimeout(() => {
                counter.css('transform', 'scale(1)');
            }, 200);
            
            value++;
            counter.text(value);
            input.val(value);
        });

        $('.minus-btn').click(function() {
            const counter = $(this).siblings('.counter-value');
            const input = $(this).siblings('.input-val');
            let value = parseInt(counter.text());
            
            if (value > 1) {
                counter.css('transform', 'scale(0.8)');
                setTimeout(() => {
                    counter.css('transform', 'scale(1)');
                }, 200);
                
                value--;
                counter.text(value);
                input.val(value);
            }
        });

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        $('input[type="date"]').attr('min', today);

        // Form validation with better animation
        $('form').submit(function(e) {
            const form = $(this);
            const depCity = form.find('[name="dep_city"]').val();
            const arrCity = form.find('[name="arr_city"]').val();
            
            if (!depCity || !arrCity) {
                e.preventDefault();
                
                // Add shake animation to empty fields
                if (!depCity) {
                    form.find('[name="dep_city"]').parent().addClass('animate__animated animate__headShake');
                    setTimeout(() => {
                        form.find('[name="dep_city"]').parent().removeClass('animate__animated animate__headShake');
                    }, 1000);
                }
                if (!arrCity) {
                    form.find('[name="arr_city"]').parent().addClass('animate__animated animate__headShake');
                    setTimeout(() => {
                        form.find('[name="arr_city"]').parent().removeClass('animate__animated animate__headShake');
                    }, 1000);
                }
                
                Swal.fire({
                    title: 'Error',
                    text: 'Please select both departure and arrival cities',
                    icon: 'error',
                    confirmButtonColor: '#4361ee',
                    background: '#ffffff',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                return false;
            }
            
            if (depCity === arrCity) {
                e.preventDefault();
                
                // Add shake animation to both city selects
                form.find('[name="dep_city"], [name="arr_city"]').parent().addClass('animate__animated animate__headShake');
                setTimeout(() => {
                    form.find('[name="dep_city"], [name="arr_city"]').parent().removeClass('animate__animated animate__headShake');
                }, 1000);
                
                Swal.fire({
                    title: 'Error',
                    text: 'Departure and arrival cities must be different',
                    icon: 'error',
                    confirmButtonColor: '#4361ee',
                    background: '#ffffff',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                return false;
            }
        });
    });
    </script>
</body>
</html>
<?php subview('footer.php'); ?>