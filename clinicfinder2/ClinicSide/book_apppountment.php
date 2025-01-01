<?php
$clinicId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch clinic name for reference
$conn = new mysqli("localhost", "root", "", "clinicfinder");
$sql = "SELECT name FROM clinics WHERE id = $clinicId";
$result = $conn->query($sql);
$clinic = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment | ClinicFinder</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h2>Book Appointment</h2>
    </header>

    <section>
        <h1>Appointment for <?php echo $clinic['name']; ?></h1>
        <form action="submit_appointment.php" method="POST">
            <input type="hidden" name="clinic_id" value="<?php echo $clinicId; ?>">
            <label for="name">Your Name:</label>
            <input type="text" name="name" required>
            <label for="date">Appointment Date:</label>
            <input type="date" name="date" required>
            <label for="time">Appointment Time:</label>
            <input type="time" name="time" required>
            <button type="submit">Submit</button>
        </form>
    </section>
</body>
</html>
