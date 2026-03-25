<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$event_id = $_GET['id'];

if(isset($_POST['book'])){
    $quantity = $_POST['quantity'];

    $event = $conn->query("SELECT * FROM events WHERE id=$event_id")->fetch_assoc();

    $total = $event['price'] * $quantity;

    $conn->query("INSERT INTO bookings 
    (user_id, event_id, quantity, total_amount)
    VALUES ('".$_SESSION['user_id']."','$event_id','$quantity','$total')");

    echo "Ticket Booked Successfully!";
}
?>

<form method="POST">
    Quantity: <input type="number" name="quantity" required><br>
    <button name="book">Book Ticket</button>
</form>