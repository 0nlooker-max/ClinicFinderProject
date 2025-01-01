<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ClinicFinder</title>
    <link rel="stylesheet" href="..\assets\css\login.css">
</head>
<body>
    <div class="login-container">
        <h1>Welcome to ClinicFinder</h1>
        <form action="login_handler.php" method="POST">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" placeholder="Enter your username or email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn">Log In</button>
        </form>
        <div class="options">
            <button onclick="loginAsGuest()" class="btn guest-btn">Log In as Guest</button>
            <p>Don't have an account? <a href="register.php">Create one here</a></p>
        </div>
    </div>

    <script>
        function loginAsGuest() {
            // Redirect to the homepage or guest access area
            window.location.href = "homepage.php?role=guest";
        }
    </script>
</body>
</html>
