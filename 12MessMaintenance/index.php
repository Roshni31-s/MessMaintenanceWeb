<?php
require('db.php');
include 'header.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MealCare - Smart Campus Dining</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
        <style>
        :root {
            --primary: #27ae60;          /* Vibrant green */
            --primary-light: #2ecc71;   /* Lighter green */
            --primary-dark: #219653;    /* Darker green */
            --secondary: #f39c12;       /* Accent orange */
            --accent: #e67e22;          /* Warm accent */
            --light: #f5f5f5;           /* Light background */
            --dark: #34495e;            /* Dark text */
            --success: #2ecc71;         /* Success green */
            --warn: #f1c40f;            /* Warning yellow */
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1300px;
            width: 92%;
            margin-right: auto;
            margin-left: auto;
        }

        /* Green Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(39,174,96,0.9), rgba(46,204,113,0.9)), 
                       url('images/green-leaf-texture.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            text-align: center;
            border-bottom: 5px solid var(--primary-dark);
        }

        /* Eco Cards */
        .feature-card {
            transition: all 0.3s ease;
            margin-bottom: 25px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
            background: white;
            overflow: hidden;
            position: relative;
            border-top: 5px solid var(--primary);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(46,204,113,0.1);
        }

        .dashboard-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-left: 5px solid var(--primary);
        }

        /* Nature-inspired icons */
        .icon-lg {
            font-size: 2.5rem;
            margin-bottom: 15px;
            display: inline-block;
            width: 60px;
            height: 60px;
            line-height: 60px;
            border-radius: 50%;
            background: rgba(46,204,113,0.1);
            color: var(--primary);
            text-align: center;
        }

        /* Section titles with leaf motif */
        .section-title {
            font-size: 2rem;
            margin-bottom: 40px;
            color: var(--dark);
            position: relative;
            display: inline-block;
            font-weight: 600;
        }

        .section-title::after {
           
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.5rem;
        }

        /* Green buttons */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46,204,113,0.3);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46,204,113,0.4);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Eco badges */
        .badge-primary {
            background-color: var(--primary);
            margin-right: 5px;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.75rem;
            color: white;
        }

        /* Leafy section backgrounds */
        .bg-light {
            background-color: #f0f9f5 !important;
        }

        /* Sustainability callout */
        .save-food-callout {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 12px;
            padding: 30px;
            margin: 40px 0;
            text-align: center;
            box-shadow: 0 10px 30px rgba(46,204,113,0.2);
            border: 2px solid white;
        }

        /* Statistics with leaf icons */
        .stat-counter {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
            position: relative;
        }

        .stat-counter::before {
       
            position: absolute;
            left: -30px;
            top: 5px;
        }

        /* Green list items */
        .list-group-item {
            border: none;
            padding: 0.75rem 1.25rem 0.75rem 40px;
            position: relative;
            background: transparent;
        }

        .list-group-item::before {
            content: '✓';
            position: absolute;
            left: 15px;
            color: var(--primary);
            font-weight: bold;
            font-size: 1.2rem;
        }

        /* Food waste stats - leaf design */
        .waste-stat-box {
            background: white;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-bottom: 5px solid var(--primary);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .waste-stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(46,204,113,0.1);
        }

        .waste-stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            display: block;
            color: var(--primary);
            margin-bottom: 10px;
        }

        /* Testimonials with leaf border */
        .testimonial-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 3px solid white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        /* Calendar container */
        .calendar-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(46,204,113,0.2);
        }

        /* Footer styling */
        footer {
            background-color: var(--primary-dark);
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 80px 0;
            }
            .section-title {
                font-size: 1.8rem;
            }
        }
    </style>

</head>
<body>

<!-- Navigation -->
<?php include 'navbar.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="display-3 mb-4">Smart Meal Management</h1>
        <p class="lead mb-5">Reduce waste while accommodating all student needs</p>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="dashboard.php" class="btn btn-primary btn-lg px-5 py-3 mr-3">
                Go to Dashboard
            </a>
        <?php else: ?>
            <a href="register.php" class="btn btn-primary btn-lg px-5 py-3 mr-3">
                Student Sign Up
            </a>
            <a href="login.php" class="btn btn-outline-light btn-lg px-5 py-3">
                Login
            </a>
        <?php endif; ?>
    </div>
</section>

<!-- Food Waste Stats (New Section) -->
<section class="container py-4 my-4">
    <div class="row text-center">
        <div class="col-12 mb-4">
            <h2 class="section-title text-center">Campus Food Waste Impact</h2>
        </div>
        <div class="col-md-4">
            <div class="waste-stat-box">
                <span class="waste-stat-number">40%</span>
                <p>Average reduction in campus food waste</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="waste-stat-box">
                <span class="waste-stat-number">₹3.5L</span>
                <p>Monthly savings on food costs</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="waste-stat-box">
                <span class="waste-stat-number">2,500kg</span>
                <p>Food saved monthly by our system</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="container py-5 my-5">
    <h2 class="section-title text-center">Key Features</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="feature-card">
                <div class="card-body text-center p-4">
                    <div class="icon-lg">⏰</div>
                    <h3>Automated Reminders</h3>
                    <p>Get notifications before each meal to confirm your attendance</p>
                    <div class="mt-3">
                        <span class="badge badge-pill badge-primary">SMS</span>
                        <span class="badge badge-pill badge-primary">Email</span>
                        <span class="badge badge-pill badge-primary">App</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <div class="card-body text-center p-4">
                    <div class="icon-lg">🤖</div>
                    <h3>AI Predictions</h3>
                    <p>Smart forecasting of meal attendance to optimize food preparation</p>
                    <div class="mt-3">
                        <span class="badge badge-pill badge-primary">Machine Learning</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <div class="card-body text-center p-4">
                    <div class="icon-lg">📊</div>
                    <h3>Live Dashboard</h3>
                    <p>Real-time tracking of meal attendance for mess staff</p>
                    <div class="mt-3">
                        <span class="badge badge-pill badge-primary">Real-time</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Save Food Callout (New Section) -->
<section class="container py-3">
    <div class="save-food-callout">
        <h3>Every Meal Update Helps Save Food</h3>
        <p class="mb-0">By simply marking your attendance, you directly contribute to reducing food waste on campus!</p>
    </div>
</section>

<!-- How It Works -->
<section class="py-5 my-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">How It Works</h2>
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3><span class="icon-lg">1</span> Plan Your Meals</h3>
                    <p>Use our simple calendar interface to mark which meals you'll attend or skip. No strict limits - we understand needs vary.</p>
                    <img src="https://media.istockphoto.com/id/1472185863/photo/desk-calendar-on-table-with-blurred-bokeh-background-appointment-and-business-meeting-concept.jpg?b=1&s=170667a&w=0&k=20&c=pphUVYXa-0A3uANaP1xBrhsP5VbbjYs7ocFLsjPG-Mk=" alt="Meal Calendar"  style="width: 200px;">
                </div>
            </div>
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h3><span class="icon-lg">2</span> Get Reminders</h3>
                    <p>Receive automated notifications before each meal to confirm your plans. Never forget to update your status.</p>
                    <div class="position-relative d-inline-block mt-3">
                        <img src="https://t4.ftcdn.net/jpg/00/26/99/69/360_F_26996933_aHDs1FQ9TXvHSEC8U5bZwWEiimNmDzNd.jpg" alt="Notification" style="width: 200px;">
                        
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Special Cases Section -->
<section class="container py-5 my-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="section-title">Accommodating Special Needs</h2>
            <p>We understand that students may need to be away for extended periods due to:</p>
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item border-0 pl-0">Illness or medical treatment</li>
                <li class="list-group-item border-0 pl-0">Family emergencies</li>
                <li class="list-group-item border-0 pl-0">Academic trips</li>
                <li class="list-group-item border-0 pl-0">Personal circumstances</li>
            </ul>
            <p>Our system has no arbitrary skip limits. Instead, we use intelligent forecasting to accommodate all situations while minimizing waste.</p>
        </div>
        <div class="col-md-6">
            <img src="https://media.istockphoto.com/photos/down-syndrome-boy-with-headset-doing-thumbs-up-picture-id535401785?k=6&m=535401785&s=612x612&w=0&h=ns4LO7u6fC6wpvFqHmAq2mevKg76nyc1zAt9E8k1Qf4=" alt="Special Needs Accommodation" class="img-fluid rounded">
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 my-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">What Our Community Says</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="media">
                        <img src="images/student1.jpg" class="testimonial-img align-self-start">
                        <div class="media-body">
                            <p>"When I was sick for 3 weeks, I didn't have to worry about meal penalties. The system just adjusted."</p>
                            <p class="font-weight-bold mb-0">— Priya, 2nd Year</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="media">
                        <img src="images/mess-staff.jpg" class="testimonial-img align-self-start">
                        <div class="media-body">
                            <p>"The AI predictions help us reduce waste by 40% while always having enough food."</p>
                            <p class="font-weight-bold mb-0">— Mr. Sharma, Mess Manager</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="media">
                        <img src="images/student2.jpg" class="testimonial-img align-self-start">
                        <div class="media-body">
                            <p>"The reminders are so convenient - I can update my status right from the notification!"</p>
                            <p class="font-weight-bold mb-0">— Rahul, 3rd Year</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="section-title">Ready to Join?</h2>
        <p class="lead mb-4">Help create a more sustainable campus dining system</p>
        <div class="stat-counter mb-3">40% Food Waste Reduction</div>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="dashboard.php" class="btn btn-primary btn-lg px-5 py-3">
                Go to Your Dashboard
            </a>
        <?php else: ?>
            <a href="register.php" class="btn btn-primary btn-lg px-5 py-3 mr-3">
                Register Now
            </a>
            <a href="login.php" class="btn btn-outline-primary btn-lg px-5 py-3">
                Login
            </a>
        <?php endif; ?>
    </div>
</section>

<footer class="container py-5">
    <?php include 'footer.php'; ?>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
// Calendar initialization would go here
// Notification system would be implemented with service workers
// Real-time dashboard would use WebSockets or similar technology
</script>

</body>
</html>