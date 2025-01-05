<?php
include '../includes/database.php'; // Include database connection

// Fetch all clinics
try {
    $stmt = $pdo->query("SELECT * FROM clinics");
    $clinics = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching clinics: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Clinics</title>
    <link rel="stylesheet" href="..\assets\css\admin_add_view.css">
</head>
<body>
    <div class="container">
        <h1>View Clinics</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact Info</th>
                    <th>Availability</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clinics as $clinic): ?>
                <tr>
                    <td><?php echo $clinic['clinic_id']; ?></td>
                    <td><?php echo $clinic['name']; ?></td>
                    <td><?php echo $clinic['address']; ?></td>
                    <td><?php echo $clinic['contact_info']; ?></td>
                    <td><?php echo $clinic['availability']; ?></td>
                    <td><?php echo ucfirst($clinic['status']); ?></td>
                    <td>
                        <?php if ($clinic['image']): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($clinic['image']); ?>" alt="Clinic Image" width="50">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit_clinic.php?id=<?php echo $clinic['clinic_id']; ?>">Edit</a>
                        <a href="delete_clinic.php?id=<?php echo $clinic['clinic_id']; ?>" onclick="return confirm('Are you sure you want to delete this clinic?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
