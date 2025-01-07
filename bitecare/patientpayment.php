<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'bitecare_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch patient payment data
$sql = "SELECT * FROM patient_payments";
$result = $conn->query($sql);

// Handle add or update requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $patient_name = $_POST['patient_name'];
    $first_dose_payment = $_POST['first_dose_payment'];
    $second_dose_payment = $_POST['second_dose_payment'];
    $third_dose_payment = $_POST['third_dose_payment'];
    $balance = $_POST['balance'];
    $total = $_POST['total'];

    if ($id) {
        // Update existing record
        $update_sql = "UPDATE patient_payments SET 
            patient_name = '$patient_name',
            first_dose_payment = '$first_dose_payment',
            second_dose_payment = '$second_dose_payment',
            third_dose_payment = '$third_dose_payment',
            balance = '$balance',
            total = '$total'
            WHERE payment_id = $id";
        $conn->query($update_sql);
    } else {
        // Add new record
        $insert_sql = "INSERT INTO patient_payments 
            (patient_name, first_dose_payment, second_dose_payment, third_dose_payment, balance, total)
            VALUES 
            ('$patient_name', '$first_dose_payment', '$second_dose_payment', '$third_dose_payment', '$balance', '$total')";
        $conn->query($insert_sql);
    }

    header('Location: patient_payments.php');
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-add, .btn-update {
            font-size: 12px;
            margin-right: 5px;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-title {
            font-weight: bold;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Patient Payments</h1>
            <p>Manage and update patient payments efficiently.</p>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>1st Dose Payment</th>
                            <th>2nd Dose Payment</th>
                            <th>3rd Dose Payment</th>
                            <th>Balance</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch payment data
                        $conn = new mysqli('localhost', 'root', '', 'bitecare_db');
                        $sql = "SELECT * FROM patient_payments";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $row['patient_name']; ?></td>
                            <td><?php echo "₱" . $row['first_dose_payment']; ?></td>
                            <td><?php echo "₱" . $row['second_dose_payment']; ?></td>
                            <td><?php echo "₱" . $row['third_dose_payment']; ?></td>
                            <td><?php echo "₱" . $row['balance']; ?></td>
                            <td><?php echo "₱" . $row['total']; ?></td>
                            <td>
                                <button class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#addModal" onclick="populateForm(<?php echo htmlspecialchars(json_encode($row)); ?>)">+ Add</button>
                                <button class="btn btn-warning btn-update" data-bs-toggle="modal" data-bs-target="#addModal" onclick="populateForm(<?php echo htmlspecialchars(json_encode($row)); ?>)">Update</button>
                            </td>
                        </tr>
                        <?php
                            endwhile;
                        else:
                        ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No records found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="patient_payments.php" method="POST" id="paymentForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add/Update Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="patient_name" class="form-label">Patient Name</label>
                            <input type="text" class="form-control" id="patient_name" name="patient_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="first_dose_payment" class="form-label">1st Dose Payment</label>
                            <input type="number" step="0.01" class="form-control" id="first_dose_payment" name="first_dose_payment" required>
                        </div>
                        <div class="mb-3">
                            <label for="second_dose_payment" class="form-label">2nd Dose Payment</label>
                            <input type="number" step="0.01" class="form-control" id="second_dose_payment" name="second_dose_payment" required>
                        </div>
                        <div class="mb-3">
                            <label for="third_dose_payment" class="form-label">3rd Dose Payment</label>
                            <input type="number" step="0.01" class="form-control" id="third_dose_payment" name="third_dose_payment" required>
                        </div>
                        <div class="mb-3">
                            <label for="balance" class="form-label">Balance</label>
                            <input type="number" step="0.01" class="form-control" id="balance" name="balance" required>
                        </div>
                        <div class="mb-3">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" step="0.01" class="form-control" id="total" name="total" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function populateForm(data) {
            document.getElementById('id').value = data.payment_id || '';
            document.getElementById('patient_name').value = data.patient_name || '';
            document.getElementById('first_dose_payment').value = data.first_dose_payment || '';
            document.getElementById('second_dose_payment').value = data.second_dose_payment || '';
            document.getElementById('third_dose_payment').value = data.third_dose_payment || '';
            document.getElementById('balance').value = data.balance || '';
            document.getElementById('total').value = data.total || '';
        }
    </script>
</body>
</html>
