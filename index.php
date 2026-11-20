<?php require 'auth.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MySQL Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-header {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1350&q=80') center/cover;
            height: 85vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand fw-bold" href="index.php">MySQL Task</a>
    <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav flex-wrap">
            <li class="nav-item"><a class="nav-link" href="q1.php">1. Salary > 20k</a></li>
            <li class="nav-item"><a class="nav-link" href="q2.php">2. By ID</a></li>
            <li class="nav-item"><a class="nav-link" href="q3.php">3. Orders Count</a></li>
            <li class="nav-item"><a class="nav-link" href="q4.php">4. Top Products</a></li>
            <li class="nav-item"><a class="nav-link" href="q5.php">5. Employees</a></li>
            <li class="nav-item"><a class="nav-link" href="q6.php">6. Search Name</a></li>
            <li class="nav-item"><a class="nav-link" href="q7.php">7. By City</a></li>
            <li class="nav-item"><a class="nav-link" href="q8.php">8. Qty Range</a></li>
            <li class="nav-item"><a class="nav-link" href="q9.php">9. Top 3 Rich</a></li>
            <li class="nav-item"><a class="nav-link" href="q10.php">10. Product Details</a></li>
            <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<header class="hero-header">
    <div>
        <h1 class="display-3 fw-bold">Welcome to MySQL</h1>
        <p class="lead">
    Hello, <?= htmlspecialchars($_SESSION['user_email'] ?? 'User') ?>!
    Choose any task from the navigation bar.
</p>
    </div>
</header>

</body>
</html>