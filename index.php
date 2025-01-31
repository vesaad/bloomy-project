<?php
$servername = "localhost";
$username = "root";  
$password = "";     
$database = "bloomy_db";

try {
   
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bloomy</title>
    <link rel="stylesheet" href="home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet"> 
    <script src="https://kit.fontawesome.com/7f89c2fcf6.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
</head>
<body>


<?php include "header.php"; ?>


    <section class="home" id="home">
        <div class="content">
            <h3>Your Beauty, Simplified</h3>
            <span>Confidence in Every Stroke</span>
            <p>Welcome to Bloomy your ultimate destination for beauty and 
                makeup essentials. Discover top-quality products, expert 
                tips, and everything you need to enhance your unique style. 
                Let's make beauty effortless and fun!</p>
                <a href="products.html" class="btn">Shop now</a>
        </div>
    </section>


    <section class="about" id="about">

        <h1 class="heading"> <span>About</span> us </h1>

        <div class="row">

            <div class="image">
                <img src="img/raree.jpg" alt="">
            </div>

            <div class="content">
                <h3>Why choose us?</h3>
                <p> We offer premium-quality makeup essentials carefully curated 
                    for every skin type. With expert guidance and tips, we make it easy 
                    to perfect your look.</p>
                    <p> Our products combine affordable luxury with 
                    eco-friendly values, ensuring beauty that cares for both you and the 
                    planet. At Bloomy, your beauty journey begins with confidence and style.</p>
                    <a href="aboutus.php" class="btn">Learn more</a>
            </div> 
        </div>
    </section>


    <section class="icons-container">
    <?php
    $stmt = $conn->prepare("SELECT icon_img, title, description FROM icons");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="icons">
                <img src="' . htmlspecialchars($row['icon_img']) . '" alt="">
                <div class="info">
                    <h3>' . htmlspecialchars($row['title']) . '</h3>
                    <span>' . htmlspecialchars($row['description']) . '</span>
                </div>
              </div>';
    }
    ?>
    </section>


    <?php
    $stmt = $conn->prepare("SELECT content FROM text WHERE page = 'index' AND section = 'text'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $homepage_text = $row['content'] ?? 'Default text here'; 
    ?>

    <div class="text">
    <h1><i class="fa-brands fa-instagram"></i>OUR COMMUNITY</h1>
    <p><?php echo $homepage_text; ?></p>
    </div>


    <aside>
        <div class="container">
            <div class="slider-wrapper">
                <div class="image-list">
                    <img src="img/a1.jpg" alt="img-1" class="image-item">
                    <img src="img/a2.png" alt="img-2" class="image-item">
                    <img src="img/a3.png" alt="img-3" class="image-item">
                    <img src="img/a4.png" alt="img-4" class="image-item">
                    <img src="img/a5.png" alt="img-5" class="image-item">
                    <img src="img/a6.png" alt="img-6" class="image-item">
                    <img src="img/a7.png" alt="img-7" class="image-item">
                    <img src="img/a8.png" alt="img-8" class="image-item">
                    <img src="img/a9.png" alt="img-9" class="image-item">
                    <img src="img/a10.jpg" alt="img-10" class="image-item">
                </div>
            </div>
        </div>
    </aside>


    <?php include 'footer.php'; ?>


</body>
</html>
