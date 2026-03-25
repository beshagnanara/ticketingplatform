<?php
session_start();
include 'db.php';

// Only admin can access
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: index.php");
    exit();
}

if(isset($_POST['add_event'])){
    $title = $_POST['title'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO events (title, event_date, location, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $title, $date, $location, $price);
    $stmt->execute();

    $success = "Event Created Successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <h2>Create Event</h2>
    <a href="index.php" class="btn">Back</a>
</div>

<div class="container">
    <div class="card">
        <h3>Add New Event</h3>

        <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

        <form method="POST">

            <label>Event Title</label>
            <input type="text" name="title" required>

            <label>Date</label>
            <input type="date" name="date" required>

            <label>Location</label>
            <input type="text" name="location" required>

            <label>Price</label>
            <input type="number" name="price" step="0.01" required>

            <button type="submit" name="add_event" class="btn">Create Event</button>

        </form>
    </div>
</div>

</body>
</html>