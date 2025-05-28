<?php ?>

<style>
  .feedback-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 30px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .form-group {
    margin-bottom: 25px;
    position: relative;
  }

  .form-group label {
    display: block;
    margin-bottom: 8px;
    color: #4361ee;
    font-weight: 500;
  }

  .form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    font-size: 16px;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
  }

  .form-control:focus {
    border-color: #4361ee;
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
    outline: none;
    background-color: white;
  }

  textarea.form-control {
    min-height: 120px;
    resize: vertical;
  }

  .rating-container {
    display: flex;
    gap: 10px;
    margin: 15px 0;
  }

  .rating-option {
    cursor: pointer;
    padding: 8px 15px;
    background: #f0f0f0;
    border-radius: 20px;
    transition: all 0.3s ease;
  }

  .rating-option:hover,
  .rating-option.active {
    background: #4361ee;
    color: white;
  }

  .btn-submit {
    background: #4361ee;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .btn-submit:hover {
    background: #3a0ca3;
    transform: translateY(-2px);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  }

  .alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 6px;
  }

  .alert-success {
    background-color: #d4edda;
    color: #155724;
  }

  .alert-danger {
    background-color: #f8d7da;
    color: #721c24;
  }
</style>

<div class="feedback-container">
  <h2>Submit Your Feedback</h2>

  <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
    <div class="alert alert-success">Thank you for your feedback!</div>
  <?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
  <?php endif; ?>

  <form method="POST" action="submit_feedback.php">
    <div class="form-group">
      <label for="name">Full Name</label>
      <input type="text" class="form-control" id="name" name="name"
             value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
    </div>

    <div class="form-group">
      <label for="email">Email Address</label>
      <input type="email" class="form-control" id="email" name="email"
             value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
    </div>

    <div class="form-group">
      <label>Rating</label>
      <div class="rating-container">
        <?php for ($i = 1; $i <= 5; $i++): ?>
          <div class="rating-option <?php echo (isset($_POST['rating']) && $_POST['rating'] == $i) ? 'active' : ''; ?>"
               data-value="<?php echo $i; ?>">
            <?php echo $i . ' ' . ($i == 1 ? 'star' : 'stars'); ?>
          </div>
        <?php endfor; ?>
        <input type="hidden" name="rating" id="rating-value"
               value="<?php echo htmlspecialchars($_POST['rating'] ?? ''); ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label for="message">Your Feedback</label>
      <textarea class="form-control" id="message" name="message" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
    </div>

    <button type="submit" class="btn-submit">Submit Feedback</button>
  </form>
</div>

<script>
  document.querySelectorAll('.rating-option').forEach(option => {
    option.addEventListener('click', function () {
      document.querySelectorAll('.rating-option').forEach(opt => opt.classList.remove('active'));
      this.classList.add('active');
      document.getElementById('rating-value').value = this.dataset.value;
    });
  });

  document.querySelector('form')?.addEventListener('submit', function (e) {
    if (!document.getElementById('rating-value').value) {
      e.preventDefault();
      alert('Please select a rating');
    }
  });
</script>

<?php include_once 'footer.php'; ?>
