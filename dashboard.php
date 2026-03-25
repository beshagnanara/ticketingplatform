<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = $conn->query("
    SELECT bookings.*, events.title, events.event_date, events.location 
    FROM bookings 
    JOIN events ON bookings.event_id = events.id
    WHERE bookings.user_id = $user_id
");

echo "<h2>My Bookings</h2>";

while($row = $result->fetch_assoc()){
    echo "<hr>";
    echo "<b>Event:</b> ".$row['title']."<br>";
    echo "<b>Date:</b> ".$row['event_date']."<br>";
    echo "<b>Location:</b> ".$row['location']."<br>";
    echo "<b>Tickets:</b> ".$row['quantity']."<br>";
    echo "<b>Total Paid:</b> ₹".$row['total_amount']."<br>";
}
?>