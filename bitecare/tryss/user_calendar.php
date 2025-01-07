<?php
// Set timezone to the Philippines
date_default_timezone_set('Asia/Manila');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'bitecare_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get month and year from request or default to current
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$first_day_of_month = date('Y-m-01', strtotime($month));
$last_day_of_month = date('Y-m-t', strtotime($month));

// Fetch slots for the requested month
$query = "SELECT * FROM appointment_slots WHERE date BETWEEN '$first_day_of_month' AND '$last_day_of_month' ORDER BY date ASC";
$result = $conn->query($query);

// Initialize an array to store available slots for each date
$slots = [];
while ($row = $result->fetch_assoc()) {
    $slots[$row['date']] = [
        'available_slots' => $row['available_slots'],
        'status' => $row['status']
    ];
}

// Get today's date (Philippines timezone)
$today = date('Y-m-d');

// Handle form submission for adding appointments
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentDate = $_POST['appointmentDate'];
    $patientName = $_POST['patientName'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contacts = $_POST['contacts'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $dateBitten = $_POST['dateBitten'];
    $siteOfBite = $_POST['siteOfBite'];
    $bitingAnimal = $_POST['bitingAnimal'];
    $animalStatus = $_POST['animalStatus'];
    $animalOwner = $_POST['animalOwner'];
    $provoke = $_POST['provoke'];
    $placeBitten = $_POST['placeBitten'];
    $localWoundTreatment = $_POST['localWoundTreatment'];

    // Insert the appointment into the database
    $sql = "INSERT INTO appointments 
            (AppointmentDate, patient_name, age, gender, address, contacts, dob, DateBitten, SiteOfBite, BitingAnimal, AnimalStatus, AnimalOwner, Provoke, PlaceBitten, LocalWoundTreatment)
            VALUES 
            ('$appointmentDate', '$patientName', $age, '$gender', '$address', '$contacts', '$dateOfBirth', '$dateBitten', '$siteOfBite', '$bitingAnimal', '$animalStatus', '$animalOwner', '$provoke', '$placeBitten', '$localWoundTreatment')";

    if ($conn->query($sql) === TRUE) {
        // Update available slots for the selected date
        $updateSlotsQuery = "UPDATE appointment_slots 
                             SET available_slots = available_slots - 1, 
                                 status = CASE WHEN available_slots - 1 > 0 THEN 'available' ELSE 'unavailable' END 
                             WHERE date = '$appointmentDate' AND available_slots > 0";

        if ($conn->query($updateSlotsQuery) === TRUE) {
            $message = "Appointment added successfully!";
        } else {
            $message = "Error updating available slots: " . $conn->error;
        }
    } else {
        $message = "Error: " . $conn->error;
    }
    // Refresh the page
    header("Location: ".$_SERVER['PHP_SELF']."?month=".date('Y-m', strtotime($appointmentDate)));
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .calendar {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .calendar table {
            width: 100%;
        }
        .calendar td, .calendar th {
            text-align: center;
            vertical-align: middle;
            padding: 10px;
        }
        .calendar .table-warning {
            background-color: #fff3cd;
        }
        .calendar .table-success {
            background-color: #d4edda;
        }
        .calendar .table-danger {
            background-color: #f8d7da;
        }
        .calendar .table-secondary {
            background-color: #e2e3e5;
        }
        .select-date {
            font-size: 16px;
            font-weight: bold;
        }
        .btn-light:hover {
            background-color: #f0f0f0;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-footer .btn {
            background-color: #007bff;
            color: white;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, .form-group select, .form-group textarea {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        }
        .bg-success {
            color: white !important; /* Ensures text is readable on green background */
        }

        .bg-warning {
            color: black !important; /* Ensures text is readable on yellow background */
        }

        .bg-danger {
            color: white !important; /* Ensures text is readable on red background */
        }
        thead {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Appointments Availability</h1>
        <div class="calendar">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-link" onclick="changeMonth('prev')">&laquo; Previous</button>
                <h3><?= date('F Y', strtotime($month)) ?></h3>
                <button class="btn btn-link" onclick="changeMonth('next')">Next &raquo;</button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $first_day_of_month = date('w', strtotime("$month-01"));
                    $days_in_month = date('t', strtotime($month));
                    $day = 1;

                    for ($row = 0; $row < 6; $row++) {
                        echo "<tr>";
                        for ($col = 0; $col < 7; $col++) {
                            if ($row === 0 && $col < $first_day_of_month || $day > $days_in_month) {
                                echo "<td class='bg-light'></td>";
                            } else {
                                $date = "$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                                $class = 'text-white'; // Default text color
                                $backgroundClass = 'bg-white'; // Default background color
                                $slots_text = '';
                    
                                if ($date === $today) {
                                    $backgroundClass = 'bg-warning'; // Yellow for today's date
                                }
                                if (isset($slots[$date])) {
                                    $slots_text = $slots[$date]['available_slots'] . ' Slots';
                                    if ($slots[$date]['status'] === 'available' && $slots[$date]['available_slots'] > 0) {
                                        $backgroundClass = 'bg-success'; // Green for available slots
                                    } else {
                                        $backgroundClass = 'bg-danger'; // Red for unavailable slots
                                    }
                                }
                    
                                echo "<td class='$backgroundClass $class text-center' data-date='$date'>
                                        <button class='btn btn-light select-date' data-date='$date'>$day<br><small>$slots_text</small></button>
                                      </td>";
                                $day++;
                            }
                        }
                        echo "</tr>";
                        if ($day > $days_in_month) break;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Add Appointment Modal -->
        <div class="modal fade" id="addAppointmentModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Schedule an Appointment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="">
                        <div class="modal-body">
                            <input type="hidden" id="appointmentDate" name="appointmentDate" required>
                            <p><strong>Selected Date:</strong> <span id="selectedDateText"></span></p>
                            <div class="form-group">
                                <label for="patientName">Patient Name</label>
                                <input type="text" class="form-control" id="patientName" name="patientName" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" name="age" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="contacts">Contact Number</label>
                                <input type="text" class="form-control" id="contacts" name="contacts" required>
                            </div>
                            <div class="form-group">
                                <label for="dateOfBirth">Date of Birth</label>
                                <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required>
                            </div>
                            <div class="form-group">
                                <label for="dateBitten">Date Bitten</label>
                                <input type="date" class="form-control" id="dateBitten" name="dateBitten" required>
                            </div>
                            <div class="form-group">
                                <label for="siteOfBite">Site of Bite</label>
                                <input type="text" class="form-control" id="siteOfBite" name="siteOfBite">
                            </div>
                            <div class="form-group">
                                <label for="bitingAnimal">Biting Animal</label>
                                <input type="text" class="form-control" id="bitingAnimal" name="bitingAnimal">
                            </div>
                            <div class="form-group">
                                <label for="animalStatus">Animal Status</label>
                                <select class="form-control" id="animalStatus" name="animalStatus" required>
                                    <option value="Immunized">Immunized</option>
                                    <option value="Unimmunized">Unimmunized</option>
                                    <option value="Unknown">Unknown</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="animalOwner">Animal Owner</label>
                                <input type="text" class="form-control" id="animalOwner" name="animalOwner">
                            </div>
                            <div class="form-group">
                                <label for="provoke">Provoke</label>
                                <select class="form-control" id="provoke" name="provoke" required>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="placeBitten">Place Bitten</label>
                                <input type="text" class="form-control" id="placeBitten" name="placeBitten">
                            </div>
                            <div class="form-group">
                                <label for="localWoundTreatment">Local Wound Treatment</label>
                                <select class="form-control" id="localWoundTreatment" name="localWoundTreatment">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Appointment</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select-date').click(function() {
                var date = $(this).data('date');
                $('#appointmentDate').val(date);
                $('#selectedDateText').text(date);
                $('#addAppointmentModal').modal('show');
            });
        });

        function changeMonth(direction) {
            var currentMonth = '<?= $month ?>';
            var newMonth = new Date(currentMonth + '-01');

            if (direction === 'prev') {
                newMonth.setMonth(newMonth.getMonth() - 1);
            } else {
                newMonth.setMonth(newMonth.getMonth() + 1);
            }

            var newMonthString = newMonth.toISOString().slice(0, 7);
            window.location.href = "?month=" + newMonthString;
        }
    </script>
</body>
</html>
