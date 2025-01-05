<?php
include '../includes/database.php'; // Include database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $contact_info = $_POST['contact_info'];
    $services = $_POST['services'];
    $availability = $_POST['availability'];
    $status = $_POST['status'];

    // Handle image upload
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $image = null;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO clinics (name, address, latitude, longitude, contact_info, services, availability, status, image) 
                               VALUES (:name, :address, :latitude, :longitude, :contact_info, :services, :availability, :status, :image)");
        $stmt->execute([
            ':name' => $name,
            ':address' => $address,
            ':latitude' => $latitude,
            ':longitude' => $longitude,
            ':contact_info' => $contact_info,
            ':services' => $services,
            ':availability' => $availability,
            ':status' => $status,
            ':image' => $image
        ]);
        $successMessage = "Clinic added successfully!";
    } catch (PDOException $e) {
        $errorMessage = "Error adding clinic: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Clinic</title>
    <link rel="stylesheet" href="..\assets\css\admin_add_view.css">
</head>
<body>
    <div class="container">
        <h1>Add Clinic</h1>
        <?php if (isset($successMessage)) { echo "<p class='success'>$successMessage</p>"; } ?>
        <?php if (isset($errorMessage)) { echo "<p class='error'>$errorMessage</p>"; } ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Clinic Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="latitude">Latitude:</label>
            <input type="text" id="latitude" name="latitude" required>

            <label for="longitude">Longitude:</label>
            <input type="text" id="longitude" name="longitude" required>

            <label for="contact_info">Contact Info:</label>
            <input type="text" id="contact_info" name="contact_info" required>

            <label for="services">Services:</label>
            <textarea id="services" name="services" required></textarea>

            <label for="availability">Availability:</label>
            <input type="text" id="availability" name="availability" required>

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <label for="image">Clinic Image:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit">Add Clinic</button>
        </form>
    </div>
</body>
</html>
