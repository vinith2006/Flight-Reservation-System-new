<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
<?php if(isset($_SESSION['userId'])) {   
    require 'helpers/init_conn_db.php';                      
?> 
<style>
/* Modern Styling with Animations */
body {
  background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
  font-family: 'Assistant', sans-serif;
  min-height: 100vh;
}

@font-face {
  font-family: 'product sans';
  src: url('assets/css/Product Sans Bold.ttf');
}

/* Main Container */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

/* Flight Card Styling */
.flight-card {
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    background: white;
    transition: all 0.3s ease;
    margin-bottom: 30px;
    overflow: hidden;
    position: relative;
}

.flight-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

/* Typography */
.city {
    font-size: 24px;
    font-weight: 600;
    color: #2b2d42;
    margin-bottom: 5px;
}

p {
    margin-bottom: 10px;
    font-family: 'Assistant', sans-serif;
}

.date {
    font-size: 18px;
    color: #6c757d;
    font-weight: 500;
}

.time {
    font-size: 28px;
    margin-bottom: 0;
    font-weight: 700;
    color: #4361ee;
}

.stat {
    font-size: 14px;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.page-title {
    font-family: 'product sans', sans-serif !important;
    font-size: 42px !important;
    margin-bottom: 30px !important;
    color: #2b2d42 !important;
    text-align: center;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
    animation: fadeInDown 0.8s ease-out;
    font-weight: bolder !important;
}

/* Alert Styles */
.flight-status {
    font-weight: bold;
    border-radius: 20px;
    padding: 10px 15px;
    animation: fadeIn 0.5s ease-out;
    font-family: 'Assistant', sans-serif;
    text-align: center;
    margin: 10px 0;
    display: inline-block;
}

.status-not-departed {
    background-color: rgba(13, 110, 253, 0.1);
    border: 1px solid rgba(13, 110, 253, 0.2);
    color: #0d6efd;
    animation: pulse 2s infinite;
}

.status-departed {
    background-color: rgba(13, 202, 240, 0.1);
    border: 1px solid rgba(13, 202, 240, 0.2);
    color: #0dcaf0;
}

.status-delayed {
    background-color: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.2);
    color: #dc3545;
    animation: shake 0.8s ease-in-out infinite;
}

.status-arrived {
    background-color: rgba(25, 135, 84, 0.1);
    border: 1px solid rgba(25, 135, 84, 0.2);
    color: #198754;
}

/* Flight Path Animation */
.flight-progress {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 0;
}

.flight-progress .plane-icon {
    position: absolute;
    transition: all 1.5s ease;
    z-index: 2;
    font-size: 24px;
}

.flight-progress .progress-line {
    height: 4px;
    width: 100%;
    background: linear-gradient(90deg, #4361ee 0%, rgba(67, 97, 238, 0.2) 100%);
    position: relative;
    border-radius: 2px;
}

.flight-progress .progress-line.completed {
    background: #4361ee;
}

.flight-progress .progress-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    position: absolute;
    top: -4px;
}

.flight-progress .progress-dot.start {
    left: 0;
    background: #4361ee;
}

.flight-progress .progress-dot.end {
    right: 0;
    background: rgba(67, 97, 238, 0.2);
}

.flight-progress .progress-dot.end.completed {
    background: #4361ee;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeInDown {
    from { 
        opacity: 0; 
        transform: translateY(-20px);
    }
    to { 
        opacity: 1; 
        transform: translateY(0);
    }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-title {
        font-size: 32px !important;
    }
    
    .city {
        font-size: 20px;
    }
    
    .time {
        font-size: 24px;
    }
    
    .date {
        font-size: 16px;
    }
    
    .flight-status {
        font-size: 14px;
        padding: 8px 12px;
    }
    
    .flight-card {
        padding: 20px;
    }
    
    .flight-progress {
        padding: 15px 0;
    }
}

/* No Flights Message */
.no-flights {
    text-align: center;
    padding: 50px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    animation: fadeIn 0.8s ease-out;
}

.no-flights i {
    font-size: 50px;
    color: #6c757d;
    margin-bottom: 20px;
}

.no-flights h3 {
    color: #2b2d42;
    font-family: 'product sans', sans-serif;
}
</style>

<main>
    <div class="container">
        <h1 class="page-title animate__animated animate__fadeIn">Your Flight Status</h1>
        
        <?php 
        $stmt_t = mysqli_stmt_init($conn);
        $sql_t = 'SELECT * FROM Ticket WHERE user_id=?';
        $stmt_t = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt_t,$sql_t)) {
            header('Location: ticket.php?error=sqlerror');
            exit();            
        } else {
            mysqli_stmt_bind_param($stmt_t,'i',$_SESSION['userId']);            
            mysqli_stmt_execute($stmt_t);
            $result_t = mysqli_stmt_get_result($stmt_t);
            
            if(mysqli_num_rows($result_t) == 0) {
                echo '
                <div class="no-flights">
                    <i class="fas fa-plane-slash"></i>
                    <h3>No Upcoming Flights</h3>
                    <p>You don\'t have any booked flights at the moment.</p>
                    <a href="index.php" class="btn btn-primary mt-3">Book a Flight</a>
                </div>';
            } else {
                while($row_t = mysqli_fetch_assoc($result_t)) {     
                    $stmt = mysqli_stmt_init($conn);
                    $sql = 'SELECT * FROM Passenger_profile WHERE passenger_id=?';
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql)) {
                        header('Location: my_flights.php?error=sqlerror');
                        exit();            
                    } else {
                        mysqli_stmt_bind_param($stmt,'i',$row_t['passenger_id']);            
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        if ($row = mysqli_fetch_assoc($result)) {
                            $sql_f = 'SELECT * FROM Flight WHERE flight_id=? ';
                            $stmt_f = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt_f,$sql_f)) {
                                header('Location: my_flights.php?error=sqlerror');
                                exit();            
                            } else {
                                mysqli_stmt_bind_param($stmt_f,'i',$row_t['flight_id']);            
                                mysqli_stmt_execute($stmt_f);
                                $result_f = mysqli_stmt_get_result($stmt_f);
                                if($row_f = mysqli_fetch_assoc($result_f)) {
                                    $date_time_dep = $row_f['departure'];
                                    $date_dep = substr($date_time_dep,0,10);
                                    $time_dep = substr($date_time_dep,10,6);    
                                    $date_time_arr = $row_f['arrivale'];
                                    $date_arr = substr($date_time_arr,0,10);
                                    $time_arr = substr($date_time_arr,10,6);      
                                    
                                    // Determine status
                                    if($row_f['status'] === '') {
                                        $status = "Not yet Departed";
                                        $status_class = 'status-not-departed';
                                        $status_icon = 'fa-clock';
                                        $plane_position = '0';
                                    } else if($row_f['status'] === 'dep') {
                                        $status = "Departed";
                                        $status_class = 'status-departed';
                                        $status_icon = 'fa-plane-departure';
                                        $plane_position = '50%';
                                    } else if($row_f['status'] === 'issue') {
                                        $status = "Delayed";
                                        $status_class = 'status-delayed';
                                        $status_icon = 'fa-exclamation-triangle';
                                        $plane_position = '0';
                                    } else if($row_f['status'] === 'arr') {
                                        $status = "Arrived";
                                        $status_class = 'status-arrived';
                                        $status_icon = 'fa-check-circle';
                                        $plane_position = '100%';
                                    }                           
                                    
                                    echo '
                                    <div class="flight-card animate__animated animate__fadeInUp">
                                        <div class="row">
                                            <div class="col-md-4 order-lg-3 order-md-1">
                                                <div class="flight-progress">
                                                    <div class="progress-line'.($row_f['status'] === 'arr' ? ' completed' : '').'"></div>
                                                    <i class="fas fa-plane plane-icon" style="color: '.($row_f['status'] === '' ? '#adb5bd' : '#4361ee').'; left: '.$plane_position.'; transform: translateX(-50%) '.($row_f['status'] === 'dep' ? 'rotate(45deg)' : '').';"></i>
                                                    <div class="progress-dot start'.($row_f['status'] !== '' ? ' completed' : '').'"></div>
                                                    <div class="progress-dot end'.($row_f['status'] === 'arr' ? ' completed' : '').'"></div>
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-3 col-6 order-md-2 pl-0 text-center order-lg-2">
                                                <p class="city">'.$row_f['source'].'</p>
                                                <p class="stat">Scheduled Departure</p>
                                                <p class="date">'.$date_dep.'</p>                
                                                <p class="time">'.$time_dep.'</p>
                                            </div>        
                                            
                                            <div class="col-md-3 col-6 order-md-4 pr-0 text-center order-lg-4">
                                                <p class="city">'.$row_f['Destination'].'</p>
                                                <p class="stat">Scheduled Arrival</p>
                                                <p class="date">'.$date_arr.'</p>                
                                                <p class="time">'.$time_arr.'</p>          
                                            </div>
                                            
                                            <div class="col-lg-2 order-md-12 d-flex align-items-center justify-content-center">
                                                <div class="flight-status '.$status_class.'">
                                                    <i class="fas '.$status_icon.' mr-2"></i> '.$status.'
                                                </div>
                                            </div>          
                                        </div>
                                    </div>';                     
                                }
                            }            
                        }
                    }    
                }
            }
        }
        ?>    
    </div>
</main>     
<?php } else { ?>
    <div class="container text-center mt-5">
        <div class="alert alert-warning p-4">
            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
            <h3>Please Login to View Your Flight Status</h3>
            <p>You need to be logged in to access your flight information.</p>
            <a href="login.php" class="btn btn-primary mt-2">Login Now</a>
        </div>
    </div>
<?php } ?>
<?php subview('footer.php'); ?>