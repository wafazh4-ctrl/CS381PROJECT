<?php
require_once 'includes/security.php';
require_once 'includes/db_connect.php';

if (!isset($_GET['id'])) { header("Location: browse.php"); exit(); }
$item_id = test_input($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$item_id]);
$item = $stmt->fetch();

if (!$item) { die("Item not found!"); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Details - <?php echo htmlspecialchars($item['item_name']); ?></title>
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
        <nav><a href="index.php">Home</a></nav>
    </header>

    <main class="details-container">
        <div class="details-image">
            <img src="<?php echo (!empty($item['image_url'])) ? htmlspecialchars($item['image_url']) : 'https://via.placeholder.com/600x400?text=No+Image'; ?>" 
                 alt="<?php echo htmlspecialchars($item['item_name']); ?>">
        </div>

        <div class="details-info">
            <h1><?php echo htmlspecialchars($item['item_name']); ?></h1>
            <span class="status-badge <?php echo ($item['status'] == 'LOST') ? 'status-lost' : 'status-found'; ?>">
                <?php echo $item['status']; ?>
            </span>
            <table class="details-table" style="margin-top:20px;">
                <tr><td class="label-cell">Category:</td><td class="value-cell"><?php echo htmlspecialchars($item['category']); ?></td></tr>
                <tr><td class="label-cell">Description:</td><td class="value-cell"><?php echo htmlspecialchars($item['description']); ?></td></tr>
                <tr><td class="label-cell">Posted By:</td><td class="value-cell"><?php echo htmlspecialchars($item['user_name']); ?></td></tr>
                <tr><td class="label-cell">Date:</td><td class="value-cell"><?php echo date('d/m/Y', strtotime($item['date_posted'])); ?></td></tr>
            </table>
            <div class="back-btn-container">
                 <a href="browse.php" class="view-details-btn" style="display:inline-block; padding: 10px 30px;">Back to Browse</a>
            </div>
        </div>
    </main>
</body>
</html>
