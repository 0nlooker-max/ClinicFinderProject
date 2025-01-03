<?php
// Include the database connection
include '..\includes\database.php';
session_start();

// Check if the clinic_id is set in the session
if (!isset($_SESSION['clinic_id'])) {
    // Redirect to login or handle the error if the clinic_id is not found
    header("Location: ..\Login\login.php");
    exit();
}

$clinic_id = $_SESSION['clinic_id'];  // Use the session clinic_id

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $contac_info = htmlspecialchars($_POST['contac_info']);
    $services = htmlspecialchars($_POST['services']);
    
    // Image upload handling
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    }

    // Prepare the update query
    $query = $pdo->prepare("
        UPDATE clinics
        SET name = :name, address = :address, contac_info = :contac_info, services = :services, image = :image
        WHERE clinic_id = :clinic_id
    ");

    // Execute the query with the parameters
    $query->execute([
        'name' => $name,
        'address' => $address,
        'contac_info' => $contac_info,
        'services' => $services,
        'image' => $image,
        'clinic_id' => $clinic_id
    ]);

    // Redirect back to the profile page after update
    header("Location: ..\ClinicSide\clinicprofile.php");
    exit();
}
?>
