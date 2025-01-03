<?php
// Include the database connection
include '../includes/database.php';

session_start();

// Check if the clinic_id is set in the session
if (!isset($_SESSION['clinic_id'])) {
    // Redirect to login or handle the error if the clinic_id is not found
    header("Location: ../Login/login.php");
    exit();
}

$clinic_id = $_SESSION['clinic_id']; // Use the session clinic_id

// Fetch Clinic Information
$query = $pdo->prepare("SELECT name, address, latitude, longitude, image, contac_info, services, availability, status FROM clinics WHERE clinic_id = :clinic_id");
$query->execute(['clinic_id' => $clinic_id]);
$clinic = $query->fetch(PDO::FETCH_ASSOC);

if (!$clinic) {
    // If the clinic is not found in the database, show an error message
    die("Clinic not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\assets\css\clinicprofile.css">
    <title>Clinic Profile</title>
   
</head>
<body>
    <div class="navbar">
        <h1>ClinicFinder</h1>
        <div>
            <a href="dashboard.php">Home</a>
            <a href="#">Contact</a>
            <a href="#">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="side-panel">
            <h2>Clinic Management</h2>
            <a href="clinicprofile.php">Update Profile</a>
            <a href="#update-availability">Update Availability</a>
            <a href="#">Appointments</a>
            <a href="#">Logout</a>
        </div>

        <div class="profile-container">
            <div class="profile-header">
                <?php if ($clinic['image']): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($clinic['image']) ?>" alt="Clinic Image">
                <?php else: ?>
                    <img src="default-clinic.png" alt="Default Clinic Image">
                <?php endif; ?>
                <h2><?= htmlspecialchars($clinic['name']) ?></h2>
                <p>Status: <?= htmlspecialchars(ucfirst($clinic['status'])) ?></p>
            </div>

            <div class="profile-details">
                <h3>Details</h3>
                <p><strong>Address:</strong> <?= htmlspecialchars($clinic['address']) ?></p>
                <p><strong>Contact Info:</strong> <?= htmlspecialchars($clinic['contac_info']) ?></p>
                <p><strong>Latitude:</strong> <?= htmlspecialchars($clinic['latitude']) ?></p>
                <p><strong>Longitude:</strong> <?= htmlspecialchars($clinic['longitude']) ?></p>
                <p><strong>Services:</strong> <?= nl2br(htmlspecialchars($clinic['services'])) ?></p>
                <p><strong>Availability:</strong> <?= htmlspecialchars($clinic['availability']) ?></p>
            </div>

            <a href="#update-profile" class="btn">Update Profile</a>
            <a href="#update-availability" class="btn">Update Availability</a>

            <!-- Update Profile Form -->
            <div id="update-profile" class="form-container">
                <form action="update_profile.php" method="post" enctype="multipart/form-data">
                    <h3>Update Profile</h3>
                    <input type="text" name="name" value="<?= htmlspecialchars($clinic['name']) ?>" required>
                    <input type="text" name="address" value="<?= htmlspecialchars($clinic['address']) ?>" required>
                    <input type="text" name="contac_info" value="<?= htmlspecialchars($clinic['contac_info']) ?>" required>
                    <textarea name="services" rows="4"><?= htmlspecialchars($clinic['services']) ?></textarea>
                    <input type="file" name="image">
                    <button type="submit">Save Changes</button>
                </form>
            </div>

            <!-- Update Availability Form -->
            <div id="update-availability" class="form-container">
                <form action="update_availability.php" method="post">
                    <h3>Update Availability</h3>
                    <select name="availability" required>
                        <option value="Available" <?= $clinic['availability'] === 'Available' ? 'selected' : '' ?>>Available</option>
                        <option value="Unavailable" <?= $clinic['availability'] === 'Unavailable' ? 'selected' : '' ?>>Unavailable</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 ClinicFinder. All rights reserved.</p>
    </div>
</body>
</html>
