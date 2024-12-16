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
    <link rel="stylesheet" href="mapPage.css">

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.min.js"></script>
</head>
<body>
    <div class="map-page">
        <!-- Sidebar -->
        <div class="sidebar">
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
            <h2>Map View</h2>
            <div id="map"></div>
        </div>
    </div>

    <!-- Pass clinics data to JavaScript -->
    <script>
        var clinics = <?php echo $clinicsJSON; ?>;
    </script>

    <!-- Map Script -->
    <script>
        // Initialize the map
        var map = L.map('map').setView([11.044526, 124.004376], 13); // Default to Bogo City

        // Add Thunderforest tile layer
        L.tileLayer('https://{s}.tile.thunderforest.com/outdoors/{z}/{x}/{y}.png?apikey=a353d2f765d444f1bff3dd18b4b834bf', {
            maxZoom: 19,
            attribution: '© Thunderforest & contributors'
        }).addTo(map);

        // Function to calculate distance (Haversine formula)
        function getDistance(lat1, lon1, lat2, lon2) {
            var R = 6371; // Earth's radius in km
            var dLat = (lat2 - lat1) * Math.PI / 180;
            var dLon = (lon2 - lon1) * Math.PI / 180;
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c; // Distance in km
        }

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

                    // Find the nearest clinic
                    var nearestClinic = null;
                    var minDistance = Infinity;

                    clinics.forEach(function(clinic) {
                        var clinicLat = clinic.latitude;
                        var clinicLon = clinic.longitude;
                        var distance = getDistance(userLat, userLon, clinicLat, clinicLon);

                        // Find the nearest clinic
                        if (distance < minDistance) {
                            minDistance = distance;
                            nearestClinic = clinic;
                        }

                        // Add a marker for each clinic
                        L.marker([clinic.latitude, clinic.longitude]).addTo(map)
                            .bindPopup('<b>' + clinic.name + '</b><br>Lat: ' + clinic.latitude + ', Lon: ' + clinic.longitude);
                    });

                    // Add routing control to the map for the nearest clinic
                    if (nearestClinic) {
                        L.Routing.control({
                            waypoints: [
                                L.latLng(userLat, userLon), // User's location
                                L.latLng(nearestClinic.latitude, nearestClinic.longitude) // Nearest clinic's location
                            ],
                            routeWhileDragging: true,
                            lineOptions: {
                                styles: [{ color: 'blue', weight: 4 }]
                            }
                        }).addTo(map);
                    }
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
