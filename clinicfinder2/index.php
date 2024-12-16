<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClinicFinder</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Navigation Bar -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <h2>ClinicFinder</h2>
            </div>
            <ul class="nav-links">
                <li><a href="home.html">Home</a></li>
                <li><a href="map.php">Map Page</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Search Section -->
    <section class="search-section">
        <div class="search-container">
            <h1>Find Nearby Clinics</h1>
            <input type="text" id="search-bar" placeholder="Search by name, location, or service" />
            <button class="button">Search</button>
        </div>
        <div class="map_btn">
            <a href="map.php" class="clncbtn">Go to Map</a>
        </div>
    </section>

    <!-- Clinic List Section -->
     <div class="second">
        <h2>Available Clinics</h2>
        <section class="clinic-list">
            
            <div class="clinic-card">
                <h3>HealthCare Clinic</h3>
                <p>Location: Cebu City</p>
                <p>Services: General Check-up, Vaccinations</p>
                <button>View Details</button>
            </div>
            <div class="clinic-card">
                <h3>City Health Clinic</h3>
                <p>Location: Mandaue</p>
                <p>Services: Dental Care, Pediatrics</p>
                <button>View Details</button>
            </div>
            <!-- Add more clinic cards as needed -->
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 ClinicFinder. All rights reserved.</p>
    </footer>

</body>
</html>
