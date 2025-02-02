<?php
session_start();

// Database connection using PDO
try {
    $pdo = new PDO("mysql:host=localhost;dbname=bloomy_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch total users
$totalUsersStmt = $pdo->query("SELECT COUNT(*) as total FROM signup");
$totalUsers = $totalUsersStmt->fetch(PDO::FETCH_ASSOC)['total'];

// Fetch total orders
$totalOrdersStmt = $pdo->query("SELECT COUNT(*) as total FROM adminpanel");
$totalOrders = $totalOrdersStmt->fetch(PDO::FETCH_ASSOC)['total'];

// Fetch total products
$totalProductsStmt = $pdo->query("SELECT COUNT(*) as total FROM products");
$totalProducts = $totalProductsStmt->fetch(PDO::FETCH_ASSOC)['total'];

// Fetch recent orders
$recentOrdersStmt = $pdo->query("SELECT * FROM adminpanel ORDER BY created_at DESC LIMIT 5");
$recentOrders = $recentOrdersStmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$pdo = null;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bloomy</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        nav {
            background-color: pink;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav .logo img {
            width: 150px;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
        }

        nav ul li a.active {
            font-weight: bold;
            color: #e91e63; /* Highlight color */
        }

        .dashboard {
            padding: 20px;
        }

        .dashboard h1 {
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat-card {
            background-color: rgb(255, 228, 233);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex: 1;
            margin-right: 20px;
        }

        .stat-card:last-child {
            margin-right: 0;
        }

        .recent-orders {
            background-color: rgb(255, 228, 233);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .recent-orders table {
            width: 100%;
            border-collapse: collapse;
        }

        .recent-orders th, .recent-orders td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            position: relative;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo"><img src="img/logo.jpg" alt="Bloomy Logo"></div>
        <ul>
            <li><a href="admin_dashboard.php" class="active">Dashboard</a></li>
            <li><a href="manage-products.php">Manage Products</a></li>
            <li><a href="view_orders.php">View Orders</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="login-update.php">Logout</a></li>
        </ul>
    </nav>

    <section class="dashboard">
        <h1>Admin Dashboard</h1>
        <div class="stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Orders</h3>
                <p><?php echo $totalOrders; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Products</h3>
                <p><?php echo $totalProducts; ?></p>
            </div>
        </div>

        <div class="recent-orders">
            <h2>Recent Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            
                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['product']); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><?php echo htmlspecialchars($order['total']); ?></td>
                            <td>
                                <a href="view_orders.php?edit=<?php echo $order['id']; ?>">Edit</a> | 
                                <a href="view_orders.php?delete=<?php echo $order['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <footer>
        <p>Bloomy Beauty Shop © 2024 - All Rights Reserved</p>
    </footer>
</body>
</html>