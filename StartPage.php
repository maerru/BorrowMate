<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorrowMate</title>
    <link rel="icon" type="image/png" href="BorrowMateLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="StartPage.css">
</head>
<body>

<nav class="navbar navbar-expand-lg nav-box">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="StartPage.php">
            <img src="BorrowMateLogo.png" class="nav-logo">
            <span class="logo-text">BorrowMate</span>
        </a>

        <div>
            <a href="HomePage.php" class="nav-link-text">Home</a>
            <a href="LoginPage.php" class="nav-link-text">Login</a>
            <a href="SignUpPage.php" class="nav-link-text">Sign Up</a>
        </div>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <div class="main-box text-center p-5">

        <div class="row">
            <div class="col">
                <img src="BorrowMateFullLogoTransparent.png" class="main-logo">

                <p class="tagline mt-4">
                    Your loan companion, every step of the way.
                </p>

                <p class="description mt-4">
                    Apply for loans, check your loan status, manage payments, and keep records organized in one system.
                </p>

                <div class="mt-5">
                    <a href="LoginPage.php" class="login-btn me-3">Log In</a>
                    <a href="SignUpPage.php" class="signup-btn me-3">Sign Up</a>
                    <a href="HomePage.php" class="explore-link">Explore BorrowMate</a>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-4">
            <div class="col">
                <div class="info-box">
                    <h5>Apply Loan</h5>
                    <p>Members can submit loan applications easily.</p>
                </div>
            </div>

            <div class="col">
                <div class="info-box">
                    <h5>Loan Approval</h5>
                    <p>Employees can review and approve member loans.</p>
                </div>
            </div>

            <div class="col">
                <div class="info-box">
                    <h5>Payment Records</h5>
                    <p>Track payment history and outstanding balances.</p>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <div class="bottom-box">
                    <h4>Easy loan management for Admins, Employees, and Members.</h4>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>