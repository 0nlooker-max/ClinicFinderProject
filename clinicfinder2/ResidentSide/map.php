<?php
require_once '..\includes\database.php'; // Ensure the database connection file is included

try {
    // Fetch clinics data
    $stmt = $pdo->prepare("SELECT clinic_id, name, latitude, longitude FROM clinics WHERE status = 'active'");
    $stmt->execute();
    $clinics = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert PHP array to JSON
    $clinicsJSON = json_encode($clinics);
} catch (PDOException $e) {
    die("Error fetching clinics: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Page</title>
    <link rel="stylesheet" href="..\assets\css\map.css">
    <link rel="stylesheet" href="..\assets\css\header.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.awesome-markers/2.0.4/leaflet.awesome-markers.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.awesome-markers/2.0.4/leaflet.awesome-markers.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.min.js"></script>
</head>
<body>
    <?php
    require_once "..\includes\header.php";
    ?>
    <!-- Map Section -->
    <div class="map-container">
        <div id="map"></div>
    </div>

    <!-- Pass clinics data to JavaScript -->
    <script>
    // Fetch the clinics data from PHP
    var clinics = <?php echo $clinicsJSON; ?>;

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

                // Find the nearest clinic
                let nearestClinic = null;
                let shortestDistance = Infinity;

                clinics.forEach(function (clinic) {
                    var clinicLat = clinic.latitude;
                    var clinicLon = clinic.longitude;

                    // Calculate the distance using Haversine formula
                    var distance = Math.sqrt(
                        Math.pow(userLat - clinicLat, 2) +
                        Math.pow(userLon - clinicLon, 2)
                    );

                    if (distance < shortestDistance) {
                        shortestDistance = distance;
                        nearestClinic = clinic;
                    }

                    // Create a marker for each clinic
                    var clinicMarker = L.marker([clinicLat, clinicLon]).addTo(map)
                        .bindPopup(
                            '<b>' + clinic.name + '</b><br>' +
                            'Lat: ' + clinicLat + ', Lon: ' + clinicLon + '<br>' +
                            '<button onclick="visitClinic(' + clinic.clinic_id + ')">Visit Clinic</button>'
                        );

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

                // Automatically create a route to the nearest clinic
                if (nearestClinic) {
                    var nearestLat = nearestClinic.latitude;
                    var nearestLon = nearestClinic.longitude;

                    if (routingControl) {
                        map.removeControl(routingControl); // Remove any existing route
                    }

                    routingControl = L.Routing.control({
                        waypoints: [
                            L.latLng(userLat, userLon), // User's location
                            L.latLng(nearestLat, nearestLon) // Nearest clinic
                        ],
                        routeWhileDragging: false,
                        addWaypoints: false,
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

    // JavaScript function to redirect to clinicspage.php with the clinic ID
    function visitClinic(clinicId) {
        window.location.href = 'clinicspage.php?id=' + clinicId;
    }
</script>

</body>
</html>
