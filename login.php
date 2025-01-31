<?php
session_start();

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$role = isset($_POST['role']) ? $_POST['role'] : '';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=bloomy_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM signup WHERE email = :email AND role = :role";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role', $role);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        
        echo "User found!<br>";
        echo "Stored password in DB: " . $user['password'] . "<br>";
      
        echo "Entered password: " . $password . "<br>";


        if ($password === $user['password']) {
            echo "Password is correct!";

            $_SESSION['userId'] = $user['id'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['role'] = $user['role'];

     
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
        } else {
         
            echo "Invalid password. Please try again.";
        }
        
    } else {
        echo "No users found with this email and role.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

