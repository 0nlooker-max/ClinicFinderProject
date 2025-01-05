<?php
include '../includes/database.php'; // Include database connection
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.php");
    exit();
}
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $contact_info = $_POST['contact_info']; // Variable name remains the same
    $services = $_POST['services'];
    $availability = $_POST['availability'];
    $status = $_POST['status'];

    // Handle image upload
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $image = null;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO clinics (name, address, latitude, longitude, contac_info, services, availability, status, image) 
                               VALUES (:name, :address, :latitude, :longitude, :contact_info, :services, :availability, :status, :image)");
        $stmt->execute([
            ':name' => $name,
            ':address' => $address,
            ':latitude' => $latitude,
            ':longitude' => $longitude,
            ':contact_info' => $contact_info, // Bind to the correct column name
            ':services' => $services,
            ':availability' => $availability,
            ':status' => $status,
            ':image' => $image
        ]);
        $successMessage = "Clinic added successfully!";
    } catch (PDOException $e) {
        $errorMessage = "Error adding clinic: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Clinic</title>
    <link rel="stylesheet" href="..\assets\css\admin_add_view.css">
    <style>
        /* Sidebar Styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .main-container {
            display: flex;
            min-height: 100vh;
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

        .sidebar nav ul li a:hover {
            background-color: #34495e;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f4f4f9;
        }

        /* Form Container */
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #0047AB;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .back-button:hover {
            background-color: #003580;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
        }

        form input, form textarea, form select, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            background-color: #0047AB;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #003580;
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
                    <li><a href="adminhompage.php">Dashboard</a></li>
                    <li><a href="add_clinic.php" class="active">Add Clinic</a></li>
                    <li><a href="view_clinics.php">View Clinics</a></li>
                    <li><a href="system_reports.php">System Reports</a></li>
                    <li><a href="..\includes\logout.php">Log Out</a></li>

                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="content">
            <div class="container">
                <h1>Add Clinic</h1>
                <?php if (isset($successMessage)) { echo "<p class='success'>$successMessage</p>"; } ?>
                <?php if (isset($errorMessage)) { echo "<p class='error'>$errorMessage</p>"; } ?>
                
                <!-- Back to Dashboard Button -->

                <form method="POST" enctype="multipart/form-data">
                    <label for="name">Clinic Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>

                    <label for="latitude">Latitude:</label>
                    <input type="text" id="latitude" name="latitude" required>

                    <label for="longitude">Longitude:</label>
                    <input type="text" id="longitude" name="longitude" required>

                    <label for="contact_info">Contact Info:</label>
                    <input type="text" id="contact_info" name="contact_info" required>

                    <label for="services">Services:</label>
                    <textarea id="services" name="services" required></textarea>

                    <label for="availability">Availability:</label>
                    <input type="text" id="availability" name="availability" required>

                    <label for="status">Status:</label>
                    <select id="status" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <label for="image">Clinic Image:</label>
                    <input type="file" id="image" name="image" accept="image/*">

                    <button type="submit">Add Clinic</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
