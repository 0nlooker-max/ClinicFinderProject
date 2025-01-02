<?php
// Include the database connection
include '..\includes\database.php';

session_start();

// Check if the clinic_id is set in the session
if (!isset($_SESSION['clinic_id'])) {
    // Redirect to login or handle the error if the clinic_id is not found
    die("Clinic ID not found. Please log in.");
}

$clinic_id = $_SESSION['clinic_id']; // Use the session clinic_id

// Fetch Clinic Information
$query = $pdo->prepare("
    SELECT name, address, latitude, longitude, image, contac_info, services, availability, status
    FROM clinics
    WHERE clinic_id = :clinic_id
");
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
    <title>Clinic Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .profile-container {
            width: 80%;
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-header img {
            max-width: 150px;
            border-radius: 50%;
        }
        .profile-header h2 {
            margin: 10px 0;
            font-size: 24px;
        }
        .profile-header p {
            color: #555;
        }
        .profile-details {
            margin-top: 20px;
        }
        .profile-details h3 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #333;
        }
        .profile-details p {
            margin: 5px 0;
            color: #555;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .form-container {
            margin-top: 20px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .form-container input, .form-container textarea, .form-container select {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .form-container button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
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
</body>
</html>
