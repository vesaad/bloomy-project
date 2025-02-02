<?php
session_start();

// Database connection
$mysqli = new mysqli("localhost", "root", "", "bloomy_db");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle form submission for adding/updating products
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if ($productId) {
        // Update existing product
        $stmt = $mysqli->prepare("UPDATE products SET name=?, price=?, stock=? WHERE id=?");
        $stmt->bind_param("ssii", $name, $price, $stock, $productId);
        $stmt->execute();
        $stmt->close();
    } else {
        // Add new product
        $stmt = $mysqli->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $price, $stock);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle edit action
$editProduct = null;
if (isset($_GET['edit'])) {
    $productId = $_GET['edit'];
    $stmt = $mysqli->prepare("SELECT * FROM products WHERE id=?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $editProduct = $result->fetch_assoc();
    $stmt->close();
}

// Handle delete action
if (isset($_GET['delete'])) {
    $productId = $_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch existing products from the database
$result = $mysqli->query("SELECT * FROM products");
$products = $result->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Bloomy</title>
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

        .container {
            max-width: 1250px; /* Set a maximum width for the container */
            margin: 0 auto; /* Center the container */
            padding: 20px; /* Add padding around the container */
        }

        .manage-products h1 {
            margin-bottom: 20px;
        }

        .product-form {
            background-color: rgb(255, 228, 233);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .product-form label {
            display: block;
            margin-bottom: 5px;
        }

        .product-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .product-list {
            background-color: rgb(255, 228, 233);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .product-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-list th, .product-list td {
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
            <li><a href="manage-products.php" class="active">Manage Products</a></li>
            <li><a href="view_orders.php">View Orders</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="login-update.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <section class="manage-products">
            <h1>Manage Products</h1>
            
            <div class="product-form">
                <h2><?php echo isset($editProduct) ? 'Edit Product' : 'Add New Product'; ?></h2>
                <form method="POST" action="">
                    <input type="hidden" name="product_id" value="<?php echo isset($editProduct) ? $editProduct['id'] : ''; ?>">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" required value="<?php echo isset($editProduct) ? htmlspecialchars($editProduct['name']) : ''; ?>">

                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" step="0.01" required value="<?php echo isset($editProduct) ? htmlspecialchars($editProduct['price']) : ''; ?>">

                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" required value="<?php echo isset($editProduct) ? htmlspecialchars($editProduct['stock']) : ''; ?>">

                    <button type="submit"><?php echo isset($editProduct) ? 'Update Product' : 'Add Product'; ?></button>
                </form>
            </div>

            <div class="product-list">
                <h2>Existing Products</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['id']); ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['price']); ?></td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                <td>
                                    <a href="?edit=<?php echo $product['id']; ?>">Edit</a> | 
                                    <a href="?delete=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <footer>
        <p>Bloomy Beauty Shop © 2024 - All Rights Reserved</p>
    </footer>
</body>
</html>