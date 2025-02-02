<?php
session_start();

// Database connection using PDO
try {
    $pdo = new PDO("mysql:host=localhost;dbname=bloomy_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission for adding/updating products
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $name = $_POST['name'];
    $regularPrice = $_POST['regular_price'];
    $salePrice = $_POST['sale_price'];
    $stock = $_POST['stock'];

    if ($productId) {
        // Update existing product
        $stmt = $pdo->prepare("UPDATE adminProducts SET name=?, regular_price=?, sale_price=?, stock=? WHERE id=?");
        $stmt->execute([$name, $regularPrice, $salePrice, $stock, $productId]);
    } else {
        // Add new product
        $stmt = $pdo->prepare("INSERT INTO adminProducts (name, regular_price, sale_price, stock) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $regularPrice, $salePrice, $stock]);
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle edit action
$editProduct = null;
if (isset($_GET['edit'])) {
    $productId = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM adminProducts WHERE id=?");
    $stmt->execute([$productId]);
    $editProduct = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle delete action
if (isset($_GET['delete'])) {
    $productId = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM adminProducts WHERE id=?");
    $stmt->execute([$productId]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch existing products from the database
$result = $pdo->query("SELECT * FROM adminProducts");
$products = $result->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$pdo = null;
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

                    <label for="regular_price">Regular Price</label>
                    <input type="number" id="regular_price" name="regular_price" step="0.01" required value="<?php echo isset($editProduct) ? htmlspecialchars($editProduct['regular_price']) : ''; ?>">

                    <label for="sale_price">Sale Price</label>
                    <input type="number" id="sale_price" name="sale_price" step="0.01" required value="<?php echo isset($editProduct) ? htmlspecialchars($editProduct['sale_price']) : ''; ?>">

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
                            <th>Regular Price</th>
                            <th>Sale Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['id']); ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['regular_price']); ?></td>
                                <td><?php echo htmlspecialchars($product['sale_price']); ?></td>
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