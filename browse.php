<?php
session_start();
require_once 'includes/db_connect.php'; 

$stmt = $pdo->query("SELECT * FROM items ORDER BY created_at DESC");
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse All Items - YIC</title>
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
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </nav>
    </header>

    <h1 style="text-align: center; color: var(--primary-purple); margin-top: 30px;">Browse All Items</h1>

    <div class="search-container">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search by item name...">
        </div>
        <div class="filter-box">
            <select id="categoryFilter">
                <option value="All">All Categories</option>
                <option value="Electronics">Electronics</option>
                <option value="Personal Items">Personal Items</option>
                <option value="Documents">Documents</option>
            </select>
        </div>
    </div>

    <main class="recent-section">
        <div class="items-grid" id="itemsGrid">
            <?php foreach ($items as $item): ?>
                <div class="item-card">
                    <img src="<?php echo (!empty($item['image_url'])) ? htmlspecialchars($item['image_url']) : 'https://via.placeholder.com/500x300?text=' . urlencode($item['item_name']); ?>" 
                         alt="<?php echo htmlspecialchars($item['item_name']); ?>">
                    
                    <span class="status-badge <?php echo ($item['status'] == 'LOST') ? 'status-lost' : 'status-found'; ?>">
                        <?php echo $item['status']; ?>
                    </span>
                    <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                    <span class="item-category"><?php echo htmlspecialchars($item['category']); ?></span>
                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                    <span class="date">Added on: <?php echo date('d/m/Y', strtotime($item['date_posted'])); ?></span>
                    <a href="details.php?id=<?php echo $item['id']; ?>" class="view-details-btn">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');

        function filterItems() {
            const searchText = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value;
            const itemCards = document.querySelectorAll('.item-card');

            itemCards.forEach(card => {
                const title = card.querySelector('h3').innerText.toLowerCase();
                const category = card.querySelector('.item-category').innerText;
                const matchesSearch = title.includes(searchText);
                const matchesCategory = selectedCategory === "All" || category === selectedCategory;
                card.style.display = (matchesSearch && matchesCategory) ? "block" : "none";
            });
        }
        searchInput.addEventListener('keyup', filterItems);
        categoryFilter.addEventListener('change', filterItems);
    </script>
</body>
</html>