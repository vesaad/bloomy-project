<?php
require_once 'db/connection.php';
try {
    $query = $pdo->query("SELECT id, name, regular_price, sale_price, image_url FROM products");
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching products: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/7f89c2fcf6.js" crossorigin="anonymous"></script>
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
    <script src="cart.js"></script>
</head>
<body>
    <?php include 'header.php' ?>
    <div class="container">
        <div class="product-grid">
            <?php
            $product_index = 1;
            foreach ($products as $product):
            ?>
                <div class="product-card">
                    <img src="products/images/<?= $product['image_url'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>

                    <?php if ($product['regular_price'] > 0 && $product['sale_price'] < $product['regular_price']): ?>
                    <?php else: ?>
                        <span class="offer">No Discount Available</span>
                    <?php endif; ?>

                    <div class="price">
                        <span class="current-price"><?= htmlspecialchars($product['sale_price']) ?>€</span>
                        <span class="original-price"><?= htmlspecialchars($product['regular_price']) ?>€</span>
                        <span class="savings">Save <?= number_format($product['regular_price'] - $product['sale_price'], 2) ?>€</span>
                        <span class="offer"> <?= number_format((($product['regular_price'] - $product['sale_price']) / $product['regular_price']) * 100, 0) ?>% OFF LIMITED TIME OFFER</span>
                    </div>
                    <button class="add-to-cart-btn" data-id="<?= $product['id'] ?>" data-name="<?= htmlspecialchars($product['name']) ?>" data-price="<?= $product['sale_price'] ?>" data-image="<?= htmlspecialchars($product['image_url']) ?>">Add to cart</button>
                </div>
            <?php
                $product_index++;
            endforeach;
            ?>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = this.getAttribute('data-price');
            const image = this.getAttribute('data-image');
            
            let formData = new FormData();
            formData.append('product_id', id);
            formData.append('name', name);
            formData.append('price', price);
            formData.append('image_url', image);
            formData.append('quantity', 1);

            fetch('shoppingcart/addtocart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert('Product added to cart!');
            })
            .catch(error => {
                alert('Error adding product to cart');
            });
        });
    });
});
</script>
<?php include 'footer.php'; ?>
</body>
</html>