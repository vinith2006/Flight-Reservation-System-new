<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyJourney - About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        /* Additional custom styles for about page */
        .about-hero {
            background: linear-gradient(rgba(67, 97, 238, 0.9), rgba(63, 55, 201, 0.9)), 
                        url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 5rem 0;
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .about-hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            animation: fadeInUp 1s ease-out;
        }
        
        .about-hero p {
            font-size: 1.25rem;
            max-width: 800px;
            margin: 0 auto 2rem;
            animation: fadeInUp 1s ease-out 0.2s;
            animation-fill-mode: both;
        }
        
        .mission-vision {
            background-color: rgba(248, 249, 250, 0.9);
            padding: 4rem 0;
            border-radius: 16px;
            margin-bottom: 3rem;
            box-shadow: var(--shadow-md);
        }
        
        .team-section {
            padding: 4rem 0;
        }
        
        .team-member {
            text-align: center;
            margin-bottom: 2rem;
            transition: var(--transition);
        }
        
        .team-member:hover {
            transform: translateY(-10px);
        }
        
        .team-img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--primary);
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
        }
        
        .team-member:hover .team-img {
            transform: scale(1.05);
            border-color: var(--accent);
        }
        
        .stats-section {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 4rem 0;
            margin: 3rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .stat-item {
            text-align: center;
            padding: 1.5rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-family: 'Montserrat', sans-serif;
        }
        
        .stat-label {
            font-size: 1.25rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <h1 class="section-title">About SkyJourney</h1>
            <p>Your trusted partner for seamless travel experiences across the globe. We make your journey memorable from takeoff to landing.</p>
            <a href="index.php" class="btn-primary" style="max-width: 200px; margin: 0 auto;">Book a Flight</a>
        </div>
    </section>

    <div class="main-container">
        <!-- Our Story Section -->
        <section class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="section-title">Our Story</h2>
                    <p>Founded in 2010, SkyJourney began as a small team of aviation enthusiasts with a big dream - to make air travel more accessible, enjoyable, and stress-free for everyone.</p>
                    <p>What started as a local booking service has grown into one of the leading flight booking platforms, serving millions of travelers across the globe. Our commitment to innovation and customer satisfaction has been the driving force behind our success.</p>
                    <p>Today, we partner with over 50 airlines worldwide to bring you the best prices, the most convenient schedules, and unparalleled customer service.</p>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1556388158-158ea5ccacbd?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" class="card-img" alt="Our Story">
                        <div class="card-overlay">
                            <h3>Our Humble Beginnings</h3>
                            <p>From small office to global platform</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission & Vision Section -->
        <section class="mission-vision">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="text-center p-4">
                            <i class="fas fa-bullseye fa-3x mb-3" style="color: var(--primary);"></i>
                            <h3 class="mb-3">Our Mission</h3>
                            <p>To revolutionize air travel by providing innovative solutions that make booking flights simple, fast, and affordable for everyone, while maintaining the highest standards of customer service.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center p-4">
                            <i class="fas fa-eye fa-3x mb-3" style="color: var(--primary);"></i>
                            <h3 class="mb-3">Our Vision</h3>
                            <p>To become the world's most trusted travel platform, connecting people and cultures through seamless air travel experiences powered by cutting-edge technology.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number" data-count="12">0</div>
                            <div class="stat-label">Years Experience</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number" data-count="5">0</div>
                            <div class="stat-label">Million+ Travelers</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number" data-count="50">0</div>
                            <div class="stat-label">Airline Partners</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-number" data-count="150">0</div>
                            <div class="stat-label">Destinations</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <div class="footer-logo">
                        <img src="assets/images/plane-logo.png" alt="Logo">
                        <h2>SkyJourney</h2>
                    </div>
                    <p>Your trusted partner for seamless travel experiences across the globe. We make your journey memorable from takeoff to landing.</p>
                </div>
                
                
                
                <div class="footer-contact">
                    <h3>Contact Us</h3>
                    <p><i class="fas fa-envelope"></i> vinithmurugan275@gmail.com</p>
                    <p><i class="fas fa-phone"></i>+91 7904169086</p>
                    <p><i class="fas fa-map-marker-alt"></i> SkyJourney Airport City</p>
                    <div class="social-links">
                        
                        <a href="https://www.x.com/kosjajsko"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/mr.chuckle_champ"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/vinith05?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"><i class="fab fa-linkedin-in"></i></a>
                         <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                &copy; <?php echo date('Y'); ?> SkyJourney Flight Booking System. All rights reserved. | Developed by VINITH |
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Animate stats counter
            $('.stat-number').each(function() {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).data('count')
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });

            // Animation for team members
            $('.team-member').each(function(index) {
                $(this).css('animation-delay', (index * 0.2) + 's');
            });

            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });
        });
    </script>
</body>
</html>
<?php subview('footer.php'); ?>