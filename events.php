<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Ticketing Platform</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2>Event Ticketing Platform</h2>

    <div>
        <?php if(isset($_SESSION['user_id'])) { ?>

            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <a href="create_event.php" class="btn">Create Event</a>
            <?php } ?>

            <a href="my_bookings.php" class="btn">My Bookings</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>

        <?php } else { ?>

            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Register</a>

        <?php } ?>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <h2>Available Events</h2>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date ASC");

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
    ?>

        <div class="card">
            <h3><?php echo $row['title']; ?></h3>
            <p><strong>Date:</strong> <?php echo $row['event_date']; ?></p>
            <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
            <p><strong>Price:</strong> ₹<?php echo $row['price']; ?></p>

            <?php if(isset($_SESSION['user_id'])) { ?>
                <a href="book.php?id=<?php echo $row['id']; ?>" class="btn">Book Now</a>
            <?php } else { ?>
                <a href="login.php" class="btn">Login to Book</a>
            <?php } ?>

        </div>

    <?php
        }
    } else {
        echo "<p>No events available.</p>";
    }
    ?>
</div>

</body>
</html>