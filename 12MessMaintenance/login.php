<?php
// login.php

// --- IMPORTANT: Include your configuration file first ---
// This file handles:
// 1. Starting the session (session_start()).
// 2. Defining database constants (DB_HOST, DB_USER, DB_PASS, DB_NAME).
// 3. Setting up error logging based on the environment (local vs. production).
require_once 'config.php'; // Make sure this path is correct relative to login.php

// Include header (if header.php provides necessary HTML or initial layout like a navbar)
include_once 'header.php';

// --- Redirect if already logged in ---
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

// Initialize error message variable
$fmsg = '';

// --- Database Connection ---
// Create the database connection using constants defined in config.php.
// This is the correct way to get your $conn object after including config.php
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check for connection errors
    if ($conn->connect_error) {
        error_log("Database connection failed for login: " . $conn->connect_error);
        // This is where the 'System error' comes from if the connection fails
        die("System error. Please try again later.");
    }
} catch (Exception $e) {
    error_log("Database connection exception for login: " . $e->getMessage());
    die("System error. Please try again later.");
}

// --- Process Login Form Submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $fmsg = "Username and password are required.";
    } else {
        $query = "SELECT id, username, password FROM users WHERE username = ?"; // Ensure 'users' is the correct table name
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                session_regenerate_id(true);
                header("Location: dashboard.php");
                exit();
            } else {
                $fmsg = "Invalid username or password.";
            }
            $stmt->close();
        } else {
            $fmsg = "Login system error. Please try again later.";
            error_log("Login prepare statement failed: " . $conn->error);
        }
    }
}

// --- Close the database connection ---
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>MealCare - Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00b894;
            --primary-dark: #00a082;
            --secondary: #0984e3;
            --accent: #fd79a8;
            --dark: #2d3436;
            --light: #f9f9f9;
            --warn: #fdcb6e;
            --success: #55efc4;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(135deg, rgba(0,184,148,0.1), rgba(85,239,196,0.1));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        .login-container {
            max-width: 300px;
            width: 100%;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--primary);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo img {
            height: 60px;
        }

        .form-heading {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0,184,148,0.2);
            outline: none;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .input-with-icon {
            padding-left: 40px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 10px rgba(0,184,148,0.3);
            margin-bottom: 15px;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,184,148,0.4);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,184,148,0.3);
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #ffe9e9;
            color: #d63031;
            border-left: 4px solid #d63031;
        }

        .login-footer {
            text-align: center;
            margin-top: 30px;
            color: #888;
            font-size: 14px;
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #888;
            font-size: 14px;
            text-decoration: none;
        }

        .forgot-password a:hover {
            color: var(--primary);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <h1 style="color: var(--primary); margin: 0;">Mess Maintenance</h1>
        </div>

        <form method="POST">
            <?php if(isset($fmsg) && !empty($fmsg)){ ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($fmsg); ?>
                </div>
            <?php } ?>

            <h2 class="form-heading">Welcome Back</h2>

            <div class="input-group">
                <span class="input-icon">👤</span>
                <input type="text" name="username" class="form-control input-with-icon" placeholder="Username" required autofocus>
            </div>

            <div class="input-group">
                <span class="input-icon">🔒</span>
                <input type="password" name="password" class="form-control input-with-icon" placeholder="Password" required>
            </div>

            <div class="forgot-password">
                <a href="forgot-password.php">Forgot password?</a>
            </div>

            <button class="btn btn-primary" type="submit">Sign In</button>
            <a class="btn btn-outline" href="register.php">Create Account</a>

            <div class="login-footer">
                <p>New to Mess Maintenance? <a href="register.php">Register</a></p>
                <p><a href="index.php">Return to Home</a></p>
            </div>
        </form>
    </div>
</body>
</html>