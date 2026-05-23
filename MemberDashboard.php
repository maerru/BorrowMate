<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorrowMate Member Dashboard</title>
    <link rel="icon" type="image/png" href="BorrowMateLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="MemberDashboard.css">
</head>
<body>

<nav class="navbar navbar-expand-lg member-navbar">
    <div class="container-fluid nav-container">
        <a class="navbar-brand d-flex align-items-center" href="#dashboard">
            <img src="BorrowMateLogo.png" class="nav-logo">
            <span class="brand-text">BorrowMate</span>
        </a>

        <div class="user-box">
            <span class="user-role">Member</span>
            <span class="user-name">
                <?php
                    if (isset($_SESSION['user_name'])) {
                        echo $_SESSION['user_name'];
                    } else {
                        echo "Member User";
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
                Member Panel
            </div>

            <a href="#dashboard" class="sidebar-link active-link">Dashboard</a>
            <a href="#applyLoan" class="sidebar-link">Apply Loan</a>
            <a href="#myLoans" class="sidebar-link">My Loans</a>
            <a href="#myPayments" class="sidebar-link">My Payments</a>

            <div class="logout-area">
                <a href="Logout.php" class="logout-link">Log Out</a>
            </div>
        </div>

        <div class="col-md-10 content-area">

            <section class="section-box" id="dashboard">
                <h1>Member Dashboard</h1>
                <p>Welcome to BorrowMate member dashboard.</p>

                <div class="sample-card mt-4">
                    <h3>Member Access</h3>
                    <p>
                        This page is for the Member role. Members can apply for loans, view their loan status, and check their payments.
                    </p>
                    <span class="sample-badge">MEMBER DASHBOARD</span>
                </div>
            </section>

            <section class="section-box" id="applyLoan">
                <h1>Apply Loan</h1>
                <p>This section will contain the loan application form.</p>

                <div class="placeholder-box">
                    Loan application form will be placed here.
                </div>
            </section>

            <section class="section-box" id="myLoans">
                <h1>My Loans</h1>
                <p>This section will show the member's own loan status.</p>

                <div class="placeholder-box">
                    Member loan status table will be placed here.
                </div>
            </section>

            <section class="section-box" id="myPayments">
                <h1>My Payments</h1>
                <p>This section will show the member's payment records.</p>

                <div class="placeholder-box">
                    Member payment table will be placed here.
                </div>
            </section>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>