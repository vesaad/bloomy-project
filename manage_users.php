<?php
session_start();

// Database connection
$mysqli = new mysqli("localhost", "root", "", "bloomy_db");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Handle form submission for adding/updating users
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $postcode = $_POST['postcode'];

    if ($userId) {
        // Update existing user
        $stmt = $mysqli->prepare("UPDATE users SET name=?, lastname=?, email=?, password=?, birthday=?, address=?, postcode=? WHERE id=?");
        $stmt->bind_param("sssssssi", $name, $lastname, $email, $password, $birthday, $address, $postcode, $userId);
        $stmt->execute();
        $stmt->close();
    } else {
        // Add new user
        $stmt = $mysqli->prepare("INSERT INTO users (name, lastname, email, password, birthday, address, postcode) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $lastname, $email, $password, $birthday, $address, $postcode);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle edit action
$editUser  = null;
if (isset($_GET['edit'])) {
    $userId = $_GET['edit'];
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $editUser  = $result->fetch_assoc();
    $stmt->close();
}

// Handle delete action
if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch existing users from the database
$result = $mysqli->query("SELECT * FROM signup");
$users = $result->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Bloomy</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        nav {
            background-color: pink;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav .logo img {
            width: 150px;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
        }

        nav ul li a.active {
            font-weight: bold;
            color: #e91e63; /* Highlight color */
        }

        .manage-users {
            padding: 20px;
        }

        .manage-users h1 {
            margin-bottom: 20px;
        }

        .user-form {
            background-color: rgb(255, 228, 233);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .user-form label {
            display: block;
            margin-bottom: 5px;
        }

        .user-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .user-list {
            background-color: rgb(255, 228, 233);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .user-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-list th, .user-list td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            position: relative;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo"><img src="img/logo.jpg" alt="Bloomy Logo"></div>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage-products.php">Manage Products</a></li>
            <li><a href="view_orders.php">View Orders</a></li>
            <li><a href="manage_users.php" class="active">Manage Users</a></li>
            <li><a href="login-update.php">Logout</a></li>
        </ul>
    </nav>

    <section class="manage-users">
        <h1>Manage Users</h1>
        
        <div class="user-form">
            <h2><?php echo isset($editUser ) ? 'Edit User' : 'Add New User'; ?></h2>
            <form method="POST" action="">
                <input type="hidden" name="user_id" value="<?php echo isset($editUser ) ? $editUser ['id'] : ''; ?>">
                <label for="name">First Name</label>
                <input type="text" id="name" name="name" required value="<?php echo isset($editUser ) ? $editUser ['name'] : ''; ?>">

                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" required value="<?php echo isset($editUser ) ? $editUser ['lastname'] : ''; ?>">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?php echo isset($editUser ) ? $editUser ['email'] : ''; ?>">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <label for="birthday">Birthday</label>
                <input type="date" id="birthday" name="birthday" required value="<?php echo isset($editUser ) ? $editUser ['birthday'] : ''; ?>">

                <label for="address">Address</label>
                <input type="text" id="address" name="address" required value="<?php echo isset($editUser ) ? $editUser ['address'] : ''; ?>">

                <label for="postcode">Postcode</label>
                <input type="text" id="postcode" name="postcode" required value="<?php echo isset($editUser ) ? $editUser ['postcode'] : ''; ?>">

                <button type="submit"><?php echo isset($editUser ) ? 'Update User' : 'Add User'; ?></button>
            </form>
        </div>

        <div class="user-list">
            <h2>Existing Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Birthday</th>
                        <th>Address</th>
                        <th>Postcode</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['firstName']); ?></td>
                            <td><?php echo htmlspecialchars($user['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['birthday']); ?></td>
                            <td><?php echo htmlspecialchars($user['address']); ?></td>
                            <td><?php echo htmlspecialchars($user['postcode']); ?></td>
                            <td>
                                <a href="?edit=<?php echo $user['id']; ?>">Edit</a> | 
                                <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <footer>
        <p>Bloomy Beauty Shop © 2024 - All Rights Reserved</p>
    </footer>
</body>
</html>