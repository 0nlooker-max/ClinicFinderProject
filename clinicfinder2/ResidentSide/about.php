<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About ClinicFinder</title>
    <style>
        /* General Reset */
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    color: #333;
    line-height: 1.6;
}

/* Navbar Styles */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.navbar .title h2 {
    margin: 0;
    font-size: 24px;
    color: white;
}

.navbar .nav-links {
    list-style: none;
    display: flex;
    gap: 20px;
    margin: 0;
    padding: 0;
}

.navbar .nav-links li {
    display: inline;
}

.navbar .nav-links a {
    text-decoration: none;
    color: white;
    padding: 8px 15px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.navbar .nav-links a:hover {
    background-color: #0056b3;
}

/* Hero Section */
.hero {
    text-align: center;
    padding: 60px 20px;
    background-color: #007bff;
    color: white;
}

.hero h1 {
    font-size: 36px;
    margin-bottom: 20px;
}

.hero p {
    font-size: 18px;
    max-width: 800px;
    margin: 0 auto;
}

/* Section Styles */
.section {
    padding: 40px 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.section h2 {
    font-size: 28px;
    color: #007bff;
    margin-bottom: 20px;
    text-align: center;
}

.section p {
    font-size: 16px;
    margin-bottom: 20px;
    text-align: center;
}

.features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.feature-item {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.feature-item h3 {
    color: #007bff;
    font-size: 20px;
    margin-bottom: 10px;
}

.feature-item p {
    font-size: 14px;
    color: #555;
}

/* Footer Styles */
footer {
    text-align: center;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    margin-top: 40px;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
    .navbar .nav-links {
        flex-direction: column;
        gap: 10px;
    }

    .hero h1 {
        font-size: 28px;
    }

    .hero p {
        font-size: 16px;
    }

    .features {
        grid-template-columns: 1fr;
    }
}

    </style>
</head>
<body>
    
    <header>
        <nav class="navbar">
            <div class="title">
                <h2>ClinicFinder</h2>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="map.php">Map Page</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="../Login/logout.php">LogOut</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="about-section">
            <div class="container">
                <h1>About ClinicFinder</h1>
                <p>
                    Welcome to <strong>ClinicFinder</strong>, your reliable partner for locating and accessing nearby clinics with ease.
                    Our platform is designed to help residents find the healthcare services they need quickly and conveniently.
                </p>

                <h2>Our Mission</h2>
                <p>
                    At ClinicFinder, our mission is to bridge the gap between patients and healthcare providers by offering a seamless and efficient system for clinic discovery and appointment booking.
                </p>

                <h2>Key Features</h2>
                <ul>
                    <li><strong>Locate Clinics:</strong> Easily find clinics near your location using our integrated map feature.</li>
                    <li><strong>Search Services:</strong> Search for clinics based on name, location, or services offered.</li>
                    <li><strong>Appointment Booking:</strong> Book appointments with your preferred clinic in just a few clicks.</li>
                    <li><strong>Real-Time Updates:</strong> Stay informed about clinic availability and services.</li>
                </ul>

                <h2>Why Choose Us?</h2>
                <p>
                    ClinicFinder is committed to improving the healthcare experience by providing an easy-to-use platform that prioritizes accessibility, efficiency, and user satisfaction.
                </p>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; 2025 ClinicFinder. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
