<?php
require_once '../includes/database.php'; // Database connection

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    try {
        // SQL query to search by name, address, or services
        $sql = "SELECT clinic_id, name, address, latitude, longitude, services, image, availability, status 
                FROM clinics 
                WHERE 
                    status = 'active' AND 
                    (name LIKE :searchTerm OR address LIKE :searchTerm OR services LIKE :searchTerm)";
        
        $stmt = $pdo->prepare($sql);
        $searchTerm = "%$query%";
        $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();

        $clinics = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the results as JSON
        echo json_encode($clinics);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Failed to fetch clinics: " . $e->getMessage()]);
    }
}
