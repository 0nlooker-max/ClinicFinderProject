<?php 
$specific_css = 'homepage.css'; // Ensure this points to the saved CSS file
require_once '../includes/header.php'; 
?>

<section class="search-section">
    <div class="search-container">
        <h1>Find Nearby Clinics</h1>
        <input type="text" id="search-bar" placeholder="Search by name, location, or service" />
        <button class="button">Search</button>
    </div>
    <div class="map_btn">
        <a href="../index.php?page=resident/searchClinics" class="clncbtn">Go to Map</a>
    </div>
</section>

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
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>
