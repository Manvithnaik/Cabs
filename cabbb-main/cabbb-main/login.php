<?php
// Include the database connection file
include('db.php');

// Start session to store session variables
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if email and password are provided
    if (isset($_POST['user_email'], $_POST['user_password'])) {
        // Sanitize input values to prevent SQL injection
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        // Query to check if the user exists
        $query = "SELECT * FROM users WHERE user_email = ?";
        if ($stmt = $conn->prepare($query)) {
            // Bind the parameters
            $stmt->bind_param("s", $user_email);

            // Execute the query
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if user exists
            if ($result->num_rows > 0) {
                // Fetch user data
                $user = $result->fetch_assoc();
                
                // Verify the password
                if (password_verify($user_password, $user['user_password'])) {
                    // Store user data in session variables
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_name'] = $user['user_name'];
                    $_SESSION['user_email'] = $user['user_email'];

                    // Optionally: Store a flag to indicate that the user is logged in
                    $_SESSION['logged_in'] = true;

                    // Redirect to the homepage after successful login
                    header("Location: index.html");
                    exit(); // Stop further execution
                } else {
                    // Invalid password
                    echo "Invalid email or password!";
                }
            } else {
                // No user found with the entered email
                echo "No user found with this email!";
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            echo "Error in query preparation: " . $conn->error;
        }
    } else {
        echo "Please fill in all fields!";
    }

    // Close the database connection
    $conn->close();
}
?>
