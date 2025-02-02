<?php
session_start();

// Database connection using PDO
try {
    $pdo = new PDO("mysql:host=localhost;dbname=bloomy_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission for adding/updating orders
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $productName = $_POST['product']; // Changed to match the order
    $quantity = $_POST['quantity']; // Assuming you have a quantity field
    $costumerName = $_POST['customer_name'];
    $total = $_POST['total'];
    $address = $_POST['address'];

    if ($orderId) {
        // Update existing order
        $stmt = $pdo->prepare("UPDATE adminpanel SET productName=?, quantity=?, costumerName=?, total=?, address=? WHERE id=?");
        $stmt->execute([$productName, $quantity, $costumerName, $total, $address, $orderId]);
    } else {
        // Add new order
        $stmt = $pdo->prepare("INSERT INTO adminpanel (productName, quantity, costumerName, total, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$productName, $quantity, $costumerName, $total, $address]);
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle edit action
$editOrder = null;
if (isset($_GET['edit'])) {
    $orderId = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM adminpanel WHERE id=?");
    $stmt->execute([$orderId]);
    $editOrder = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle delete action
if (isset($_GET['delete'])) {
    $orderId = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM adminpanel WHERE id=?");
    $stmt->execute([$orderId]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch existing orders from the database
$result = $pdo->query("SELECT * FROM adminpanel");
$orders = $result->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$pdo = null;
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

        .order-form input {
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
            margin-bottom: 20px;
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
                
                <label for="product">Product</label>
                <input type="text" id="product" name="product" required value="<?php echo isset($editOrder) ? htmlspecialchars($editOrder['productName']) : ''; ?>">

                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" required value="<?php echo isset($editOrder) ? htmlspecialchars($editOrder['quantity']) : ''; ?>">

                <label for="customer_name">Customer Name</label>
                <input type="text" id="customer_name" name="customer_name" required value="<?php echo isset($editOrder) ? htmlspecialchars($editOrder['costumerName']) : ''; ?>">

                <label for="total">Total</label>
                <input type="number" id="total" name="total" step="0.01" required value="<?php echo isset($editOrder) ? htmlspecialchars($editOrder['total']) : ''; ?>">

                <label for="address">Address</label>
                <input type="text" id="address" name="address" required value="<?php echo isset($editOrder) ? htmlspecialchars($editOrder['address']) : ''; ?>">

                <button type="submit"><?php echo isset($editOrder) ? 'Update Order' : 'Add Order'; ?></button>
            </form>
        </div>

        <div class="order-list">
            <h2>Existing Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Customer Name</th>
                        <th>Total</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['productName']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($order['costumerName']); ?></td>
                            <td><?php echo htmlspecialchars($order['total']); ?></td>
                            <td><?php echo htmlspecialchars($order['address']); ?></td>
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