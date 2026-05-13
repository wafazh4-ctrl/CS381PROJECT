<?php
session_start();
require_once 'includes/db_connect.php'; 

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name   = $_POST['item_name'];
    $category    = $_POST['category']; 
    $status      = strtoupper($_POST['item_type']); 
    $description = $_POST['description'];
    $date_posted = date('Y-m-d');
    
    $user_name   = $_SESSION['user_fullname'] ?? 'User'; 
    $u_id_display = $_SESSION['university_id'] ?? 'N/A';

    try {

        $sql = "INSERT INTO items (item_name, category, description, status, date_posted, user_name, university_id_display) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$item_name, $category, $description, $status, $date_posted, $user_name, $u_id_display]);
        
        $message = "success";
    } catch (PDOException $e) {
        $message = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report a Lost or Found Item - YIC</title>
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
            <a href="logout.php" style="color: #ff4d4d;">Logout</a>
        </nav>
    </header>

    <main class="form-container">
        <h1 style="text-align: center; margin-bottom: 30px;">Report a Lost or Found Item</h1>

        <?php if($message == "success"): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                ✅ Your report has been successfully added!
            </div>
        <?php endif; ?>

        <form action="report_item.php" method="POST">
            
            <div class="form-group">
                <label for="item_name">Item Name</label>
                <input type="text" id="item_name" name="item_name" placeholder="e.g., Black Backpack, Calculator" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" required style="width:100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                    <option value="Electronics">Electronics</option>
                    <option value="Personal Items">Personal Items</option>
                    <option value="Documents">Documents</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="item_type">Report Type</label>
                <select id="item_type" name="item_type" required style="width:100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                    <option value="found">I Found Something</option>
                    <option value="lost">I Lost Something</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="color, brand, distinct features..." minlength="10" required></textarea>
            </div>

            <button type="submit" class="submit-btn" style="background-color: var(--primary-purple); color: white; padding: 12px; width: 100%; border: none; border-radius: 8px; cursor: pointer; font-size: 16px;">
                Submit Report
            </button>

        </form>
    </main>

    </body>
</html>