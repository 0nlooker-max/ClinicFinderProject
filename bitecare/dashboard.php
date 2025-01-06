<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'bitecare_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query for counting doses
$sql = "
SELECT 
    CASE
        WHEN D0Date IS NOT NULL AND D3Date IS NULL AND D7Date IS NULL THEN 'First Dose'
        WHEN D0Date IS NOT NULL AND D3Date IS NOT NULL AND D7Date IS NULL THEN 'Second Dose'
        WHEN D0Date IS NOT NULL AND D3Date IS NOT NULL AND D7Date IS NOT NULL THEN 'Third Dose'
        ELSE 'No Dose or Beyond Third Dose'
    END AS DoseStatus,
    COUNT(*) AS DoseCount
FROM 
    Patients
GROUP BY 
    DoseStatus;
";

$result = $conn->query($sql);

$doseCounts = [
    'First Dose' => 0,
    'Second Dose' => 0,
    'Third Dose' => 0,
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doseCounts[$row['DoseStatus']] = $row['DoseCount'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .dashboard {
            text-align: center;
            padding: 20px;
        }
        .title {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .dose-boxes {
            display: flex;
            justify-content: center;
            gap: 20px;
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
            color: #333;
        }
    </style>
</head>
<body>
    <div class="dose-boxes">
        <div class="dose-box">
            <div class="dose-title">First Dose</div>
            <div class="dose-count"><?php echo $doseCounts['First Dose']; ?></div>
        </div>
        <div class="dose-box">
            <div class="dose-title">Second Dose</div>
            <div class="dose-count"><?php echo $doseCounts['Second Dose']; ?></div>
        </div>
        <div class="dose-box">
            <div class="dose-title">Third Dose</div>
            <div class="dose-count"><?php echo $doseCounts['Third Dose']; ?></div>
        </div>
    </div>
</body>
</html>

