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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input fields
    $name = htmlspecialchars(trim($_POST['name']));
    $address = htmlspecialchars(trim($_POST['address']));
    $contac_info = htmlspecialchars(trim($_POST['contac_info']));
    $services = htmlspecialchars(trim($_POST['services']));

    // Prepare query for updating the profile
    $query = "UPDATE clinics SET name = :name, address = :address, contac_info = :contac_info, services = :services";

    // Check if an image is uploaded
    if (!empty($_FILES['image']['tmp_name'])) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $query .= ", image = :image"; // Add the image field to the update query
    }

    $query .= " WHERE clinic_id = :clinic_id";

    // Execute the query
    try {
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':contac_info', $contac_info);
        $stmt->bindParam(':services', $services);
        $stmt->bindParam(':clinic_id', $clinic_id);

        // Bind image parameter if an image is uploaded
        if (!empty($_FILES['image']['tmp_name'])) {
            $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
        }

        $stmt->execute();

        // Redirect back to the profile page with a success message
        $_SESSION['success'] = "Profile updated successfully.";
        header("Location: clinicprofile.php");
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        $_SESSION['error'] = "Failed to update profile: " . $e->getMessage();
        header("Location: clinicprofile.php");
        exit();
    }
} else {
    // Redirect to the profile page if the form was not submitted
    header("Location: clinicprofile.php");
    exit();
}
?>
