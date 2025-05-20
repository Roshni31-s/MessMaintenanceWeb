<?php
// config.php - Central configuration file

// Determine environment: local vs. production
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1') {
    // Local Development Database Credentials (e.g., XAMPP/WAMP)
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', ''); // Often empty for 'root' on local setups
    define('DB_NAME', 'mealcare_db');
} else {
    // Production Database Credentials (from your web host)
    // You MUST replace these with your actual hosting details
    define('DB_HOST', 'your_production_db_host'); // e.g., 'localhost', or a specific hostname/IP
    define('DB_USER', 'your_production_db_username');
    define('DB_PASS', 'your_production_db_password');
    define('DB_NAME', 'your_production_db_name');
}

// Other common configurations (optional)
// define('SITE_NAME', 'MealCare');
// define('BASE_URL', 'https://www.yourdomain.com');

// Error logging setup (good for production)
ini_set('display_errors', 'Off'); // Never display errors on production
ini_set('log_errors', 'On');
ini_set('error_log', __DIR__ . '/../php_errors.log'); // Adjust path as needed, ideally outside web root

?>