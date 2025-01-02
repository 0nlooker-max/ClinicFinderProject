<?php
require_once '../includes/database.php'; // Ensure database connection

// Check if 'id' is present
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Clinic ID is not provided.");
}

$clinicId = intval($_GET['id']); // Sanitize the ID

try {
    // Fetch the image from the database
    $stmt = $pdo->prepare("SELECT image FROM clinics WHERE clinic_id = :id AND status = 'active'");
    $stmt->bindParam(':id', $clinicId, PDO::PARAM_INT);
    $stmt->execute();
    $clinic = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($clinic && $clinic['image']) {
        // Set the appropriate content type header
        header("Content-Type: image/jpeg");
        echo $clinic['image'];
        exit;
    } else {
        die("Error: Image not found or clinic is inactive.");
    }
} catch (PDOException $e) {
    die("Error fetching clinic image: " . $e->getMessage());
}
?>
