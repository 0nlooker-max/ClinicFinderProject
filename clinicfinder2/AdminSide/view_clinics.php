<?php
session_start(); // Start session

include '../includes/database.php'; // Include database connection

// Check if user_id is set in session
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if no user_id is in session
    header("Location: ..\Login\login.php");
    exit();
}

// Fetch user details from the database
try {
    $stmt = $pdo->prepare("SELECT role FROM user WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and their role is admin
    if (!$user || $user['role'] !== 'admin') {
        // Redirect to an error page if not an admin
        header("Location: ../error.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

// Fetch clinics data from the database
try {
    $stmt = $pdo->query("SELECT * FROM clinics ORDER BY created_at DESC");
    $clinics = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Clinics</title>
    <link rel="stylesheet" href="styles.css">
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
            background-color: #0047AB;
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

        .sidebar nav ul li a:hover,
        .sidebar nav ul li a.active {
            background-color: #34495e;
        }

        .container {
            flex-grow: 1;
            padding: 20px;
            background-color: #f4f4f9;
            overflow-y: auto;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #0047AB;
            color: white;
        }

        table td img {
            max-width: 50px;
            max-height: 50px;
            border-radius: 4px;
        }

        .action-btns a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            margin: 0 2px;
            color: white;
            font-size: 0.9em;
        }

        .action-btns .edit {
            background-color: #27ae60;
        }

        .action-btns .delete {
            background-color: #e74c3c;
        }

        .action-btns .edit:hover {
            background-color: #2ecc71;
        }

        .action-btns .delete:hover {
            background-color: #c0392b;
        }

        .scrollable-box {
            max-height: 50px;
            overflow-y: auto;
            padding: 5px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .scrollable-box::-webkit-scrollbar {
            width: 6px;
        }

        .scrollable-box::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
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
                    <li><a href="adminhomepage.php">Dashboard</a></li>
                    <li><a href="add_clinic.php">Add Clinic</a></li>
                    <li><a href="view_clinics.php" class="active">View Clinics</a></li>
                    <li><a href="system_reports.php">System Reports</a></li>
                    <li><a href="..\includes\logout.php">Log Out</a></li>

                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="container">
            <h1>Clinics</h1>
            <table>
                <thead>
                    <tr>
                        <th>Clinic ID</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Contact Info</th>
                        <th>Services</th>
                        <th>Availability</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clinics)) : ?>
                        <?php foreach ($clinics as $clinic) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($clinic['clinic_id']); ?></td>
                                <td><?php echo htmlspecialchars($clinic['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($clinic['name']); ?></td>
                                <td><?php echo htmlspecialchars($clinic['address']); ?></td>
                                <td><?php echo htmlspecialchars($clinic['latitude']); ?></td>
                                <td><?php echo htmlspecialchars($clinic['longitude']); ?></td>
                                <td><?php echo htmlspecialchars($clinic['contac_info']); ?></td>
                                <td>
                                    <div class="scrollable-box">
                                        <?php echo htmlspecialchars($clinic['services']); ?>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($clinic['availability']); ?></td>
                                <td><?php echo htmlspecialchars($clinic['status']); ?></td>
                                <td>
                                    <?php if (!empty($clinic['image'])) : ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($clinic['image']); ?>" alt="Clinic Image">
                                    <?php else : ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($clinic['created_at']); ?></td>
                                <td class="action-btns">
                                    <a href="edit_clinic.php?id=<?php echo $clinic['clinic_id']; ?>" class="edit">Edit</a>
                                    <a href="delete_clinic.php?id=<?php echo $clinic['clinic_id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this clinic?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="13">No clinics found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
