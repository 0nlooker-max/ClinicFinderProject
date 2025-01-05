<?php
// Include the database connection
include '../includes/database.php';

// Check if clinic ID is provided
if (isset($_GET['id'])) {
    $clinic_id = intval($_GET['id']);

    // Fetch existing clinic data
    $query = "SELECT * FROM clinics WHERE clinic_id = :clinic_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['clinic_id' => $clinic_id]);

    $clinic = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$clinic) {
        die("Clinic not found.");
    }
}

// Handle form submission for editing clinic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $contact_info = $_POST['contact_info'];
    $services = $_POST['services'];
    $availability = $_POST['availability'];
    $status = $_POST['status'];

    // Update clinic details in the database
    $query = "UPDATE clinics 
              SET name = :name, address = :address, latitude = :latitude, longitude = :longitude, 
                  contac_info = :contact_info, services = :services, availability = :availability, 
                  status = :status 
              WHERE clinic_id = :clinic_id";
    $stmt = $pdo->prepare($query);
    $success = $stmt->execute([
        'name' => $name,
        'address' => $address,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'contact_info' => $contact_info,
        'services' => $services,
        'availability' => $availability,
        'status' => $status,
        'clinic_id' => $clinic_id
    ]);

    if ($success) {
        echo "Clinic details updated successfully!";
        header("Location: view_clinics.php"); // Redirect to clinic list page
        exit();
    } else {
        echo "Error updating clinic details.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Edit Clinic</title>
    <link rel="stylesheet" href="..\assets\css\edit_clinic.css">
</head>
<body>
    <h1>Edit Clinic</h1>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($clinic['name']); ?>" required><br>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($clinic['address']); ?>" required><br>

        <label>Latitude:</label>
        <input type="text" name="latitude" value="<?php echo htmlspecialchars($clinic['latitude']); ?>" required><br>

        <label>Longitude:</label>
        <input type="text" name="longitude" value="<?php echo htmlspecialchars($clinic['longitude']); ?>" required><br>

        <label>Contact Info:</label>
        <input type="text" name="contact_info" value="<?php echo htmlspecialchars($clinic['contac_info']); ?>" required><br>

        <label>Services:</label>
        <textarea name="services" required><?php echo htmlspecialchars($clinic['services']); ?></textarea><br>

        <label>Availability:</label>
        <input type="text" name="availability" value="<?php echo htmlspecialchars($clinic['availability']); ?>" required><br>

        <label>Status:</label>
        <select name="status" required>
            <option value="active" <?php echo $clinic['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?php echo $clinic['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
        </select><br>

        <button type="submit">Update Clinic</button>
    </form>
</body>
</html>
