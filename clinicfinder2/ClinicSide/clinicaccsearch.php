<?php
// Include the database connection
include '..\includes\database.php';
session_start();

// Check if the user is logged in and has the role 'clinic'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'clinic') {
    // Redirect to login if not logged in or role is not clinic
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];  // Get user_id from session

// Check if the user exists in the clinics table
$query = $pdo->prepare("SELECT clinic_id FROM clinics WHERE user_id = :user_id");
$query->execute(['user_id' => $user_id]);
$clinic = $query->fetch(PDO::FETCH_ASSOC);

if ($clinic) {
    // Redirect to clinic profile if the clinic account exists
    $_SESSION['clinic_id'] = $clinic['clinic_id'];  // Store clinic_id in session
    header("Location: ..\ClinicSide\clinicprofile.php");
    exit();
} else {
    // Optionally, show an error or redirect to another page if no clinic found
    die("Clinic not found. Please contact support.");
}
?>
