<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "clinicfinder");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get clinic ID from URL
$clinicId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch clinic details
$sql = "SELECT * FROM clinics WHERE id = $clinicId";
$result = $conn->query($sql);

$clinic = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $clinic['name']; ?> | ClinicFinder</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <h2>ClinicFinder</h2>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="map.php">Map</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
    </header>

    <section class="clinic-details">
        <h1><?php echo $clinic['name']; ?></h1>
        <p><strong>Address:</strong> <?php echo $clinic['address']; ?></p>
        <p><strong>Services:</strong> <?php echo $clinic['services']; ?></p>
        <p><strong>Contact:</strong> <?php echo $clinic['contact']; ?></p>
        <button onclick="bookAppointment(<?php echo $clinicId; ?>)">Book Appointment</button>
    </section>

    <footer>
        <p>&copy; 2024 ClinicFinder. All rights reserved.</p>
    </footer>

    <script>
        function bookAppointment(clinicId) {
            window.location.href = `book_appointment.php?id=${clinicId}`;
        }
    </script>
</body>
</html>
