<?php
include '../includes/database.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.php");
    exit();
}

// Fetch confirmed appointments for the logged-in user
try {
    $sql = "SELECT a.appointment_id, a.date, a.time, c.name AS clinic_name, c.address AS clinic_address 
            FROM appointment a
            JOIN clinics c ON a.clinic_id = c.clinic_id
            WHERE a.user_id = :user_id AND a.status = 'confirmed'
            ORDER BY a.date, a.time";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching appointments: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/Uappointments.css">
    <title>My Appointments</title>
</head>
<body>
    <?php require_once '../includes/header.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">My Confirmed Appointments</h1>
        <?php if (!empty($appointments)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Clinic Name</th>
                            <th>Clinic Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $index => $appointment): ?>
                            <tr>
                                <td><?= htmlspecialchars($index + 1) ?></td>
                                <td><?= htmlspecialchars($appointment['date']) ?></td>
                                <td><?= htmlspecialchars($appointment['time']) ?></td>
                                <td><?= htmlspecialchars($appointment['clinic_name']) ?></td>
                                <td><?= htmlspecialchars($appointment['clinic_address']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">You have no confirmed appointments at the moment.</p>
        <?php endif; ?>
    </div>

    <?php require_once '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
