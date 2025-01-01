<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Base CSS file -->
    
    <!-- Include specific CSS file only if $specific_css is set -->
    <?php if (isset($specific_css) && !empty($specific_css)) : ?>
        <link rel="stylesheet" href="../assets/css/<?php echo $specific_css; ?>">
    <?php endif; ?>
    
    <title>ClinicFinder</title>
</head>
<body>
<header>
        <nav class="navbar">
            <div class="logo">
                <h2>ClinicFinder</h2>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="map.php">Map Page</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>
