// /index.php
<?php
// Central Routing System
$request = $_GET['page'] ?? 'resident/homepage'; // Default route

switch ($request) {
    // Admin Routes
    case 'admin/dashboard':
        include 'AdminSide/dashboard.php';
        break;
    case 'admin/manageClinics':
        include 'AdminSide/manageClinics.php';
        break;

    // Clinic Routes
    case 'clinic/dashboard':
        include 'ClinicSide/dashboard.php';
        break;
    case 'clinic/appointments':
        include 'ClinicSide/appointments.php';
        break;

    // Resident Routes
    case 'resident/homepage':
        include 'ResidentSide/index.php';
        break;
    case 'resident/searchClinics':
        include 'ResidentSide/searchClinics.php';
        break;

    default:
        // 404 Page
        http_response_code(404);
        echo "404 - Page Not Found!";
        break;
}
?>

