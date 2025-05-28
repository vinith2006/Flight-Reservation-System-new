<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); 
require 'helpers/init_conn_db.php';                      
?>  
<link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
/* Enhanced Styles - Only Visual Changes */
body {
    font-family: 'Assistant', sans-serif;
    background: #f5f7fa;
    position: relative;
    min-height: 100vh;
    padding-bottom: 2.5rem;
}

table {
    background-color: white;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease;
    margin-bottom: 30px;
}

table:hover {
    transform: translateY(-5px);
}

@font-face {
    font-family: 'product sans';
    src: url('assets/css/Product Sans Bold.ttf');
}

h1 {
    font-family: 'product sans' !important;
    color: #424242 !important;
    font-size: 40px !important;
    margin: 20px 0 30px;
    text-align: center;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
    animation: fadeInDown 0.8s ease-out;
}

th {
    font-size: 22px;
    font-weight: 600 !important;
    background: #4361ee !important;
    color: white !important;
    padding: 15px !important;
    text-transform: uppercase;
    letter-spacing: 1px;
}

td {
    padding: 12px 15px !important;
    font-size: 16px;
    font-weight: 500 !important;
    color: #424242;
    vertical-align: middle !important;
    border-bottom: 1px solid #f0f0f0;
}

tr {
    transition: all 0.3s ease;
}

tr:hover {
    background-color: #f8f9fa !important;
    transform: scale(1.01);
}

.alert {
    padding: 8px 12px !important;
    border-radius: 20px !important;
    font-weight: 500;
    font-size: 14px;
    display: inline-block;
    animation: fadeIn 0.5s ease-out;
}

.btn-success {
    background-color: #4cc9f0 !important;
    border-color: #4cc9f0 !important;
    border-radius: 20px !important;
    padding: 8px 20px !important;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(76, 201, 240, 0.3);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 201, 240, 0.4);
}

.container-md {
    animation: fadeIn 0.8s ease-out;
}

/* Status Animations */
.alert-primary {
    animation: pulse 2s infinite;
}

.alert-danger {
    animation: shake 0.5s ease-in-out infinite;
}

/* Login link styling */
.login-link {
    color: #4361ee;
    font-weight: 600;
    text-decoration: none;
    border-bottom: 2px dotted #4361ee;
    transition: all 0.3s ease;
}

.login-link:hover {
    color: #3a56d4;
    border-bottom-style: solid;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.03); }
    100% { transform: scale(1); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-3px); }
    75% { transform: translateX(3px); }
}

/* Footer Enhancements */
footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: auto;
    padding: 15px 0;
    background: #4361ee;
    color: white;
    text-align: center;
    animation: fadeInUp 0.8s ease-out;
}

.brand {
    transition: all 0.3s ease;
}

.brand:hover {
    transform: scale(1.1);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    h1 {
        font-size: 28px !important;
    }
    
    th, td {
        font-size: 14px !important;
        padding: 10px !important;
    }
}
</style>

    <main>
        <?php if(isset($_POST['search_but'])) { 
            $dep_date = $_POST['dep_date'];                        
            $ret_date = isset($_POST['ret_date'])? $_POST['ret_date'] : '';  
            $dep_city = $_POST['dep_city'];  
            $arr_city = $_POST['arr_city'];     
            $type = $_POST['type'];
            $f_class = $_POST['f_class'];
            $passengers = $_POST['passengers'];
            if($dep_city === $arr_city){
              header('Location: index.php?error=sameval');
              exit();    
            }
            if($dep_city === '0') {
              header('Location: index.php?error=seldep');
              exit(); 
            }
            if($arr_city === '0') {
              header('Location: index.php?error=selarr');
              exit();              
            }
            ?>
          <div class="container-md mt-2">
            <h1 class="display-4 text-center"
              >FLIGHTS FROM: <br> <?php echo $dep_city; ?> 
                 to <?php echo $arr_city; ?> </h1>
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr class="text-center">
                  <th scope="col">Airline</th>
                  <th scope="col">Departure</th>
                  <th scope="col">Arrival</th>
                  <th scope="col">Status</th>
                  <th scope="col">Fare</th>
                  <th scope="col">Buy</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = 'SELECT * FROM Flight WHERE source=? AND Destination =? AND 
                    DATE(departure)=? ORDER BY Price';
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);                
                mysqli_stmt_bind_param($stmt,'sss',$dep_city,$arr_city,$dep_date);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                  $price = (int)$row['Price']*(int)$passengers;
                  if($type === 'round') {
                    $price = $price*2;
                  }
                  if($f_class == 'B') {
                      $price += 0.5*$price;
                  }
                  if($row['status'] === '') {
                      $status = "Not yet Departed";
                      $alert = 'alert-primary';
                  } else if($row['status'] === 'dep') {
                      $status = "Departed";
                      $alert = 'alert-info';
                  } else if($row['status'] === 'issue') {
                      $status = "Delayed";
                      $alert = 'alert-danger';
                  } else if($row['status'] === 'arr') {
                      $status = "Arrived";
                      $alert = 'alert-success';
                  }                   
                  echo "
                  <tr class='text-center animate__animated animate__fadeIn'>                  
                    <td>".$row['airline']."</td>
                    <td>".$row['departure']."</td>
                    <td>".$row['arrivale']."</td>
                    <td>
                      <div>
                          <div class='alert ".$alert." text-center mb-0 pt-1 pb-1' 
                              role='alert'>
                              ".$status."
                          </div>
                      </div>  
                    </td>                   
                    <td>$ ".$price."</td>
                    ";
                  if(isset($_SESSION['userId']) && $row['status'] === '') {   
                    echo " <td>
                    <form action='pass_form.php' method='post'>
                    <input name='flight_id' type='hidden' value=".$row['flight_id'].">
                      <input name='type' type='hidden' value=".$type.">
                      <input name='passengers' type='hidden' value=".$passengers.">
                      <input name='price' type='hidden' value=".$price.">
                      <input name='ret_date' type='hidden' value=".$ret_date.">
                      <input name='class' type='hidden' value=".$f_class.">
                      <button name='book_but' type='submit' 
                      class='btn btn-success mt-0'>
                      <div style=''>
                      <i class='fa fa-lg fa-check'></i>  
                      </div>
                    </button>
                    </form>
                    </td>                                                       
                    "; 
                  } elseif (isset($_SESSION['userId']) && $row['status'] === 'dep') {
                    echo "<td>Not Available</td>";
                  } else {
                    echo "<td><a href='login.php' class='login-link'>Login to continue</a></td>";
                  }
                  echo '</tr> ';                 
                }
                ?>

              </tbody>
            </table>

          </div>
        <?php } ?>

    </main>
    <?php subview('footer.php'); ?> 
    <footer>
        <em><h5 class="text-center p-0 brand mt-2">
                <img src="assets/images/plane-logo.png" 
                    height="40px" width="40px" alt="">              
            </h5></em>
        <p class="text-center">&copy; <?php echo date('Y');?> - Online Flight Booking</p>
    </footer>