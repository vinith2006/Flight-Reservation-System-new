<?php
// DB connection
$host = 'localhost';
$db = 'ofbsphp';
$user = 'root';
$pass = 'vinith7904169086';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}

// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $rating >= 1 && $rating <= 5 && $message) {
        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO feedback (name, email, rating, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $rating, $message]);

        // Redirect to feedback.php with success message
        header("Location: feedback.php?success=1");
        exit;
    } else {
        echo "Invalid input.";
    }
} else {
    // Redirect if accessed directly
    header("Location: feedback.php");
    exit;
}