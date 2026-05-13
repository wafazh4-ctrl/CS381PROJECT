<?php

session_start();

require_once 'includes/db_connect.php'; 

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_fullname'] = $user['fullname'];
            $_SESSION['university_id'] = $user['university_id']; 

            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error_msg = "Invalid email or password!";
        }
    } catch (PDOException $e) {
        $error_msg = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - YIC Found</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="background-color: #f8f9fa;">

    <header>
        <div class="logo-section">
            <img src="assets/image/YICLogo.jpg" alt="YIC Logo">
            <div>
                <div style="font-weight: bold; font-size: 18px;">YIC</div>
                <div style="font-size: 12px;">Yanbu Industrial College</div>
            </div>
        </div>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php" style="background: rgba(255,255,255,0.2); border-radius: 5px;">Login</a>
            <a href="register.php">Register</a>
        </nav>
    </header>

    <main class="auth-container">
        <h2>Login</h2>

        <?php if($error_msg): ?>
            <p style="color: red; text-align: center;"><?php echo $error_msg; ?></p>
        <?php endif; ?>
        
        <form class="auth-form" action="login.php" method="POST">
            <div class="form-group">
                <label for="email">University Email</label>
                <input type="email" id="email" name="email" placeholder="@yic.edu.sa" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="auth-btn" style="background-color: var(--primary-purple); color: white; padding: 12px; width: 100%; border: none; border-radius: 8px; cursor: pointer;">
                Login
            </button>
            
            <div class="auth-footer">
                <a href="#">Forgot Password?</a>
                <p style="margin-top: 15px;">Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </form>
    </main>

</body>
</html>