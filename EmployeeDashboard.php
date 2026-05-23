<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorrowMate Employee Dashboard</title>
    <link rel="icon" type="image/png" href="BorrowMateLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="EmployeeDashboard.css">
</head>
<body>

<nav class="navbar navbar-expand-lg employee-navbar">
    <div class="container-fluid nav-container">
        <a class="navbar-brand d-flex align-items-center" href="#dashboard">
            <img src="BorrowMateLogo.png" class="nav-logo">
            <span class="brand-text">BorrowMate</span>
        </a>

        <div class="user-box">
            <span class="user-role">Employee</span>
            <span class="user-name">
                <?php
                    if (isset($_SESSION['user_name'])) {
                        echo $_SESSION['user_name'];
                    } else {
                        echo "Employee User";
                    }
                ?>
            </span>
        </div>
    </div>
</nav>

<div class="container-fluid main-container">
    <div class="row">

        <div class="col-md-2 sidebar">
            <div class="sidebar-title">
                Employee Panel
            </div>

            <a href="#dashboard" class="sidebar-link active-link">Dashboard</a>
            <a href="#members" class="sidebar-link">Members</a>
            <a href="#loanTypes" class="sidebar-link">Loan Types</a>
            <a href="#loans" class="sidebar-link">Loans</a>
            <a href="#payments" class="sidebar-link">Payments</a>

            <div class="logout-area">
                <a href="Logout.php" class="logout-link">Log Out</a>
            </div>
        </div>

        <div class="col-md-10 content-area">

            <section class="section-box" id="dashboard">
                <h1>Employee Dashboard</h1>
                <p>Welcome to BorrowMate employee dashboard.</p>

                <div class="sample-card mt-4">
                    <h3>Employee Access</h3>
                    <p>
                        This page is for the Employee role. Employee can manage members, loan types, loans, and payments.
                    </p>
                    <span class="sample-badge">EMPLOYEE DASHBOARD</span>
                </div>
            </section>

            <section class="section-box" id="members">
                <h1>Members</h1>
                <p>This section will contain the members table.</p>

                <div class="placeholder-box">
                    Members table will be placed here.
                </div>
            </section>

            <section class="section-box" id="loanTypes">
                <h1>Loan Types</h1>
                <p>This section will contain the loan type table.</p>

                <div class="placeholder-box">
                    Loan types table will be placed here.
                </div>
            </section>

            <section class="section-box" id="loans">
                <h1>Loans</h1>
                <p>This section will contain the loans table and loan approval actions.</p>

                <div class="placeholder-box">
                    Loans table will be placed here.
                </div>
            </section>

            <section class="section-box" id="payments">
                <h1>Payments</h1>
                <p>This section will contain the payments table.</p>

                <div class="placeholder-box">
                    Payments table will be placed here.
                </div>
            </section>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>