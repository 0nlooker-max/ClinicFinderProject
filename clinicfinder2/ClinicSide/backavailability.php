<?php
require_once "../includes/database.php";
session_start();

if (!isset($_SESSION['clinic_id'])) {
    // Redirect to login or handle the error if the clinic_id is not found
    header("Location: ../Login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $day = filter_input(INPUT_POST, 'day', FILTER_SANITIZE_STRING);
    $slots = filter_input(INPUT_POST, 'slots', FILTER_VALIDATE_INT);

    if (!$day || !$slots || $slots <= 0) {
        die("Invalid input. Please try again.");
    }

    // Map days to actual dates for the current week
    $daysOfWeek = [
        "Monday" => 1,
        "Tuesday" => 2,
        "Wednesday" => 3,
        "Thursday" => 4,
        "Friday" => 5,
        "Saturday" => 6,
    ];
    
    if (!isset($daysOfWeek[$day])) {
        die("Invalid day selection.");
    }

    $clinicId = $_SESSION['clinic_id'];
    $currentWeek = date("W");
    $year = date("Y");

    // Get the date for the selected day of the current week
    $dayOfWeek = $daysOfWeek[$day];
    $date = date("Y-m-d", strtotime("{$year}W{$currentWeek}{$dayOfWeek}"));

    // Time slots generation logic
    $slotDuration = 30; // 30 minutes per slot (adjust as needed)
    $startTime = "09:00:00"; // Start time for scheduling
    $endTime = "17:00:00"; // End time for scheduling

    $startTimestamp = strtotime($startTime);
    $endTimestamp = strtotime($endTime);
    $availableSlots = [];

    // Generate time slots
    for ($i = 0; $i < $slots; $i++) {
        $slotStartTime = date("H:i:s", $startTimestamp + ($i * $slotDuration * 60));
        $slotEndTime = date("H:i:s", $startTimestamp + (($i + 1) * $slotDuration * 60));

        if (strtotime($slotEndTime) > $endTimestamp) {
            break; // Avoid exceeding the defined end time
        }

        $availableSlots[] = [
            'start_time' => $slotStartTime,
            'end_time' => $slotEndTime,
        ];
    }

    // Insert slots into the database
    try {
        $pdo->beginTransaction();

        foreach ($availableSlots as $slot) {
            $stmt = $pdo->prepare("INSERT INTO available_schedule (date, start_time, end_time, slot_status, clinic_id) 
                                   VALUES (:date, :start_time, :end_time, 'available', :clinic_id)");
            $stmt->execute([
                ':date' => $date,
                ':start_time' => $slot['start_time'],
                ':end_time' => $slot['end_time'],
                ':clinic_id' => $clinicId,
            ]);
        }

        $pdo->commit();
        echo "Schedule created successfully!";
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
} else {
    die("Invalid request method.");
}
?>
