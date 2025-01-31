<!DOCTYPE html>
<html lang="en">
<head>
     
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <script src="https://kit.fontawesome.com/7f89c2fcf6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="test3.css">
    <script src="https://kit.fontawesome.com/7f89c2fcf6.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <nav>
    <div class="logo"><img src="logo2.jpg" alt=""></div>
    <input type="checkbox" id="click">
    <label for="click" class="menu-btn">
        <i class="fa-solid fa-bars"></i>
    </label>
    <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="products.html">Products</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <li><a href="#"><i class="fa-solid fa-cart-shopping"></i></a></li>
        <li><a class="active" href="signup-update.html"><i class="fa-solid fa-user"></i></a></li>
    </ul>
</nav>
  <section>
    <div class="wrapper">
        <form action="login.php" method="POST">
        <h1>Log In</h1>
        <div class="input-box">
            <input type="text" name="email" placeholder="Email Address" required>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="input-box">
            <select name="role" required>
              <option value="user">User</option>
              <option value="admin">Administrator</option>
            </select>
          </div>
        <button type="submit" class="btn">Log In</button>
        <div class="register-link">
            <p>Don't have an account? <a href="signup-update.php">Register here.</a></p>
          </div>
      </form>
     </div>
  </section>
  <script src="script.js"></script>
</body>
</html>