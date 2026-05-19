<?php
require_once 'includes/security.php';
require_once 'includes/db_connect.php'; 

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }

    $fullname      = test_input($_POST['fullname']);
    $university_id = test_input($_POST['id']);
    $email         = test_input($_POST['email']);
    $password      = $_POST['password']; 
    $role          = test_input($_POST['role']);

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $check = $pdo->prepare("SELECT email FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            $message = "<p style='color:red; text-align:center;'>This email is already registered!</p>";
        } else {
            $sql = "INSERT INTO users (fullname, university_id, email, password, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([$fullname, $university_id, $email, $hashed_password, $role])) {
                echo "<script>alert('Account created successfully!'); window.location.href='login.php';</script>";
                exit();
            }
        }
    } catch (PDOException $e) {
        $message = "<p style='color:red; text-align:center;'>An error occurred during registration.</p>";
    }
}

$csrf_token = generate_csrf_token();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - YIC Found</title>
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
            <a href="login.php">Login</a>
            <a href="register.php" style="background: rgba(255,255,255,0.2); border-radius: 5px;">Register</a>
        </nav>
    </header>

    <main class="auth-container">
        <h2>Create New Account</h2>
        <?php echo $message; ?>
        <form class="auth-form" action="register.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="id">Student/Staff ID</label>
                <input type="text" id="id" name="id" required>
            </div>
            <div class="form-group">
                <label for="email">University Email</label>
                <input type="email" id="email" name="email" placeholder="@yic.edu.sa" required>
            </div>
            <div class="form-group">
                <label for="password">Create Password</label>
                <input type="password" id="password" name="password" minlength="8" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="auth-btn">Sign Up</button>
            <div class="auth-footer">Already have an account? <a href="login.php">Login here</a></div>
        </form>
    </main>
</body>
</html>
