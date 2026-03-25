<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include "../db.php";

// Fetch all registered users
$users = $conn->query("SELECT id, username, email FROM users");

// Fetch all bookings
$sql = "SELECT b.id, u.username, e.event_name, b.booking_date
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN events e ON b.event_id = e.id
        ORDER BY b.booking_date DESC";
$bookings = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body { font-family: Arial; margin: 30px; }
h2 { color: #333; }
table { border-collapse: collapse; width: 90%; margin-bottom: 40px; }
th, td { border: 1px solid #ddd; padding: 8px; }
th { background-color: #4CAF50; color: white; }
tr:nth-child(even) { background-color: #f2f2f2; }
</style>
</head>
<body>

<h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h1>
<a href="logout.php">Logout</a>

<h2>Registered Users</h2>
<table>
<tr><th>ID</th><th>Username</th><th>Email</th></tr>
<?php while($user = $users->fetch_assoc()) { ?>
<tr>
<td><?php echo $user['id']; ?></td>
<td><?php echo htmlspecialchars($user['username']); ?></td>
<td><?php echo htmlspecialchars($user['email']); ?></td>
</tr>
<?php } ?>
</table>

<h2>Event Bookings</h2>
<table>
<tr><th>ID</th><th>User</th><th>Event</th><th>Booking Date</th></tr>
<?php while($booking = $bookings->fetch_assoc()) { ?>
<tr>
<td><?php echo $booking['id']; ?></td>
<td><?php echo htmlspecialchars($booking['username']); ?></td>
<td><?php echo htmlspecialchars($booking['event_name']); ?></td>
<td><?php echo $booking['booking_date']; ?></td>
</tr>
<?php } ?>
</table>

</body>
</html>