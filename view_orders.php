<?php
session_start();

// Database connection
$mysqli = new mysqli("localhost", "root", "", "bloomy_db");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle form submission for adding/updating orders
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $customerName = $_POST['customer_name'];
    $product = $_POST['product'];
    $status = $_POST['status'];
    $total = $_POST['total'];

    if ($orderId) {
        // Update existing order
        $stmt = $mysqli->prepare("UPDATE orders SET customer_name=?, product=?, status=?, total=? WHERE id=?");
        $stmt->bind_param("ssssi", $customerName, $product, $status, $total, $orderId);
        $stmt->execute();
        $stmt->close();
    } else {
        // Add new order
        $stmt = $mysqli->prepare("INSERT INTO orders (customer_name, product, status, total) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $customerName, $product, $status, $total);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle edit action
$editOrder = null;
if (isset($_GET['edit'])) {
    $orderId = $_GET['edit'];
    $stmt = $mysqli->prepare("SELECT * FROM orders WHERE id=?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $editOrder = $result->fetch_assoc();
    $stmt->close();
}

// Handle delete action
if (isset($_GET['delete'])) {
    $orderId = $_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM orders WHERE id=?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch existing orders from the database
$result = $mysqli->query("SELECT * FROM adminpanel");
$orders = $result->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders - Bloomy</title>
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

        .view-orders {
            padding: 20px;
        }

        .view-orders h1 {
            margin-bottom: 20px;
        }

        .order-form {
            background-color: rgb(255, 228, 233);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .order-form label {
            display: block;
            margin-bottom: 5px;
        }

        .order-form input, .order-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .order-list {
            background-color: rgb(255, 228, 233);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .order-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-list th, .order-list td {
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
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage-products.php">Manage Products</a></li>
            <li><a href="view_orders.php" class="active">View Orders</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="login-update.php">Logout</a></li>
        </ul>
    </nav>

    <section class="view-orders">
        <h1>View Orders</h1>
        
        <div class="order-form">
            <h2><?php echo isset($editOrder) ? 'Edit Order' : 'Add New Order'; ?></h2>
            <form method="POST" action="">
                <input type="hidden" name="order_id" value="<?php echo isset($editOrder) ? $editOrder['id'] : ''; ?>">
                <label for="customer_name">Customer Name</label>
                <input type="text" id="customer_name" name="customer_name" required value="<?php echo isset($editOrder) ? htmlspecialchars($editOrder['customer_name']) : ''; ?>">

                <label for="product">Product</label>
                <input type="text" id="product" name="product" required value="<?php echo isset($editOrder) ? htmlspecialchars($editOrder['product']) : ''; ?>">

                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="Pending" <?php echo (isset($editOrder) && $editOrder['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="Shipped" <?php echo (isset($editOrder) && $editOrder['status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                    <option value="Delivered" <?php echo (isset($editOrder) && $editOrder['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                </select>

                <label for="total">Total</label>
                <input type="number" id="total" name="total" step="0.01" required value="<?php echo isset($editOrder) ? htmlspecialchars($editOrder['total']) : ''; ?>">

                <button type="submit"><?php echo isset($editOrder) ? 'Update Order' : 'Add Order'; ?></button>
            </form>
        </div>

        <div class="order-list">
            <h2>Existing Orders</h2>
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
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['product']); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><?php echo htmlspecialchars($order['total']); ?></td>
                            <td>
                                <a href="?edit=<?php echo $order['id']; ?>">Edit</a> | 
                                <a href="?delete=<?php echo $order['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
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