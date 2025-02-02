<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloomy</title>
    <link rel="stylesheet" href="headerstyle.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet"> 
    <script src="https://kit.fontawesome.com/7f89c2fcf6.js" crossorigin="anonymous"></script>
</head>
<body>

    <nav>
        <div class="logo">
            <img src="img/logo.jpg" alt="Logo">
        </div>
        <input type="checkbox" id="click">
        <label for="click" class="menu-btn">
            <i class="fa-solid fa-bars"></i>
        </label>
        <ul>
            <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
            <li><a href="products.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>">Products</a></li>
            <li><a href="aboutus.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'aboutus.php' ? 'active' : ''; ?>">About us</a></li>
            <li><a href="shoppingcart/cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            <li><a href="signup-update.php"class="<?php echo basename($_SERVER['PHP_SELF']) == 'login-update.php' ? 'active' : ''; ?>"><i class="fa-solid fa-user"></i></a></li>
        </ul>
    </nav>
