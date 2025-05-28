<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>

<style>
    /* Modern Flight-themed Background */
    body {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                    url('https://images.unsplash.com/photo-1556388158-158ea5ccacbd?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Form Container with Glass Morphism Effect */
    .form-out {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        padding: 40px;
        margin-top: 60px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideUp 0.8s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    @keyframes slideUp {
        from { 
            opacity: 0;
            transform: translateY(30px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Input Fields with Modern Styling */
    .input-group {
        position: relative;
        margin-bottom: 30px;
    }

    .input-group input {
        width: 100%;
        padding: 15px 15px 10px 15px;
        border: none;
        border-bottom: 2px solid #4361ee;
        background-color: transparent;
        font-size: 16px;
        color: #3a0ca3;
        transition: all 0.3s ease;
    }

    .input-group input:focus {
        outline: none;
        border-bottom: 2px solid #3a0ca3;
        box-shadow: 0 2px 0 0 #3a0ca3;
    }

    .input-group label {
        position: absolute;
        top: 15px;
        left: 15px;
        color: #4361ee;
        font-size: 16px;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .input-group input:focus + label,
    .input-group input:not(:placeholder-shown) + label {
        top: -10px;
        left: 5px;
        font-size: 12px;
        color: #3a0ca3;
        background: white;
        padding: 0 5px;
    }

    /* Buttons with Hover Effects */
    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        transform-style: preserve-3d;
    }

    .btn-info {
        background-color: #4361ee;
        border-color: #4361ee;
    }

    .btn-success {
        background-color: #4cc9f0;
        border-color: #4cc9f0;
    }

    .btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    .btn:active {
        transform: translateY(1px);
    }

    /* Title Animation */
    h1 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        color: #4361ee;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        animation: titleFadeIn 1s ease-out;
    }

    @keyframes titleFadeIn {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* Icons with Pulse Animation */
    .fa-user, .fa-lock {
        color: #4361ee;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-out {
            padding: 30px;
            margin: 30px 15px;
        }
        
        h1 {
            font-size: 28px;
        }
    }
</style>

<main>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="form-out">
        <h1 class="text-center mb-4">LOGIN PANEL</h1>
        
        <form method="POST" action="includes/login.inc.php">
          <div class="input-group">
            <input type="text" name="user_id" id="user_id" placeholder=" " required>
            <label for="user_id">Username/Email</label>
            <div class="input-icon">
              <i class="fa fa-user"></i>
            </div>
          </div>
          
          <div class="input-group">
            <input type="password" name="user_pass" id="user_pass" placeholder=" " required>
            <label for="user_pass">Password</label>
            <div class="input-icon">
              <i class="fa fa-lock"></i>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="reset-pwd.php" class="text-primary">Forgot Password?</a>
          </div>
          
          <div class="d-flex justify-content-between">
            <a href="register.php" class="btn btn-info">
              <i class="fas fa-user-plus mr-2"></i> Register
            </a>
            <button type="submit" name="login_but" class="btn btn-success">
              Login <i class="fa fa-arrow-right ml-2"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</main>

<script>
$(document).ready(function() {
    // Initialize input fields as empty
    $('#user_id, #user_pass').val('');
    
    // Add focus/blur effects
    $('input').on('focus', function() {
        $(this).siblings('label').addClass('active');
    });
    
    $('input').on('blur', function() {
        if ($(this).val() === '') {
            $(this).siblings('label').removeClass('active');
        }
    });
    
    // Initialize labels based on existing values
    $('input').each(function() {
        if ($(this).val() !== '') {
            $(this).siblings('label').addClass('active');
        }
    });
});
</script>

<?php subview('footer.php'); ?>