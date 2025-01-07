<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'bitecare_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to update slots
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $available_slots = $_POST['available_slots'];
    $status = $_POST['status'];

    // Check if the date exists in the database
    $check_query = "SELECT * FROM appointment_slots WHERE date = '$date'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        // Update the existing record
        $update_query = "UPDATE appointment_slots SET available_slots = ?, status = ? WHERE date = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('iss', $available_slots, $status, $date);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert a new record
        $insert_query = "INSERT INTO appointment_slots (date, available_slots, status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param('sis', $date, $available_slots, $status);
        $stmt->execute();
        $stmt->close();
    }

    echo "<p style='color: green;'>Date updated successfully!</p>";
}

// Fetch all dates from the database
$query = "SELECT * FROM appointment_slots ORDER BY date ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RHU - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        form {
            margin-bottom: 20px;
        }
        input, select, button {
            padding: 8px;
            margin: 5px;
        }
        .container {
            width: 97%;
            background-color: #ffffff;
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

    </style>
</head>
<body>
   
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-paw"></i> RHU</h2>
            </div>
            <ul class="menu">
                <li><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="appointmentlist.php"><i class="fas fa-calendar-alt"></i> Appointment List</a></li>
                <li><a href="Patientlist.php"><i class="fas fa-list-ol"></i> Patient List</a></li>
                <li><a href="patientpayment.php"><i class="fas fa-money-bill-wave-alt"></i> Patient Payments</a></li>
                <li><a href="patientstatus.php"><i class="fas fa-user-alt"></i> Patient Status</a></li>
                <li><a href="staff.php"><i class="fas fa-users"></i> Staff</a></li>
                <li><a href="schedule_settings.php"><i class="fas fa-cogs"></i> Schedule</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
            <h1>Welcome to RHU Animal Bite Treatment Center - Admin Panel</h1>
                <div class="user-profile">
                    <span>Administrator Admin</span>
                    <!-- <img src="avatar-placeholder.png" alt="Admin Avatar"> -->
                </div>
            </header>
<div class="container">
            <h1>Manage Appointment Slots</h1>

<form method="POST" action="schedule_settings.php">
    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required>
    
    <label for="available_slots">Available Slots:</label>
    <input type="number" id="available_slots" name="available_slots" min="0" required>
    
    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="available">Available</option>
        <option value="unavailable">Unavailable</option>
        <option value="unavailable">Holiday</option>
    </select>
    
    <button type="submit">Update</button>
</form>

<h2>Current Appointment Slots</h2>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Available Slots</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['available_slots']; ?></td>
                <td><?php echo ucfirst($row['status']); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
         
</body>
</html>
