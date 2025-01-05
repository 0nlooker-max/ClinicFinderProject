<?php
session_start(); // Start the session
require_once '../includes/database.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    die("Error: You must be logged in to book an appointment.");
}

// Get user details from the session
$userId = intval($_SESSION['user_id']);
$userRole = $_SESSION['role'];

// Check if 'id' is provided in the query string
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Clinic ID is not provided.");
}

$clinicId = intval($_GET['id']); // Sanitize the clinic ID

try {
    // Fetch available schedules for the clinic
    $stmt = $pdo->prepare("
        SELECT schedule_id, date, start_time, end_time, slot_status 
        FROM available_schedule 
        WHERE clinic_id = :clinic_id AND slot_status = 'available'
    ");
    $stmt->bindParam(':clinic_id', $clinicId, PDO::PARAM_INT);
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching available schedules: " . $e->getMessage());
}

// Handle form submission for booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $scheduleId = intval($_POST['schedule_id']);
    $transactionStarted = false;

    try {
        // Verify if the user has the "patient" role
        if ($userRole !== 'patient') {
            die("Error: Only users with the 'patient' role can book appointments.");
        }

        // Start the transaction
        $pdo->beginTransaction();
        $transactionStarted = true;

        // Update slot status and associate it with the user
        $updateStmt = $pdo->prepare("
            UPDATE available_schedule 
            SET slot_status = 'booked', patient_id = :user_id 
            WHERE schedule_id = :schedule_id AND slot_status = 'available'
        ");
        $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $updateStmt->bindParam(':schedule_id', $scheduleId, PDO::PARAM_INT);
        $updateStmt->execute();

        if ($updateStmt->rowCount() > 0) {
            // Insert booking details into appointments
            $insertStmt = $pdo->prepare("
                INSERT INTO appointment (date, time, status, user_id, schedule_id, clinic_id) 
                SELECT date, start_time, 'pending', :user_id, :schedule_id, :clinic_id 
                FROM available_schedule WHERE schedule_id = :schedule_id
            ");
            $insertStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $insertStmt->bindParam(':schedule_id', $scheduleId, PDO::PARAM_INT);
            $insertStmt->bindParam(':clinic_id', $clinicId, PDO::PARAM_INT);
            $insertStmt->execute();

            $pdo->commit();
            echo "Appointment booked successfully!";
        } else {
            echo "Error: Slot is unavailable.";
            $pdo->rollBack(); // Roll back the transaction if the slot is unavailable
        }
    } catch (PDOException $e) {
        if ($transactionStarted) {
            $pdo->rollBack(); // Roll back the transaction only if it was started
        }
        die("Error booking appointment: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\assets\css\clinicapointment.css">
    <title>Book Appointment</title>
</head>
<body>
    <h1>Available Schedules</h1>
    <form method="POST" action="">
        <?php if (!empty($schedules)): ?>
            <ul>
                <?php foreach ($schedules as $schedule): ?>
                    <li>
                        <label>
                            <input type="radio" name="schedule_id" value="<?php echo $schedule['schedule_id']; ?>" required>
                            <?php echo htmlspecialchars($schedule['date'] . " - " . $schedule['start_time'] . " to " . $schedule['end_time']); ?>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button type="submit">Book Appointment</button>
        <?php else: ?>
            <p>No available schedules at the moment.</p>
        <?php endif; ?>
    </form>
</body>
</html>
