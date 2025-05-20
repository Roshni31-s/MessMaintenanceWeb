<<?php
require('db.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sample data - replace with actual user data from your database
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
$join_date = 'June 2023'; // Replace with actual join date
$food_saved = 12.5; // kg
$meals_shared = 8;
$waste_reduced = 25; // percentage
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .profile-card {
            max-width: 500px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            border: none;
            transition: transform 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-5px);
        }
        .profile-header {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            margin: 0 auto 15px;
            background-color: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .profile-avatar i {
            font-size: 50px;
        }
        .impact-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 5px 15px;
            font-size: 14px;
        }
        .stats-item {
            padding: 15px;
            text-align: center;
            border-right: 1px solid #eee;
        }
        .stats-item:last-child {
            border-right: none;
        }
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #2ecc71;
        }
        .stat-label {
            font-size: 12px;
            color: #777;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .progress {
            height: 8px;
            border-radius: 4px;
        }
        .progress-bar {
            background-color: #2ecc71;
        }
        .motivation-message {
            background-color: #f8f9fa;
            border-left: 4px solid #2ecc71;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card profile-card">
            <div class="profile-header">
                <span class="impact-badge">
                    <i class="fas fa-leaf me-1"></i> Level 2 Saver
                </span>
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h3><?= $username ?></h3>
                <p class="mb-0">Food Saver since <?= $join_date ?></p>
            </div>
            
            <div class="card-body">
                <div class="row text-center border-bottom">
                    <div class="col stats-item">
                        <div class="stat-value"><?= $food_saved ?>kg</div>
                        <div class="stat-label">Food Saved</div>
                        <div class="progress mt-2">
                            <div class="progress-bar" style="width: <?= min($food_saved*4, 100) ?>%"></div>
                        </div>
                    </div>
                    <div class="col stats-item">
                        <div class="stat-value"><?= $meals_shared ?></div>
                        <div class="stat-label">Meals Shared</div>
                        <div class="progress mt-2">
                            <div class="progress-bar" style="width: <?= min($meals_shared*10, 100) ?>%"></div>
                        </div>
                    </div>
                    <div class="col stats-item">
                        <div class="stat-value"><?= $waste_reduced ?>%</div>
                        <div class="stat-label">Waste Reduced</div>
                        <div class="progress mt-2">
                            <div class="progress-bar" style="width: <?= $waste_reduced ?>%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="motivation-message">
                    <h6><i class="fas fa-bullhorn text-success me-2"></i> Your Impact Matters!</h6>
                    <p class="mb-0 small">By saving <?= $food_saved ?>kg of food, you've helped reduce approximately <?= $food_saved*2 ?>kg of CO2 emissions - equivalent to charging <?= $food_saved*40 ?> smartphones!</p>
                </div>
                
                <div class="d-flex justify-content-between">
                   
                    <a href="logout.php" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>