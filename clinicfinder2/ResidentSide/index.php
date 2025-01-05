<?php
include '../includes/database.php';
session_start();

// Check if the clinic_id is set in the session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.php");
    exit();
}

// Fetch clinics from the database
try {
    $sql = "SELECT clinic_id, name, address, services, availability FROM clinics WHERE status = 'active'";
    $stmt = $pdo->query($sql);
    $clinics = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching clinics: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/homepage.css">
    <title>Find Clinics</title>
</head>
<body>
    <?php require_once '../includes/header.php'; ?>

    <section class="search-section container mt-4">
        <div class="search-container text-center">
            <h1>Find Nearby Clinics</h1>
            <form method="POST" class="d-flex justify-content-center mt-3">
                <input type="text" id="search-bar" name="query" class="form-control w-50 me-2" placeholder="Search by name, location, or service">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="map_btn text-center mt-3">
            <a href="map.php?page=resident/searchClinics" class="btn btn-success">Go to Map</a>
        </div>
    </section>

    <div class="second container mt-5">
        <h2 class="mb-4">Available Clinics</h2>
        <div class="row">
            <?php if (!empty($clinics)): ?>
                <?php foreach ($clinics as $clinic): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card" style="width: 18rem;">
                            <img src="../assets/images/clinic-placeholder.jpg" class="card-img-top" alt="Clinic Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($clinic['name']) ?></h5>
                                <p class="card-text">Location: <?= htmlspecialchars($clinic['address']) ?></p>
                                <p class="card-text">Services: <?= htmlspecialchars($clinic['services']) ?></p>
                                <p class="card-text">Availability: <?= htmlspecialchars($clinic['availability']) ?></p>
                                <a href="clinic_details.php?id=<?= $clinic['clinic_id'] ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No clinics available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php require_once '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
