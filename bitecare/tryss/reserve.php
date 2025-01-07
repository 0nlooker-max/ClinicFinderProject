<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'bitecare_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$date = $data['date'];

// Check if the date exists and has available slots
$query = "SELECT available_slots FROM appointment_slots WHERE date = '$date' AND status = 'available'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $available_slots = $row['available_slots'];

    if ($available_slots > 0) {
        // Decrement the available slots
        $new_slots = $available_slots - 1;
        $update_query = "UPDATE appointment_slots SET available_slots = $new_slots WHERE date = '$date'";
        $conn->query($update_query);

        // Return the updated slots
        echo json_encode([
            'success' => true,
            'remaining_slots' => $new_slots
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No slots available!'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Date not available or already full!'
    ]);
}

$conn->close();
?>
