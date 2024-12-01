<?php
// Include the database connection file
include('db.php');

// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // If not logged in, redirect to login page
    header("Location: login.html");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all necessary POST variables are set
    if (isset($_POST['pickup_location'], $_POST['dropoff_location'], $_POST['ride_time'], $_POST['car_type'])) {
        // Sanitize input values to prevent SQL injection
        $pickup_location = $_POST['pickup_location'];
        $dropoff_location = $_POST['dropoff_location'];
        $ride_time = $_POST['ride_time']; // Expecting the format 'YYYY-MM-DD HH:MM:SS'
        $car_type = $_POST['car_type'];

        // Get the user ID from the session
        $user_id = $_SESSION['user_id'];

        // Prepare SQL query to insert the booking data
        $query = "INSERT INTO bookings (user_id, pickup_location, dropoff_location, ride_time, car_type) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($query)) {
            // Bind the parameters
            $stmt->bind_param("issss", $user_id, $pickup_location, $dropoff_location, $ride_time, $car_type);

            // Execute the query and check if the insertion was successful
            if ($stmt->execute()) {
                echo "Booking successful!";
                // Optionally, redirect to another page or show a confirmation message
                // header("Location: confirmation_page.php"); // Uncomment to redirect
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            echo "Error in query preparation: " . $conn->error;
        }
    } else {
        echo "All fields are required!";
    }
}

// Close the database connection
$conn->close();
?>
