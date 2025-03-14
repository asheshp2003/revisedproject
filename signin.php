<?php
require_once 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // to check if inputs are not empty
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Query to get user details
        $sql = "SELECT * FROM customer WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify the hashed password using password_verify()
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['customer_id'] = $user['customer_id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['fullname'] = $user['fullname'];

                if ($user['role'] === 'admin') {
                    header('Location: admindash.php');
                } else {
                    header('Location: userdash.php');
                }
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Invalid email or password.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In</title>
    <link rel="stylesheet" href="./css/all.min.css" />
    <link rel="stylesheet" href="./css/style.css" />
</head>
<body>
<header class="page-header">
    <div class="wrapper">
        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="signup.php">Sign Up</a></li>
            </ul>
        </nav>
    </div>
</header>
<div class="box">  
    <div class="signin-container">
        <h1>Sign In</h1>
        <form method="POST" action="signin.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required />
            </div>
            <button type="submit">Sign In</button>
        </form>
       
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
