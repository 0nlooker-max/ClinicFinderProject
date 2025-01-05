<?php
require_once "..\includes\database.php";
session_start();
if (!isset($_SESSION['clinic_id'])) {
    // Redirect to login or handle the error if the clinic_id is not found
    header("Location: ../Login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\assets\css\clinicavailability.php">
    <title>Set Availability Schedule</title>
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
            background-color:  #007bff;
            flex-direction: row;
            flex: 1;
        }
        .side-panel {
            width: 250px;
            background-color: #0047AB;
            color: white;
            height: 50rem;
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
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
        }
        select, input, button {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
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
        <div>
            <a href="dashboard.php">Home</a>
            <a href="#">Contact</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <!-- Sidebar -->
        <div class="side-panel">
            <h2>Clinic Management</h2>
            <a href="clinicprofile.php">Update Profile</a>
            <a href="apointment.php">Appointments</a>
            <a href="availability.php">Manage Availability</a>
            <a href="..\Login\logout.php">Logout</a>
        </div>

        <!-- Main Content -->
        <div class="profile-container">
            <h2>Set Availability Schedule</h2>
            <form action="backavailability.php" method="POST">
                <!-- Day Selection -->
                <label for="day">Day of the Week:</label>
                <select id="day" name="day" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                </select>
                <label for="slots">Number of Slots:</label>
                <input type="number" id="slots" name="slots" min="1" required>

                <!-- Submit Button -->
                <button type="submit">Save Schedule</button>
            </form>

            <!-- Availability Table -->
            <h2>Availability Schedule</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <tbody>
                <?php
                // Include database connection
                include '../includes/database.php';
                
                try {
                    // Fetch schedule data
                    $stmt = $pdo->query("SELECT * FROM available_schedule WHERE clinic_id = {$_SESSION['clinic_id']} ORDER BY date, start_time");
                
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['start_time']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['end_time']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['slot_status']) . "</td>";
                            echo "<td>
                                    <a href='edit_schedule.php?schedule_id=" . $row['schedule_id'] . "'>Edit</a> |
                                    <a href='delete_schedule.php?schedule_id=" . $row['schedule_id'] . "'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<p>No schedules available.</p>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
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
