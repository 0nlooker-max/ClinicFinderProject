<?php
// Include the database connection
include '../includes/database.php';

// Check if clinic ID is provided
if (isset($_GET['id'])) {
    $clinic_id = intval($_GET['id']);

    // Delete clinic from the database
    $query = "DELETE FROM clinics WHERE clinic_id = :clinic_id";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute(['clinic_id' => $clinic_id])) {
        echo "Clinic deleted successfully!";
        header("Location: view_clinics.php"); // Redirect to clinic list page
        exit();
    } else {
        echo "Error deleting clinic.";
    }
} else {
    die("Invalid clinic ID.");
}
?>
