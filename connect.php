<?php
$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$postcode = isset($_POST['postcode']) ? $_POST['postcode'] : '';
$role = isset($_POST['role']) ? $_POST['role'] : 'user'; 


try {

    $pdo = new PDO('mysql:host=localhost;dbname=bloomy_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "INSERT INTO signup (firstName, lastName, email, password, birthday, address, postcode, role)
            VALUES (:firstName, :lastName, :email, :password, :birthday, :address, :postcode, :role)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':birthday', $birthday);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':postcode', $postcode);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        echo "SignUp Successful...";
    } else {
        echo "Error: Failed to insert data.";
    }
} catch (PDOException $e) {

    echo "Connection failed: " . $e->getMessage();
}
?>

