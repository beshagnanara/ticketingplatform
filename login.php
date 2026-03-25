<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare query (safer method)
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user && password_verify($password, $user['password'])){

        // Store session values
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        header("Location: index.php");
        exit();

    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Event Platform</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="navbar">
    <h2>Event Ticketing Platform</h2>
</div>

<div class="container">
    <div class="card">
        <h2 style="text-align:center;">Login</h2>

        <?php if(isset($error)) { ?>
            <p style="color:red; text-align:center;"><?php echo $error; ?></p>
        <?php } ?>

        <form method="POST">
            
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="login" class="btn">Login</button>

        </form>

        <p style="text-align:center; margin-top:10px;">
            Don't have an account? <a href="register.php">Register</a>
        </p>

    </div>
</div>

</body>
</html>