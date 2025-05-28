<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>
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

/* Ticket Card Styling */
.ticket-card {
    display: flex;
    margin-bottom: 30px;
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    background: white;
    position: relative;
}

.ticket-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}

.ticket-main {
    flex: 3;
    padding: 30px;
    border-top-left-radius: 25px;
    border-bottom-left-radius: 25px;
}

.ticket-side {
    flex: 1;
    background: linear-gradient(135deg, #376b8d 0%, #2a5673 100%);
    padding: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.ticket-side::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    transform: rotate(30deg);
}

.ticket-actions {
    width: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}

/* Typography */
.brand {
    font-family: 'product sans', sans-serif;
    font-size: 27px !important;
    font-weight: bold;
}

.ticket-title {
    font-family: 'product sans', sans-serif !important;
    font-size: 45px !important;
    margin-bottom: 30px !important;
    color: #2b2d42 !important;
    text-align: center;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
    animation: fadeInDown 0.8s ease-out;
}

.section-head {
    text-transform: uppercase;
    font-family: 'Assistant', sans-serif;
    font-size: 14px;
    margin-bottom: 5px;
    color: #6c757d;
    letter-spacing: 1px;
}

.section-text {
    text-transform: uppercase;
    font-family: 'Assistant', sans-serif;
    font-size: 22px;
    font-weight: bold;
    color: #2b2d42;
    margin-bottom: 15px;
}

.time-text {
    font-size: 36px;
    font-weight: bold;
    color: #4361ee;
    margin-bottom: 10px;
}

.date-text {
    font-size: 16px;
    color: #6c757d;
}

.passenger-name {
    font-size: 24px;
    font-weight: bold;
    color: #2b2d42;
    text-transform: uppercase;
    margin-bottom: 20px;
}

.class-badge {
    font-size: 18px;
    font-weight: bold;
    padding: 5px 15px;
    border-radius: 20px;
    background: #f8f9fa;
    color: #2b2d42;
    display: inline-block;
}

/* Logo and Branding */
.ticket-logo {
    height: 180px;
    width: 180px;
    margin: 20px 0;
    filter: drop-shadow(0 5px 10px rgba(0,0,0,0.2));
    transition: all 0.3s ease;
}

.ticket-logo:hover {
    transform: scale(1.05);
}

/* Dropdown Actions */
.dropdown-menu {
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border: none;
    padding: 10px;
}

.dropdown-item {
    padding: 8px 15px;
    border-radius: 5px;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.action-btn {
    width: 100%;
    text-align: left;
    padding: 8px 15px;
    border-radius: 5px;
    transition: all 0.2s ease;
}

.action-btn i {
    margin-right: 8px;
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
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

/* Responsive Design */
@media (max-width: 992px) {
    .ticket-card {
        flex-direction: column;
    }
    
    .ticket-main {
        border-radius: 25px 25px 0 0;
    }
    
    .ticket-side {
        border-radius: 0 0 25px 25px;
    }
    
    .ticket-actions {
        width: 100%;
        height: 60px;
        border-radius: 0 0 25px 25px;
    }
    
    .section-text {
        font-size: 18px;
    }
    
    .time-text {
        font-size: 28px;
    }
}

@media (max-width: 576px) {
    .ticket-title {
        font-size: 32px !important;
    }
    
    .passenger-name {
        font-size: 20px;
    }
    
    .section-text {
        font-size: 16px;
    }
    
    .ticket-logo {
        height: 120px;
        width: 120px;
    }
}
</style>

<main>
  <?php if(isset($_SESSION['userId'])) {   
    require 'helpers/init_conn_db.php';   
    
    if(isset($_POST['cancel_but'])) {
        $ticket_id = $_POST['ticket_id'];
        $stmt = mysqli_stmt_init($conn);
        $sql = 'SELECT * FROM Ticket WHERE ticket_id=?';
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            header('Location: ticket.php?error=sqlerror');
            exit();            
        } else {
            mysqli_stmt_bind_param($stmt,'i',$ticket_id);            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {   
              $sql_pas = 'DELETE FROM Passenger_profile WHERE passenger_id=?';
              $stmt_pas = mysqli_stmt_init($conn);
              if(!mysqli_stmt_prepare($stmt_pas,$sql_pas)) {
                  header('Location: ticket.php?error=sqlerror');
                  exit();            
              } else {
                  mysqli_stmt_bind_param($stmt_pas,'i',$row['passenger_id']);            
                  mysqli_stmt_execute($stmt_pas);
                  $sql_t = 'DELETE FROM Ticket WHERE ticket_id=?';
                  $stmt_t = mysqli_stmt_init($conn);
                  if(!mysqli_stmt_prepare($stmt_t,$sql_t)) {
                      header('Location: ticket.php?error=sqlerror');
                      exit();            
                  } else {
                      mysqli_stmt_bind_param($stmt_t,'i',$row['ticket_id']);            
                      mysqli_stmt_execute($stmt_t);
                  }                  
              }              
            }
        }        
    }
    
    ?>     
    <div class="container mb-5"> 
    <h1 class="ticket-title">E-TICKETS</h1>

      <?php 
      $stmt = mysqli_stmt_init($conn);
      $sql = 'SELECT * FROM Ticket WHERE user_id=?';
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)) {
          header('Location: ticket.php?error=sqlerror');
          exit();            
      } else {
          mysqli_stmt_bind_param($stmt,'i',$_SESSION['userId']);            
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          while ($row = mysqli_fetch_assoc($result)) {   
            $sql_p = 'SELECT * FROM Passenger_profile WHERE passenger_id=?';
            $stmt_p = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt_p,$sql_p)) {
                header('Location: ticket.php?error=sqlerror');
                exit();            
            } else {
                mysqli_stmt_bind_param($stmt_p,'i',$row['passenger_id']);            
                mysqli_stmt_execute($stmt_p);
                $result_p = mysqli_stmt_get_result($stmt_p);
                if($row_p = mysqli_fetch_assoc($result_p)) {
                  $sql_f = 'SELECT * FROM Flight WHERE flight_id=?';
                  $stmt_f = mysqli_stmt_init($conn);
                  if(!mysqli_stmt_prepare($stmt_f,$sql_f)) {
                      header('Location: ticket.php?error=sqlerror');
                      exit();            
                  } else {
                      mysqli_stmt_bind_param($stmt_f,'i',$row['flight_id']);            
                      mysqli_stmt_execute($stmt_f);
                      $result_f = mysqli_stmt_get_result($stmt_f);
                      if($row_f = mysqli_fetch_assoc($result_f)) {
                        $date_time_dep = $row_f['departure'];
                        $date_dep = substr($date_time_dep,0,10);
                        $time_dep = substr($date_time_dep,10,6);    
                        $date_time_arr = $row_f['arrivale'];
                        $date_arr = substr($date_time_arr,0,10);
                        $time_arr = substr($date_time_arr,10,6); 
                        if($row['class'] === 'E') {
                            $class_txt = 'ECONOMY';
                            $class_badge = 'badge-secondary';
                        } else if($row['class'] === 'B') {
                            $class_txt = 'BUSINESS';
                            $class_badge = 'badge-primary';
                        }
                        echo '
                        <div class="ticket-card animate__animated animate__fadeInUp">
                            <div class="ticket-main">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h2 class="brand text-secondary mb-0">Online Flight Booking</h2>
                                    <span class="class-badge '.$class_badge.'">'.$class_txt.' CLASS</span>
                                </div>
                                <hr>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <p class="section-head">Airline</p>
                                        <p class="section-text">'.$row_f['airline'].'</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="section-head">From</p>
                                        <p class="section-text">'.$row_f['source'].'</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="section-head">To</p>
                                        <p class="section-text">'.$row_f['Destination'].'</p>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <p class="section-head">Passenger</p>
                                        <p class="passenger-name">'.$row_p['f_name'].' '.$row_p['m_name'].' '.$row_p['l_name'].'</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="section-head">Board Time</p>
                                        <p class="section-text">12:45</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <p class="section-head">Departure</p>
                                        <p class="date-text">'.$date_dep.'</p>
                                        <p class="time-text">'.$time_dep.'</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="section-head">Arrival</p>
                                        <p class="date-text">'.$date_arr.'</p>
                                        <p class="time-text">'.$time_arr.'</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="section-head">Gate</p>
                                        <p class="section-text">A22</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="section-head">Seat</p>
                                        <p class="section-text">'.$row['seat_no'].'</p>
                                    </div>
                                </div>
                            </div>
                            <div class="ticket-side">
                                <h2 class="text-white text-center brand mb-4">SkyJourney</h2>
                                <img src="assets/images/plane-logo.png" class="ticket-logo" alt="Airline Logo">
                            </div>
                            <div class="ticket-actions">
                                <div class="dropdown">
                                    <a class="text-reset text-decoration-none" href="#" 
                                        id="dropdownMenuButton" data-toggle="dropdown" 
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v fa-lg"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <form action="ticket.php" method="post">
                                            <input type="hidden" name="ticket_id" value="'.$row['ticket_id'].'">
                                            <button class="action-btn btn-danger" name="cancel_but">
                                                <i class="fa fa-trash"></i> Cancel Ticket
                                            </button>
                                        </form>
                                        <form action="e_ticket.php" target="_blank" method="post">
                                            <input type="hidden" name="ticket_id" value="'.$row['ticket_id'].'">
                                            <button class="action-btn btn-primary mt-2" name="print_but">
                                                <i class="fa fa-print"></i> Print Ticket
                                            </button>
                                        </form>
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
      ?> 
    </div>
  </main>
  <?php } ?>
  <?php subview('footer.php'); ?>