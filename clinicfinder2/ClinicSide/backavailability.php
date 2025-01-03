<?php
session_start();
include '../includes/database.php'; // Include your database connection file

// Check if the user is logged in and is a clinic
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'clinic') {
    header('Location: ../login.php');
    exit;
}

$clinic_id = $_SESSION['user_id']; // Get clinic_id from the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $day = $_POST['day'];
    $time_slot = $_POST['time_slot'];
    $slots_available = intval($_POST['slots_available']);

    // Validate inputs
    if (empty($day) || empty($time_slot) || $slots_available < 20 || $slots_available > 50) {
        echo "Invalid input. Please check your entries.";
        exit;
    }

    try {
        // Insert availability into the database
        $query = $pdo->prepare("
            INSERT INTO availability (clinic_id, day_of_week, time_slot, slots_available) 
            VALUES (:clinic_id, :day_of_week, :time_slot, :slots_available)
        ");
        $query->execute([
            'clinic_id' => $clinic_id,
            'day_of_week' => $day,
            'time_slot' => $time_slot,
            'slots_available' => $slots_available,
        ]);

        // Redirect to manage availability page or success page
        header('Location: manage_availability.php');
        exit;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        echo "An error occurred while saving the availability. Please try again later.";
    }
} else {
    header('Location: ../index.php'); // Redirect if accessed without POST
    exit;
}
?>
