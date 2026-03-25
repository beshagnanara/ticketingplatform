<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "
    SELECT b.*, e.title, e.event_date, e.location 
    FROM bookings b
    JOIN events e ON b.event_id = e.id
    WHERE b.user_id = $user_id
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <h2>My Bookings</h2>
    <a href="index.php" class="btn">Back</a>
</div>

<div class="container">

<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>

    <div class="card">
        <h3><?php echo $row['title']; ?></h3>
        <p><strong>Date:</strong> <?php echo $row['event_date']; ?></p>
        <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
        <p><strong>Tickets:</strong> <?php echo $row['quantity']; ?></p>
    </div>

<?php
    }
} else {
    echo "<p>No bookings found.</p>";
}
?>

</div>

</body>
</html>