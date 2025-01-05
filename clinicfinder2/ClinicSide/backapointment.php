<?php
require_once "../includes/database.php";
session_start();

if (!isset($_SESSION['clinic_id'])) {
    header("Location: ../Login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $action = $_POST['action'];

    try {
        if ($action === 'accept') {
            // Update status to 'confirmed' for accepted appointments
            $stmt = $pdo->prepare("UPDATE appointment SET status = 'confirmed' WHERE appointment_id = :appointment_id AND clinic_id = :clinic_id");
        } elseif ($action === 'decline') {
            // Update status to 'cancelled' for declined appointments
            $stmt = $pdo->prepare("UPDATE appointment SET status = 'cancelled' WHERE appointment_id = :appointment_id AND clinic_id = :clinic_id");
        }

        $stmt->execute([
            'appointment_id' => $appointment_id,
            'clinic_id' => $_SESSION['clinic_id']
        ]);

        // Redirect back to the appointments page
        header("Location: apointment.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: apointment.php");
    exit();
}