<?php
// register.php

// --- IMPORTANT: Include your configuration file FIRST ---
// Adjust the path to config.php if it's not in the same directory.
// For example: include '../config.php'; if config.php is one level up.
require_once 'config.php'; // Using require_once is safer as it stops execution if file is missing

// The session_start() is already in config.php for consistency, but if not, keep it here.
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }


// Include header (if header.php provides necessary HTML or initial layout)
// Ensure header.php does NOT contain DB connection or session_start() itself.
include 'header.php'; // Assuming header.php just contains HTML <head> and opening <body> tags.

// Initialize variables for form
$error = '';
$success = '';
$username = '';
$email = '';

// Create database connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        // Log the specific error for debugging on the server
        error_log("Database connection failed: " . $conn->connect_error);
        // Display a generic error message to the user
        die("System error. Please try again later.");
    }
} catch (Exception $e) {
    // Catch any other exceptions during connection and log them
    error_log("Database connection exception: " . $e->getMessage());
    die("System error. Please try again later.");
}

// Process registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['email'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
    } else {
        // Check if username or email already exists
        try {
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            if ($stmt === false) {
                error_log("Prepare statement failed: " . $conn->error);
                throw new Exception("SQL prepare error.");
            }
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Username or email already exists.";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user
                $insert_stmt = $conn->prepare("INSERT INTO users (username, password, email, created_at) VALUES (?, ?, ?, NOW())");
                if ($insert_stmt === false) {
                    error_log("Prepare insert statement failed: " . $conn->error);
                    throw new Exception("SQL insert prepare error.");
                }
                $insert_stmt->bind_param("sss", $username, $hashed_password, $email);

                if ($insert_stmt->execute()) {
                    $success = "Registration successful! You can now <a href='login.php'>login</a>.";
                    $username = ''; // Clear fields on success
                    $email = '';
                } else {
                    $error = "Registration failed. Please try again.";
                    error_log("User registration failed for: " . $username . " - " . $insert_stmt->error);
                }
                $insert_stmt->close();
            }
            $stmt->close();
        } catch (Exception $e) {
            $error = "System error. Please try again later.";
            error_log("Registration process exception: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | MealCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Your custom CSS here. This is fine to keep in the <style> block for a small project,
           but for larger ones, move to a separate .css file. */
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .register-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40,167,69,.25);
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h2 class="text-center mb-4">Create Your Account</h2>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                           value="<?= htmlspecialchars($username) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="<?= htmlspecialchars($email) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <small class="text-muted">Minimum 8 characters</small>
                </div>

                <button type="submit" class="btn btn-success w-100 mt-3">Register</button>

                <div class="text-center mt-3">
                    <p>Already have an account? <a href="login.php">Sign in</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>