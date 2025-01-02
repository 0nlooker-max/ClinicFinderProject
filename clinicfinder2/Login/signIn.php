<?php
include '../includes/database.php'; // Include the database connection file
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        // Query to fetch user details based on email
        $query = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $query->execute(['email' => $email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            switch ($user['role']) {
                case 'admin':
                    header('Location: ../AdminSide/admin_dashboard.php');
                    break;
                case 'clinic':
                    header('Location: ../ClinicSide/clinicaccsearch.php');
                    break;
                case 'patient':
                    header('Location: ../ResidentSide/index.php');
                    break;
                case 'guest':
                    header('Location: ../ResidentSide/index.php');
                    break;
                default:
                    header('Location: ../index.php'); // Default redirect for unrecognized roles
            }
            exit;
        } else {
            $error_message = "Invalid email or password.";
        }
    } catch (Exception $e) {
        $error_message = "An error occurred. Please try again later.";
        error_log("SignIn Error: " . $e->getMessage()); // Log error
    }
}
?>
