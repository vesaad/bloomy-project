<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login-update.html");
    exit();
}

$userId = $_SESSION['userId'];

try {
    // Connect to the database
    $pdo = new PDO('mysql:host=localhost;dbname=bloomy_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user data based on session userId
    $sql = "SELECT * FROM signup WHERE id = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="user_dashboard.css">
    <script src="https://kit.fontawesome.com/7f89c2fcf6.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard">
        <h1>Welcome, <?php echo htmlspecialchars($user['firstName']); ?>!</h1>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <p>Birthday: <?php echo htmlspecialchars($user['birthday']); ?></p>
        <p>Address: <?php echo htmlspecialchars($user['address']); ?></p>
        <p>Postcode: <?php echo htmlspecialchars($user['postcode']); ?></p>

        <a href="userlogout.php">Log Out</a>
    </div>
</body>
</html>
