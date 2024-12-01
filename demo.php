<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html'); // Redirect to login page if not logged in
    exit();
}

include('db.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pickup_location = $_POST['pickup_location'];
    $destination = $_POST['destination'];
    $pickup_datetime = $_POST['pickup_datetime'];
    $cab_type = $_POST['cab_type'];
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID

    // Insert booking into the database
    $sql = "INSERT INTO bookings (user_id, pickup_location, destination, pickup_datetime, cab_type) 
            VALUES ('$user_id', '$pickup_location', '$destination', '$pickup_datetime', '$cab_type')";

    if ($conn->query($sql) === TRUE) {
        echo "Booking confirmed!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
