<?php
require_once "../includes/database.php"; // Ensure this file connects to your database using PDO
session_start();

// Check if clinic is logged in
if (!isset($_SESSION['clinic_id'])) {
    header("Location: ../Login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .container {
            display: flex;
            background-color: #007bff;
            flex-direction: row;
            flex: 1;
        }
        .side-panel {
            width: 250px;
            background-color: #0047AB;
            color: white;
            height: 35rem;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .side-panel h2 {
            font-size: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .side-panel a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #007bff;
            border-radius: 4px;
            text-align: center;
        }
        .side-panel a:hover {
            background-color: #003f7f;
        }
        .profile-container {
            flex: 1;
            margin: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .accept {
            background-color: #28a745;
            color: white;
        }
        .decline {
            background-color: #dc3545;
            color: white;
        }
        button:hover {
            opacity: 0.9;
        }
        .footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: auto;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .side-panel {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <h1>Clinic Management</h1>
        <a href="clinicprofile.php">Home</a>
        <a href="about.php">About</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="container"">
        <!-- Sidebar -->
        <div class="side-panel">
            <h2>Menu</h2>
            <a href="clinicprofile.php">Update Profile</a>
            <a href="appointments.php">Appointments</a>
            <a href="availability.php">Manage Availability</a>
            <a href="../Login/logout.php">Logout</a>
        </div>

        <!-- Main Content -->
        <div class="profile-container">
            <h2>View Appointments</h2>
            <table>
                <thead>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $stmt = $pdo->prepare("
                            SELECT appointment_id, date, time, status 
                            FROM appointment 
                            WHERE clinic_id = :clinic_id 
                            ORDER BY date, time
                        ");
                        $stmt->execute(['clinic_id' => $_SESSION['clinic_id']]);

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['appointment_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>
                                    <form action='backapointment.php' method='POST' style='display:inline-block;'>
                                        <input type='hidden' name='appointment_id' value='" . $row['appointment_id'] . "'>
                                        <input type='hidden' name='action' value='accept'>
                                        <button type='submit' class='accept'>Accept</button>
                                    </form>
                                    <form action='backapointment.php' method='POST' style='display:inline-block;'>
                                        <input type='hidden' name='appointment_id' value='" . $row['appointment_id'] . "'>
                                        <input type='hidden' name='action' value='decline'>
                                        <button type='submit' class='decline'>Decline</button>
                                    </form>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No appointments available.</td></tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='5'>Error: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2025 ClinicFinder. All Rights Reserved.
    </div>
</body>
</html>
