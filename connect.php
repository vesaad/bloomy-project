<?php
$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$postcode = isset($_POST['postcode']) ? $_POST['postcode'] : '';

$conn = new mysqli('localhost','root', '', 'bloomy_db');
if ($conn->connect_error) {
    die('Connection Failed : ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO signup(firstName, lastName, email, password, birthday, address, postcode)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("ssssiss", $firstName, $lastName, $email, $password, $birthday, $address, $postcode);
    if ($stmt->execute()) {
        echo "SignUp Successful...";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>