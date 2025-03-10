<?php
class DatabaseConnection{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "bloomy_db";

function startConnection(){

try {
    $pdo = new PDO("mysql:host=$this->servername;dbname=$this ->db_name",
                    $this ->username,
                    $this ->password
                );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT orders.id, products.name AS product_name, orders.quantity, 
                                orders.customer_name, orders.total_price 
                         FROM orders
                         JOIN products ON orders.product_id = products.id");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .sidebar {
            width: 200px;
            background-color: #444;
            color: #fff;
            position: fixed;
            height: 100%;
            padding-top: 20px;
        }
        .sidebar a {
            display: block;
            color: #fff;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #555;
        }
        .main {
            margin-left: 210px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-edit {
            background-color: #4CAF50;
        }
        .btn-delete {
            background-color: #f44336;
        }
    </style>
    
</head>
<body>
    <div class="header">
        <h1>Admin Panel</h1>
    </div>

    <div class="sidebar">
        <a href="#">Dashboard</a>
        <a href="#">Manage Orders</a>
        <a href="#">Manage Products</a>
        <a href="#">Logout</a>
    </div>

    <div class="main">
        <h2>Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Customer Name</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic rows generated by backend -->
                <tr>
                    <td>1</td>
                    <td>Lipstick</td>
                    <td>2</td>
                    <td>Alice Johnson</td>
                    <td>$39.98</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Foundation</td>
                    <td>1</td>
                    <td>Bob Smith</td>
                    <td>$24.99</td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>