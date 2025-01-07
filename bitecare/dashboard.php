<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'bitecare_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all patients
$sql = "
SELECT 
    patient_id, patient_name, age, gender, address, d0_date, d3_date, d7_date 
FROM 
    Patients;
";

$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dose Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .dose-boxes {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .dose-box {
            width: 200px;
            height: 150px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: #333;
        }
        .dose-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .dose-title {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .dose-count {
            font-size: 36px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Patient Dose Dashboard</h1>
    <div class="dose-boxes">
        <div class="dose-box" onclick="filterTable('all')">
            <div class="dose-title">All Doses</div>
        </div>
        <div class="dose-box" onclick="filterTable('first')">
            <div class="dose-title">First Dose</div>
        </div>
        <div class="dose-box" onclick="filterTable('second')">
            <div class="dose-title">Second Dose</div>
        </div>
        <div class="dose-box" onclick="filterTable('third')">
            <div class="dose-title">Third Dose</div>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Address</th>
                <th>D0 Date</th>
                <th>D3 Date</th>
                <th>D7 Date</th>
            </tr>
        </thead>
        <tbody id="patientTable">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr 
                        data-dose="<?php 
                            echo ($row['d0_date'] ? 'first' : '') . 
                                 ($row['d3_date'] ? 'second' : '') . 
                                 ($row['d7_date'] ? 'third' : ''); 
                        ?>">
                        <td><?php echo $row['patient_id']; ?></td>
                        <td><?php echo $row['patient_name']; ?></td>
                        <td><?php echo $row['age']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['d0_date']; ?></td>
                        <td><?php echo $row['d3_date']; ?></td>
                        <td><?php echo $row['d7_date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        function filterTable(dose) {
            const rows = document.querySelectorAll('#patientTable tr');
            rows.forEach(row => {
                if (dose === 'all') {
                    row.style.display = '';
                } else {
                    row.style.display = row.getAttribute('data-dose').includes(dose) ? '' : 'none';
                }
            });
        }
    </script>
</body>
</html>
