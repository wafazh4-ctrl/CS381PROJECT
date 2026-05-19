<?php
require_once 'includes/security.php';
require_once 'includes/db_connect.php'; 

try {
    $stmt = $pdo->query("SELECT * FROM items ORDER BY created_at DESC LIMIT 3");
    $recent_items = $stmt->fetchAll();
} catch (PDOException $e) {
    $recent_items = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>YIC - Lost and Found</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header>
        <div class="logo-section">
            <img src="assets/image/YICLogo.jpg" alt="YIC Logo">
            <div>
                <div style="font-weight: bold; font-size: 18px;">YIC</div>
                <div style="font-size: 12px;">Yanbu Industrial College</div>
            </div>
        </div>
        <nav>
            <a href="index.php" class="home-btn">Home</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="report_item.php">Report Item</a>
                <?php if($_SESSION['user_role'] == 'admin'): ?>
                    <a href="admin_dashboard.php" style="color: #ffc107;">Admin Panel</a>
                <?php endif; ?>
                <a href="logout.php" style="color: #ff4d4d;">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>

    <section class="hero">
        <h1>Lost something in YIC?</h1>
        <div class="hero-btns">
            <a href="report_item.php" class="btn btn-report">Report Items</a>
            <a href="browse.php" class="btn btn-browse">Browse All Items</a>
        </div>
    </section>

    <main class="recent-section">
        <h2>Recent Items</h2>
        <div class="items-grid">
            <?php foreach ($recent_items as $item): ?>
                <div class="item-card">
                    <img src="<?php echo (!empty($item['image_url'])) ? htmlspecialchars($item['image_url']) : 'https://via.placeholder.com/500x300?text=No+Image'; ?>" 
                         alt="<?php echo htmlspecialchars($item['item_name']); ?>">
                    
                    <span class="status-badge <?php echo ($item['status'] == 'LOST') ? 'status-lost' : 'status-found'; ?>">
                        <?php echo $item['status']; ?>
                    </span>
                    <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                    <p><?php echo htmlspecialchars(mb_strimwidth($item['description'], 0, 80, "...")); ?></p>
                    <span class="date">Added on: <?php echo date('d/m/Y', strtotime($item['date_posted'])); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>

