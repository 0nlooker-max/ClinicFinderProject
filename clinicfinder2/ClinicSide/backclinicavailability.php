<?php
// Include the database connection
include '..\includes\database.php';
session_start();

// Check if the clinic_id is set in the session
if (!isset($_SESSION['clinic_id'])) {
    // Redirect to login or handle the error if the clinic_id is not found
    header("Location:..\Login\login.php");
}

$clinic_id = $_SESSION['clinic_id'];  // Use the session clinic_id

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the availability status from the form
    $availability = htmlspecialchars($_POST['availability']);

    // Prepare the update query
    $query = $pdo->prepare("
        UPDATE clinics
        SET availability = :availability
        WHERE clinic_id = :clinic_id
    ");

    // Execute the query with the parameters
    $query->execute([
        'availability' => $availability,
        'clinic_id' => $clinic_id
    ]);

    // Redirect back to the profile page after update
    header("Location: ..\ClinicSide\clinicprofile.php");
    exit();
}
?>
