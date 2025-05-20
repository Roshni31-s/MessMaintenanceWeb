<?php
// Database connection parameters
$servername = "sql113.infinityfree.com";
$username = "if0_39034319";
$password = "Roshni23";
$dbname = " if0_39034319_dbmess_2"; 

// Enable error reporting with strict mode
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create connection
    $con = new mysqli($servername, $username, $password, $dbname);
    
    // Set charset to UTF-8
    $con->set_charset("utf8mb4");
    
    // Check connection
    if ($con->connect_error) {
        throw new Exception("Connection failed: " . $con->connect_error);
    }
    
    // Test the connection with a simple query
    $test = $con->query("SELECT 1");
    if (!$test) {
        throw new Exception("Test query failed");
    }
    
    // Make connection available to other scripts
    // (This is already done implicitly by the above code, but including it for clarity)
    
} catch (Exception $e) {
    // Log the error for administrator review
    error_log("Database Error: " . $e->getMessage());
    
    // Show a user-friendly message instead of exposing error details
    die("We're experiencing technical difficulties. Please try again later.");
}

// No closing PHP tag to prevent accidental whitespace