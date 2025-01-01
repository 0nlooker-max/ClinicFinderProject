<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Details</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header h1 {
            font-size: 36px;
            margin: 20px 0;
            text-align: center;
            color: #163486;
        }

        main {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        section {
            margin-bottom: 40px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 28px;
            margin-bottom: 15px;
            color: #163486;
        }

        p {
            margin: 10px 0;
            line-height: 1.6;
        }

        form {
            margin-top: 20px;
        }

        form label {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }

        form input, form select, form textarea, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        form button {
            background-color: #163486;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #1251a3;
        }

        #map {
            height: 400px;
            border-radius: 8px;
            overflow: hidden;
        }

        footer {
            text-align: center;
            padding: 20px 0;
            background: #163486;
            color: white;
        }

        .review-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-item h4 {
            margin: 0 0 5px;
        }

        .review-item p {
            margin: 0;
        }

        .star-rating {
            color: #ffc107;
            margin-bottom: 10px;
        }

        .star-rating i {
            margin-right: 2px;
        }
    </style>
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

    <main>
        <section id="clinic-info">
            <h2 id="clinic-name">Clinic Name</h2>
            <p id="clinic-address">Address: 123 Clinic St, City</p>
            <p id="clinic-contact">Contact: +123456789</p>
            <p id="clinic-services">Services: General Checkups, Dentistry, Pediatrics</p>
            <p id="clinic-availability">Availability: Monday - Friday, 9 AM - 5 PM</p>
        </section>

        <section id="reviews">
            <h2>Ratings and Reviews</h2>
            <div id="rating">
                <p>Average Rating: <span id="avg-rating">4.5</span> / 5</p>
            </div>
            <div id="review-list">
                <!-- Reviews will be dynamically added here -->
                <div class="review-item">
                    <h4>John Doe</h4>
                    <div class="star-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p>Great service and friendly staff!</p>
                </div>
            </div>
            <form id="review-form">
                <h3>Leave a Review</h3>
                <label for="rating">Rating:</label>
                <select id="rating-input" name="rating" required>
                    <option value="">--Select--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <label for="review">Review:</label>
                <textarea id="review-input" name="review" rows="3" required></textarea>
                <button type="submit">Submit Review</button>
            </form>
        </section>

        <section id="booking">
            <h2>Book an Appointment</h2>
            <form id="appointment-form">
                <label for="appointment-date">Date:</label>
                <input type="date" id="appointment-date" name="date" required>
                <label for="appointment-time">Time:</label>
                <select id="appointment-time" name="time" required>
                    <option value="">--Select Time--</option>
                </select>
                <button type="submit">Book Appointment</button>
            </form>
        </section>

        <section id="map-section">
            <h2>Location</h2>
            <div id="map"></div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 ClinicFinder</p>
    </footer>
</body>

</html>
