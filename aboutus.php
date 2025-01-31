<?php include "header.php"; ?>

<?php
$servername = "localhost";
$username = "root";  
$password = "";     
$database = "bloomy_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $stmt = $conn->prepare("SELECT title, description FROM content WHERE page = 'about'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $title = $result['title'];
        $description = $result['description'];
    } else {
        $title = "Page Not Found";
        $description = "No content available.";
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link rel="stylesheet" href="aboutus.css">
</head>
<body>

<section class="about-us">
    <div class="container">
    
        <p><?php echo nl2br($description); ?></p>
       
    
    </div>
</section>

</body>
</html>
<?php include 'footer.php'; ?>