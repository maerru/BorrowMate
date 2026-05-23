<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Dashboard</title>
    <link rel="icon" type="image/png" href="BorrowMateLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Dashboard.css">
</head>
<body>

<nav class="navbar navbar-expand-lg dashboard-navbar">
    <div class="container-fluid dashboard-nav-container">
        <a class="navbar-brand d-flex align-items-center" href="EmployeeDashboard.php">
            <img src="BorrowMateLogo.png" class="nav-logo">
            <span class="brand-text">BorrowMate</span>
        </a>

        <div class="d-flex align-items-center">
            <span class="user-name">
                <?php echo $_SESSION['user_name']; ?>
            </span>
        </div>
    </div>
</nav>

<div class="container dashboard-container">
    <div class="dashboard-box text-center">
        <h1>Employee Dashboard</h1>
        <p>Welcome back, <?php echo $_SESSION['user_name']; ?>.</p>
        <span class="role-badge">EMPLOYEE</span>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>