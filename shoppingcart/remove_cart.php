<?php
include '../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM shopping_cart WHERE id = ?");
        $stmt->execute([$cart_id]);
        
        header('Location: cart.php');
    } catch (PDOException $e) {
        echo "Error removing item: " . $e->getMessage();
    }
}
?>