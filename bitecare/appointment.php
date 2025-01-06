<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bitecare_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

    $sql = "INSERT INTO Appointments 
            (AppointmentDate, PatientName, Age, Gender, Address, Contacts, DateOfBirth, DateBitten, SiteOfBite, BitingAnimal, AnimalStatus, AnimalOwner, Provoke, PlaceBitten, LocalWoundTreatment)
            VALUES 
            ('$appointmentDate', '$patientName', $age, '$gender', '$address', '$contacts', '$dateOfBirth', '$dateBitten', '$siteOfBite', '$bitingAnimal', '$animalStatus', '$animalOwner', '$provoke', '$placeBitten', '$localWoundTreatment')";

    if ($conn->query($sql) === TRUE) {
        $message = "Appointment added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Appointment Calendar</h2>
        <p>Click a date to schedule an appointment.</p>

        <!-- Example of a calendar -->
        <div class="row">
            <div class="col-12">
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
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><button class="btn btn-light select-date" data-date="2025-01-08">8</button></td>
                            <td><button class="btn btn-light select-date" data-date="2025-01-09">9</button></td>
                            <td><button class="btn btn-light select-date" data-date="2025-01-10">10</button></td>
                            <td><button class="btn btn-light select-date" data-date="2025-01-11">11</button></td>
                        </tr>
                        <!-- Add rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
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
                            <select class="form-control" id="localWoundTreatment" name="localWoundTreatment" required>
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

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show modal and set the selected date
        document.querySelectorAll('.select-date').forEach(button => {
            button.addEventListener('click', () => {
                const selectedDate = button.getAttribute('data-date');
                document.getElementById('appointmentDate').value = selectedDate;
                document.getElementById('selectedDateText').textContent = selectedDate;
                $('#addAppointmentModal').modal('show');
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
