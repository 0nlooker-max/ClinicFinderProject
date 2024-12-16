<?php
// db.php - Database connection file

$host = "localhost";
$user = "root";
$password = "";
$database = "clinicdb";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
