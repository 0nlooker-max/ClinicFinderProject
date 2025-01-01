<?php
session_start();
include 'db_connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check the user in the database
    $query = "SELECT * FROM users WHERE (username = ? OR email = ?) AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role']; // e.g., 'guest', 'resident', etc.

        // Redirect to homepage or dashboard based on the role
        if ($user['role'] === 'guest') {
            header("Location: homepage.php?role=guest");
        } else {
            header("Location: homepage.php");
        }
    } else {
        echo "<p>Invalid username or password. <a href='login.php'>Try again</a>.</p>";
    }
} else {
    echo "Invalid access method.";
}
?>
