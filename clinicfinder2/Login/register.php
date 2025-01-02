<?php
include '..\includes\database.php';
session_start();

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $facebookacc = $_POST['facebookacc'] ?? null;
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email already exists
        $query = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $query->execute(['email' => $email]);

        if ($query->rowCount() > 0) {
            $error_message = "Email already exists. Please use a different email.";
        } else {
            // Insert user into the database
            $insert_query = $pdo->prepare("INSERT INTO user (username, firstname, lastname, facebookacc, password, email, role) 
                                           VALUES (:username, :firstname, :lastname, :facebookacc, :password, :email, :role)");
            $insert_query->execute([
                'username' => $username,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'facebookacc' => $facebookacc,
                'password' => $hashed_password,
                'email' => $email,
                'role' => $role
            ]);

            $success_message = "Account created successfully! <a href='login.php'>Login here</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClinicFinder - Register</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .register-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
            margin-top: 50px; /* Added space from the top */
        }
        .register-container h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #2575fc;
            outline: none;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            background: #2575fc;
            color: #fff;
            font-size: 16px;
            border: none;
            cursor: pointer;
            text-align: center;
            margin-top: 10px;
        }
        .btn:hover {
            background: #1a5ed1;
        }
        .error-message, .success-message {
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }
        .error-message {
            color: #d93025;
        }
        .success-message {
            color: #34a853;
        }
        .extra-links {
            text-align: center;
            margin-top: 15px;
        }
        .extra-links a {
            color: #2575fc;
            text-decoration: none;
            font-size: 14px;
        }
        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Create an Account</h2>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?= $success_message ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" placeholder="Enter your first name" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" placeholder="Enter your last name" required>
            </div>
            <div class="form-group">
                <label for="facebookacc">Facebook Account (Optional)</label>
                <input type="text" name="facebookacc" id="facebookacc" placeholder="Enter your Facebook account">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="patient">Patient</option>
                    <option value="clinic">Clinic</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        <div class="extra-links">
            <a href="login.php">Already have an account? Login here</a>
        </div>
    </div>
</body>
</html>
