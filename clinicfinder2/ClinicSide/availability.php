<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            height: 55rem;
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
        <h1>ClinicFinder</h1>
        <div>
            <a href="dashboard.php">Home</a>
            <a href="#">Contact</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <!-- Sidebar -->
        <div class="side-panel">
            <h2>Navigation</h2>
            <a href="clinicprofile.php">Update Profile</a>
            <a href="#">Appointments</a>
            <a href="#">Manage Availability</a>
            <a href="logout.php">Logout</a>
        </div>

        <!-- Main Content -->
        <div class="profile-container">
            <h2>Set Availability Schedule</h2>
            <form action="save_availability.php" method="POST">
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

                <!-- Morning Slot -->
                <h3>Morning Slot</h3>
                <label for="morning_slots">Number of Slots (08:00 - 12:00):</label>
                <input type="number" id="morning_slots" name="morning_slots" min="20" max="50" required placeholder="Enter slots (20-50)">

                <!-- Afternoon Slot -->
                <h3>Afternoon Slot</h3>
                <label for="afternoon_slots">Number of Slots (13:00 - 17:00):</label>
                <input type="number" id="afternoon_slots" name="afternoon_slots" min="20" max="50" required placeholder="Enter slots (20-50)">

                <!-- Submit Button -->
                <button type="submit">Save Schedule</button>
            </form>

            <!-- Availability Table -->
            <h2>Availability Schedule</h2>
            <table>
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Morning Slots</th>
                        <th>Afternoon Slots</th>
                    </tr>
                </thead>
                <!-- Availability Table -->
        <h2>Availability Schedule</h2>
        <table>
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Morning Slots</th>
                    <th>Afternoon Slots</th>
                </tr>
        </thead>
            <tbody>
                <?php
                // Include your database connection file
                include '..\includes\database.php';

                try {
                    // Fetch data from the availability table
                    $stmt = $pdo->query("SELECT day, morning_slots, afternoon_slots FROM availability");

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['day']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['morning_slots']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['afternoon_slots']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No availability set yet.</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='3'>Error fetching data: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
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
