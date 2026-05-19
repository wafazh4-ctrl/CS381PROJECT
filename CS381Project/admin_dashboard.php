<?php
require_once 'includes/security.php';
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        die("CSRF token validation failed.");
    }

    if (isset($_POST['delete_id'])) {
        $id = test_input($_POST['delete_id']);
        try {
            $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: admin_dashboard.php?msg=deleted");
            exit();
        } catch (PDOException $e) {
            $error = "Error deleting item.";
        }
    }

    if (isset($_POST['resolve_id'])) {
        $id = test_input($_POST['resolve_id']);
        try {
            $stmt = $pdo->prepare("UPDATE items SET is_resolved = 1 WHERE id = ?");
            $stmt->execute([$id]);
            header("Location: admin_dashboard.php?msg=resolved");
            exit();
        } catch (PDOException $e) {
            $error = "Error updating status.";
        }
    }
}

$stmt = $pdo->query("SELECT * FROM items ORDER BY created_at DESC");
$items = $stmt->fetchAll();

$csrf_token = generate_csrf_token();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - YIC Found</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .inline-form { display: inline; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

    <div class="admin-layout">
        <aside class="sidebar">
            <div class="logo-section" style="margin-bottom: 30px;">
                <img src="assets/image/YICLogo.jpg" alt="YIC Logo">
                <div>
                    <div style="font-weight: bold; font-size: 16px; color: var(--primary-purple);">YIC Admin</div>
                    <div style="font-size: 11px; color: #666;">Control Panel</div>
                </div>
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="index.php">🌐 View Website</a></li>
                <li><a href="admin_dashboard.php" class="active">📋 Manage Items</a></li>
                <li><a href="report_item.php">➕ Report New Item</a></li>
                <li style="margin-top: 50px;"><a href="logout.php" style="color: #d32f2f;">🚪 Logout</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h1 style="margin: 0; color: #333;">Manage Reported Items</h1>
                <span style="background: var(--btn-secondary); color: var(--primary-purple); padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 14px;">
                    Role: System Admin
                </span>
            </div>
            
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
                        <td><strong><?php echo htmlspecialchars($item['item_name']); ?></strong></td>
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
                        <td><?php echo date('d/m/Y', strtotime($item['date_posted'])); ?></td>
                        <td>
                            <div class="action-btns">
                                <form action="admin_dashboard.php" method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <input type="hidden" name="delete_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                                
                                <?php if($item['is_resolved'] == 0): ?>
                                    <form action="admin_dashboard.php" method="POST" class="inline-form">
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                        <input type="hidden" name="resolve_id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" class="btn-resolve">Mark Resolved</button>
                                    </form>
                                <?php else: ?>
                                    <span style="color: green; font-weight: bold; font-size: 13px; padding-left: 5px;">✅ Resolved</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>

</body>
</html>
