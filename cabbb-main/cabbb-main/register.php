<?php
// Include the database connection file
include('db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the form fields are set
    if (isset($_POST['user_name'], $_POST['user_email'], $_POST['user_password'])) {
        // Sanitize input values to avoid SQL injection
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT); // Hash the password

        // Check if the email already exists
        $query = "SELECT * FROM users WHERE user_email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Email is already registered!";
        } else {
            // Insert the new user into the database
            $insert_query = "INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("sss", $user_name, $user_email, $user_password);

            if ($insert_stmt->execute()) {
                echo "Registration successful!";
                // Redirect to login.html after successful registration
                header("Location: login.html"); // Redirect to login page after successful registration
                exit();
            } else {
                echo "Error: " . $insert_stmt->error;
            }
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }
    
    $conn->close();
}
?>
