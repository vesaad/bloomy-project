<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="test3.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/7f89c2fcf6.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <div class="logo"> <img src="logo2.jpg" alt=""></div>
        <input type="checkbox" id="click">
        <label for="click" class="menu-btn">
            <i class="fa-solid fa-bars"></i>
        </label>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="products.html">Products</a></li>
            <li><a href="aboutus.html">About Us</a></li>
            <li><a href="#"><i class="fa-solid fa-cart-shopping"></i></a></li>
            <li><a class="active" href="login-update.html"><i class="fa-solid fa-user"></i></a></li>
        </ul>
    </nav>
    <section>
        <div class="wrapper">
            <form action="connect.php" method="post">
                <h1>Sign Up</h1>
                <div class="input-box">
                    <input type="text" id="first-name" name="firstName" placeholder="Your First Name" required>
                </div>
                <div class="input-box">
                    <input type="text" id="last-name" name="lastName" placeholder="Your Last Name" required>
                </div>
                <div class="input-box">
                    <input type="email" id="email-login" name="email" placeholder="Your Email" required>
                </div>
                <div class="input-box">
                    <input type="password" id="password-signup" name="password" placeholder="Your Password" required>
                </div>
                <div class="password-error" id="password-error"></div>
                <div class="show-password">
                    <input type="checkbox" id="toggle-password">
                    <label for="toggle-password">Show Password</label>
                </div>
                <div class="input-box">
                    <input type="date" id="birthday" name="birthday" required>
                    <small>Your Birthday*</small>
                </div>
                <div class="input-box">
                    <input type="text" id="address" name="address" placeholder="Your Address" required>
                </div>
                <div class="input-box">
                    <input type="text" id="postcode" name="postcode" placeholder="Post Code" required>
                </div>
                <select name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Administrator</option>
                </select>
                <button type="submit" class="btn">Sign Up</button>
                <div class="register-link">
                  <p>Already have an account? <a href="login-update.php">Log In here.</a></p>
                </div>
            </form>
        </div>
    </section>
    
    <script src="script.js"></script>
</body>
</html>