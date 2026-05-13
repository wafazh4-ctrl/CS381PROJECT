<?php
session_start();
require_once 'includes/db_connect.php';



if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: admin_dashboard.php?msg=deleted");
        exit();
    } catch (PDOException $e) {
        $error = "Error deleting item.";
    }
}


if (isset($_GET['resolve_id'])) {
    $id = $_GET['resolve_id'];
    try {
        $stmt = $pdo->prepare("UPDATE items SET is_resolved = 1 WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: admin_dashboard.php?msg=resolved");
        exit();
    } catch (PDOException $e) {
        $error = "Error updating status.";
    }
}


$stmt = $pdo->query("SELECT * FROM items ORDER BY created_at DESC");
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - YIC Found</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        .admin-table th, .admin-table td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        .admin-table th { background-color: #f4f4f4; }
        .btn-delete { color: white; background: #dc3545; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 13px; }
        .btn-resolve { color: white; background: #28a745; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 13px; margin-left: 5px; }
        .status-resolved { color: green; font-weight: bold; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

    <header>
        <div class="logo-section">
            <img src="assets/image/YICLogo.jpg" alt="YIC Logo">
            <div>
                <div style="font-weight: bold; font-size: 18px;">YIC Admin</div>
                <div style="font-size: 12px;">Control Panel</div>
            </div>
        </div>
        <nav>
            <a href="index.php">View Website</a>
            <a href="logout.php" style="color: #ff4d4d;">Logout</a>
        </nav>
    </header>

    <main class="container" style="padding: 40px;">
        <h1>Manage Reported Items</h1>
        
        <?php if(isset($_GET['msg'])): ?>
            <div class="alert alert-success">
                <?php 
                    if($_GET['msg'] == 'deleted') echo "Item has been deleted successfully.";
                    if($_GET['msg'] == 'resolved') echo "Item status updated to Resolved.";
                ?>
            </div>
        <?php endif; ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Reporter</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td>#<?php echo $item['id']; ?></td>
                    <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                    <td>
                        <?php echo htmlspecialchars($item['user_name']); ?><br>
                        <small style="color: #666;"><?php echo htmlspecialchars($item['university_id_display']); ?></small>
                    </td>
                    <td><?php echo htmlspecialchars($item['category']); ?></td>
                    <td>
                        <span class="status-badge <?php echo ($item['status'] == 'LOST') ? 'status-lost' : 'status-found'; ?>">
                            <?php echo $item['status']; ?>
                        </span>
                    </td>
                    <td><?php echo date('Y-m-d', strtotime($item['date_posted'])); ?></td>
                    <td>
                        <a href="admin_dashboard.php?delete_id=<?php echo $item['id']; ?>" 
                           class="btn-delete" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                        
                        <?php if($item['is_resolved'] == 0): ?>
                            <a href="admin_dashboard.php?resolve_id=<?php echo $item['id']; ?>" class="btn-resolve">Mark Resolved</a>
                        <?php else: ?>
                            <span class="status-resolved">✅ Resolved</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if (empty($items)): ?>
                    <tr><td colspan="7" style="text-align:center;">No items found in database.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

</body>
</html>