<?php
include '../db/connection.php';

try {
    $stmt = $pdo->query("SELECT * FROM shopping_cart");
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching cart: " . $e->getMessage());
    die("Error fetching cart items: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
    <script src="https://kit.fontawesome.com/7f89c2fcf6.js" crossorigin="anonymous"></script>
</head>

<body>
    
    <h1 class="cart-title">SHOPPING CART</h1>

    <div class="cart-container">
        <table>
            <thead>
                <tr>
                    <th>ITEM</th>
                    <th>PRICE</th>
                    <th>QUANTITY</th>
                    <th>TOTAL</th>
                    <th>REMOVE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                foreach ($cart_items as $item):
                    $total_price = $item['price'] * $item['quantity'];
                    $grand_total += $total_price;
                ?>
                    <tr>
                        <td class="product">
                            <img src="../products/images/<?= htmlspecialchars($item['image_url']) ?>" alt="">
                            <div class="product-details">
                                <p class="product-name"><?= htmlspecialchars($item['product_name']) ?></p>
                            </div>
                        </td>
                        <td class="price">$<?= number_format($item['price'], 2) ?></td>
                        <td class="quantity">
                            <form action="update_cart.php" method="post">
                                <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1">
                                <button type="submit">Update</button>
                            </form>
                        </td>
                        <td class="total">$<?= number_format($total_price, 2) ?></td>
                        <td class="remove">
                            <form action="remove_cart.php" method="post">
                                <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                <button type="submit"><i class="fa-solid fa-xmark"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-summary">
            <textarea placeholder="Add a note for this seller ..."></textarea>
            <div class="cart-buttons">
                <button class="continue" onclick="window.location.href='../products.php'">CONTINUE SHOPPING</button>
                <button class="checkout" onclick="processCheckout()">CHECKOUT ($<?php echo number_format($grand_total, 2); ?>)</button>
            </div>

            <script>
                function processCheckout() {
                    alert("Thank you for your order! We will process it and deliver it to you soon.");
                    window.location.href = '../products.php'; 
                }
            </script>
        </div>
    </div>
    <script>
        function processCheckout() {
            alert("Thank you for your order! We will process it and deliver it to you soon.");
            window.location.href = '../products.php'; 
        }
    </script>
</body>

</html>