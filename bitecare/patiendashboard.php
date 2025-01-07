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
    <title>Filter Dose Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .filter-buttons {
            margin-bottom: 20px;
            text-align: center;
        }
        .filter-buttons button {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            cursor: pointer;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .filter-buttons button:hover, .filter-buttons button.active {
            background-color: #0056b3;
        }
        .dose-count {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .dose-box {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            text-align: center;
            width: 150px;
        }
        .dose-box h3 {
            margin: 0;
            color: #333;
        }
        .dose-box p {
            font-size: 24px;
            margin: 0;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin: 20px 0;
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
    <h1>Patients Dose Table</h1>

    <div class="dose-count">
        <div class="dose-box">
            <h3>First Dose</h3>
            <p id="firstDoseCount">0</p>
        </div>
        <div class="dose-box">
            <h3>Second Dose</h3>
            <p id="secondDoseCount">0</p>
        </div>
        <div class="dose-box">
            <h3>Third Dose</h3>
            <p id="thirdDoseCount">0</p>
        </div>
    </div>

    <div class="filter-buttons">
        <button onclick="filterTable('all')" class="active">All</button>
        <button onclick="filterTable('first')">First Dose</button>
        <button onclick="filterTable('second')">Second Dose</button>
        <button onclick="filterTable('third')">Third Dose</button>
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
                <?php 
                $firstDoseCount = $secondDoseCount = $thirdDoseCount = 0;
                while ($row = $result->fetch_assoc()): 
                    $dose = '';
                    if (!empty($row['d7_date'])) {
                        $dose = 'third';
                        $thirdDoseCount++;
                    } elseif (!empty($row['d3_date'])) {
                        $dose = 'second';
                        $secondDoseCount++;
                    } elseif (!empty($row['d0_date'])) {
                        $dose = 'first';
                        $firstDoseCount++;
                    }
                ?>
                    <tr data-dose="<?php echo $dose; ?>">
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
        // Initial dose counts
        document.getElementById('firstDoseCount').textContent = <?php echo $firstDoseCount; ?>;
        document.getElementById('secondDoseCount').textContent = <?php echo $secondDoseCount; ?>;
        document.getElementById('thirdDoseCount').textContent = <?php echo $thirdDoseCount; ?>;

        // Filter function
        function filterTable(dose) {
            const rows = document.querySelectorAll('#patientTable tr');
            rows.forEach(row => {
                row.style.display = (dose === 'all' || row.getAttribute('data-dose') === dose) ? '' : 'none';
            });

            // Update active button
            document.querySelectorAll('.filter-buttons button').forEach(button => {
                button.classList.remove('active');
            });
            event.target.classList.add('active');
        }
    </script>
</body>
</html>
