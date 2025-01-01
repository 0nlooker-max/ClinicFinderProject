<?php
// Example clinic data (replace with database fetch)
$clinics = [
    ["name" => "Clinic A", "latitude" => 11.045, "longitude" => 124.004],
    ["name" => "Clinic B", "latitude" => 11.048, "longitude" => 124.006],
    ["name" => "Clinic C", "latitude" => 11.042, "longitude" => 124.008],
];

// Convert PHP array to JSON
$clinicsJSON = json_encode($clinics);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Page</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.css" />

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1100;
        }

        .navbar .nav-links {
            display: flex;
            gap: 20px;
        }

        .navbar .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .navbar .nav-links a:hover {
            text-decoration: underline;
        }

        /* Hamburger Menu for Sidebar */
        .menu-toggle {
            background-color: #333;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
        }

        .map-page {
            display: flex;
            height: 100vh;
            margin-top: 50px; /* To account for the navbar */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 300px;
            height: 100%;
            background-color: #fff;
            position: fixed;
            left: -300px; /* Hidden by default */
            transition: left 0.3s ease-in-out;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            padding: 20px;
        }

        .sidebar h2, .sidebar input, .sidebar ul {
            margin: 10px 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 15px;
        }

        .sidebar.active {
            left: 0; /* Sidebar slides in */
        }

        /* Map Container */
        .map-container {
            flex: 1;
            height: 100%;
            position: relative;
        }

        #map {
            height: 100%;
            width: 100%;
            z-index: 1;
        }
    </style>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.min.js"></script>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="menu-toggle" id="menuToggle">☰</div>
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
            <a href="#">Clinics</a>
        </div>
    </div>

    <div class="map-page">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <h2>Search Clinics</h2>
            <input type="text" placeholder="Search by name or location..." class="search-bar">
            <ul class="clinic-list">
                <li>
                    <h3>Clinic A</h3>
                    <p>Address: Sample Street, Cebu</p>
                    <button>View Details</button>
                </li>
                <li>
                    <h3>Clinic B</h3>
                    <p>Address: Another Street, Cebu</p>
                    <button>View Details</button>
                </li>
                <li>
                    <h3>Clinic C</h3>
                    <p>Address: Example Avenue, Cebu</p>
                    <button>View Details</button>
                </li>
            </ul>
        </div>

        <!-- Map Section -->
        <div class="map-container">
            <div id="map"></div>
        </div>
    </div>

    <!-- Pass clinics data to JavaScript -->
    <script>
        var clinics = <?php echo $clinicsJSON; ?>;

        // Sidebar Toggle Functionality
        const menuToggle = document.getElementById("menuToggle");
        const sidebar = document.getElementById("sidebar");
        menuToggle.addEventListener("click", function() {
            sidebar.classList.toggle("active");
        });

        // Initialize the map
        var map = L.map('map').setView([11.044526, 124.004376], 13); // Centered to Bogo City

        // Add Thunderforest tile layer
        L.tileLayer('https://{s}.tile.thunderforest.com/outdoors/{z}/{x}/{y}.png?apikey=a353d2f765d444f1bff3dd18b4b834bf', {
            maxZoom: 19,
            attribution: '© Thunderforest & contributors'
        }).addTo(map);

        // Store the routing control globally
        var routingControl = null;

        // Geolocation and Display Clinics
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    var userLat = position.coords.latitude;
                    var userLon = position.coords.longitude;

                    // Center the map on the user's location
                    map.setView([userLat, userLon], 15);

                    // Add a marker for the user's location
                    var userMarker = L.marker([userLat, userLon]).addTo(map)
                        .bindPopup('You are here!').openPopup();

                    // Add markers for clinics
                    clinics.forEach(function (clinic) {
                        var clinicLat = clinic.latitude;
                        var clinicLon = clinic.longitude;

                        // Create a marker for each clinic
                        var clinicMarker = L.marker([clinicLat, clinicLon]).addTo(map)
                            .bindPopup('<b>' + clinic.name + '</b><br>Lat: ' + clinicLat + ', Lon: ' + clinicLon);

                        // Add click event to the clinic marker
                        clinicMarker.on('click', function () {
                            if (routingControl) {
                                map.removeControl(routingControl); // Remove the old route
                            }
                            routingControl = L.Routing.control({
                                waypoints: [
                                    L.latLng(userLat, userLon), // User's location
                                    L.latLng(clinicLat, clinicLon) // Clicked clinic
                                ],
                                routeWhileDragging: false,
                                addWaypoints: false,
                                lineOptions: {
                                    styles: [{ color: 'blue', weight: 4 }]
                                }
                            }).addTo(map);
                        });
                    });
                },
                function (error) {
                    console.error("Error getting location:", error.message);
                }
            );
        } else {
            alert("Geolocation not supported by your browser.");
        }
    </script>
</body>
</html>
