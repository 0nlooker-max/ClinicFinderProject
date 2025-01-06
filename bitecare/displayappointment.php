<?php
// Database connection
$servername = "localhost"; // Update with your server details
$username = "root";        // Update with your username
$password = "";            // Update with your password
$dbname = "bitecare_db"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from Appointments table
$sql = "SELECT * FROM Appointments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .container {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Appointments Information</h1>
        <table>
            <thead>
                <tr>
                    <th>AppointmentID</th>
                    <th>AppointmentDate</th>
                    <th>PatientName</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Contacts</th>
                    <th>DateOfBirth</th>
                    <th>DateBitten</th>
                    <th>SiteOfBite</th>
                    <th>BitingAnimal</th>
                    <th>AnimalStatus</th>
                    <th>AnimalOwner</th>
                    <th>Provoke</th>
                    <th>PlaceBitten</th>
                    <th>LocalWoundTreatment</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['AppointmentID'] . "</td>";
                        echo "<td>" . $row['AppointmentDate'] . "</td>";
                        echo "<td>" . $row['PatientName'] . "</td>";
                        echo "<td>" . $row['Age'] . "</td>";
                        echo "<td>" . $row['Gender'] . "</td>";
                        echo "<td>" . $row['Address'] . "</td>";
                        echo "<td>" . $row['Contacts'] . "</td>";
                        echo "<td>" . $row['DateOfBirth'] . "</td>";
                        echo "<td>" . $row['DateBitten'] . "</td>";
                        echo "<td>" . $row['SiteOfBite'] . "</td>";
                        echo "<td>" . $row['BitingAnimal'] . "</td>";
                        echo "<td>" . $row['AnimalStatus'] . "</td>";
                        echo "<td>" . $row['AnimalOwner'] . "</td>";
                        echo "<td>" . $row['Provoke'] . "</td>";
                        echo "<td>" . $row['PlaceBitten'] . "</td>";
                        echo "<td>" . $row['LocalWoundTreatment'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='16'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
