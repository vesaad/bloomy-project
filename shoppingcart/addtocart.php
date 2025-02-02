<?php
session_start(); 
include '../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image_url = $_POST['image_url'];
        $quantity = 1;

        $stmt = $pdo->prepare("INSERT INTO shopping_cart (product_id, product_name, price, quantity, image_url) 
                              VALUES (?, ?, ?, ?, ?)");
        
        $result = $stmt->execute([$product_id, $name, $price, $quantity, $image_url]);
        
        echo "Product added successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method";
}
?>