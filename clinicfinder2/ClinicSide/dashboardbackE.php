<?php
// Include the database connection
require_once '..\includes\database.php';

session_start();
$clinic_id = $_SESSION['clinic_id']; // Replace with actual clinic ID from session or input.

// Appointments Today
$query_today = $pdo->prepare("
    SELECT COUNT(*) AS appointments_today
    FROM appointment
    WHERE date = CURDATE()
      AND schedule_id IN (
          SELECT schedule_id
          FROM available_schedule
          WHERE clinic_id = :clinic_id
      )
");
$query_today->execute(['clinic_id' => $clinic_id]);
$appointments_today = $query_today->fetch(PDO::FETCH_ASSOC)['appointments_today'];

// Appointments This Month
$query_month = $pdo->prepare("
    SELECT COUNT(*) AS appointments_this_month
    FROM appointment
    WHERE MONTH(date) = MONTH(CURDATE())
      AND YEAR(date) = YEAR(CURDATE())
      AND schedule_id IN (
          SELECT schedule_id
          FROM available_schedule
          WHERE clinic_id = :clinic_id
      )
");
$query_month->execute(['clinic_id' => $clinic_id]);
$appointments_this_month = $query_month->fetch(PDO::FETCH_ASSOC)['appointments_this_month'];

// Completed Appointments
$query_completed = $pdo->prepare("
    SELECT COUNT(*) AS completed_appointments
    FROM appointment
    WHERE status = 'confirmed'
      AND schedule_id IN (
          SELECT schedule_id
          FROM available_schedule
          WHERE clinic_id = :clinic_id
      )
");
$query_completed->execute(['clinic_id' => $clinic_id]);
$completed_appointments = $query_completed->fetch(PDO::FETCH_ASSOC)['completed_appointments'];

// Pending Appointments
$query_pending = $pdo->prepare("
    SELECT COUNT(*) AS pending_appointments
    FROM appointment
    WHERE status = 'pending'
      AND schedule_id IN (
          SELECT schedule_id
          FROM available_schedule
          WHERE clinic_id = :clinic_id
      )
");
$query_pending->execute(['clinic_id' => $clinic_id]);
$pending_appointments = $query_pending->fetch(PDO::FETCH_ASSOC)['pending_appointments'];
?>
