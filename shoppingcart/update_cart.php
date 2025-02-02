<?php
include '../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    try {
        $stmt = $pdo->prepare("UPDATE shopping_cart SET quantity = ? WHERE id = ?");
        $stmt->execute([$quantity, $cart_id]);
        
        header('Location: cart.php');
    } catch (PDOException $e) {
        echo "Error updating cart: " . $e->getMessage();
    }
}
?>