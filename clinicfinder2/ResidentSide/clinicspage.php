<?php
require_once '../includes/database.php'; // Ensure the database connection file is included

// Check if 'id' is present in the query string
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Clinic ID is not provided.");
}

$clinicId = intval($_GET['id']); // Sanitize the ID

try {
    // Fetch clinic data
    $stmt = $pdo->prepare("SELECT name, address, contac_info, latitude, longitude, services FROM clinics WHERE clinic_id = :id AND status = 'active'");
    $stmt->bindParam(':id', $clinicId, PDO::PARAM_INT);
    $stmt->execute();

    $clinic = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$clinic) {
        die("Error: Clinic not found or is inactive.");
    }
} catch (PDOException $e) {
    die("Error fetching clinic information: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($clinic['name']); ?></title>
    <link rel="stylesheet" href="../assets/css/userclinics.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body>
    <div class="contain">
        <div class="header">
            <nav class="navbar">
                <div class="logo">
                    <h2>ClinicFinder</h2>
                </div>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="map.php">Map Page</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="..\Login\logout.php">LogOut</a></li>
                </ul>
            </nav>
        </div>

        <div class="clinic-details">
            <!-- Display the Clinic's Profile Picture -->
            <div class="clinic-image">
                <img src="clinic_image.php?id=<?php echo $clinicId; ?>" alt="Clinic Profile Picture">
            </div>
            <h1><?php echo htmlspecialchars($clinic['name']); ?></h1>
            <br>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($clinic['address']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($clinic['contac_info']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($clinic['services']); ?></p>
        </div>

        <!-- Book Appointment -->
        <div class="appointment-section">
            <h2>Book an Appointment</h2>
            <a href="backapointment.php?id=<?php echo $clinicId; ?>" class="appointment-button">Book Appointment</a>
        </div>
    </div>

    <!-- Map Section -->
    <div class="map-section">
        <h2>Clinic Location</h2>
        <div id="map"></div>
    </div>

    <script>
        // Initialize the map centered on the clinic's location
        var map = L.map('map').setView([<?php echo $clinic['latitude']; ?>, <?php echo $clinic['longitude']; ?>], 15);

        // Add tile layer to the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add a marker for the clinic
        L.marker([<?php echo $clinic['latitude']; ?>, <?php echo $clinic['longitude']; ?>])
            .addTo(map)
            .bindPopup('<b><?php echo htmlspecialchars($clinic['name']); ?></b><br><?php echo htmlspecialchars($clinic['address']); ?>')
            .openPopup();
    </script>
</body>
</html>
