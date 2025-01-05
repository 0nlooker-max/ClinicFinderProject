<?php
include '../includes/database.php'; // Database connection

// Fetch metrics using the $pdo object
$totalClinics = $pdo->query("SELECT COUNT(*) AS total FROM clinics")->fetch(PDO::FETCH_ASSOC)['total'];
$totalUsers = $pdo->query("SELECT COUNT(*) AS total FROM user")->fetch(PDO::FETCH_ASSOC)['total'];
$pendingReports = $pdo->query("SELECT COUNT(*) AS total FROM system_reports WHERE status = 'pending'")->fetch(PDO::FETCH_ASSOC)['total'];
$resolvedReports = $pdo->query("SELECT COUNT(*) AS total FROM system_reports WHERE status = 'resolved'")->fetch(PDO::FETCH_ASSOC)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General Reset */
body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.main-container {
    display: flex;
    min-height: 100vh;
    overflow: hidden;
}

.sidebar {
    width: 250px;
    background-color: #2c3e50;
    color: #ecf0f1;
    display: flex;
    flex-direction: column;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

.sidebar-header {
    font-size: 1.5em;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}

.sidebar nav ul {
    list-style: none;
    padding: 0;
}

.sidebar nav ul li {
    margin: 10px 0;
}

.sidebar nav ul li a {
    color: #ecf0f1;
    text-decoration: none;
    padding: 10px;
    display: block;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.sidebar nav ul li a:hover {
    background-color: #34495e;
}

.content {
    flex-grow: 1;
    padding: 20px;
    background-color: #f4f4f9;
    overflow-y: auto;
}

/* Stats Cards */
.stats {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.stat-card {
    flex: 1;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.stat-card h3 {
    margin: 0;
    font-size: 1.2em;
}

.stat-card p {
    margin: 10px 0 0;
    font-size: 2em;
    font-weight: bold;
}

/* Chart Section */
.chart {
    margin-top: 20px;
}

    </style>
</head>
<body>
    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="add_clinic.php">Add Clinic</a></li>
                    <li><a href="view_clinics.php">View Clinics</a></li>
                    <li><a href="system_reports.php">System Reports</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="content">
            <h1>Welcome to the Admin Dashboard</h1>
            
            <!-- Metrics Overview -->
            <div class="stats">
                <div class="stat-card">
                    <h3>Total Clinics</h3>
                    <p><?php echo $totalClinics; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Users</h3>
                    <p><?php echo $totalUsers; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Pending Reports</h3>
                    <p><?php echo $pendingReports; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Resolved Reports</h3>
                    <p><?php echo $resolvedReports; ?></p>
                </div>
            </div>
            
            <!-- Recent Activities -->
            <div class="recent-activities">
                <h2>Recent Activities</h2>
                <ul>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM system_reports ORDER BY created_at DESC LIMIT 5");
                    while ($activity = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li>Report #{$activity['report_id']} by {$activity['reported_by']} - {$activity['description']} ({$activity['status']})</li>";
                    }
                    ?>
                </ul>
            </div>
            
            <!-- Reports Chart -->
            <div class="chart">
                <h2>Reports Overview</h2>
                <canvas id="reportsChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Render Chart for Reports
        const ctx = document.getElementById('reportsChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pending Reports', 'Resolved Reports'],
                datasets: [{
                    data: [<?php echo $pendingReports; ?>, <?php echo $resolvedReports; ?>],
                    backgroundColor: ['#f39c12', '#27ae60']
                }]
            }
        });
    </script>
</body>
</html>
