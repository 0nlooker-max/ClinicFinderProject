<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .dashboard {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1 1 calc(45% - 20px);
            background: #007BFF;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card h3 {
            font-size: 2rem;
            margin: 0;
        }

        .card p {
            margin: 10px 0 0;
            font-size: 1rem;
        }

        @media (max-width: 600px) {
            .card {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Clinic Dashboard</h2>
        <div class="stats">
            <div class="card">
                <h3><?= $appointments_today ?></h3>
                <p>Appointments Today</p>
            </div>
            <div class="card">
                <h3><?= $appointments_this_month ?></h3>
                <p>Appointments This Month</p>
            </div>
            <div class="card">
                <h3><?= $completed_appointments ?></h3>
                <p>Completed Appointments</p>
            </div>
            <div class="card">
                <h3><?= $pending_appointments ?></h3>
                <p>Pending Appointments</p>
            </div>
        </div>
    </div>
</body>
</html>
