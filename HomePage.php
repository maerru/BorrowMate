<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorrowMate Home</title>
    <link rel="icon" type="image/png" href="images/BorrowMateLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/HomePage.css?v=2">
</head>
<body>

<nav class="navbar navbar-expand-lg home-navbar">
    <div class="container nav-container">
        <a class="navbar-brand d-flex align-items-center" href="HomePage.php">
            <img src="images/BorrowMateLogo.png" class="nav-logo">
            <span class="brand-text">BorrowMate</span>
        </a>

        <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#homeNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="homeNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="StartPage.php" class="nav-link">Start</a>
                </li>

                <li class="nav-item">
                    <a href="#about" class="nav-link">About</a>
                </li>

                <li class="nav-item">
                    <a href="#process" class="nav-link">Process</a>
                </li>

                <li class="nav-item">
                    <a href="#loanTypes" class="nav-link">Loan Types</a>
                </li>

                <li class="nav-item">
                    <a href="LoginPage.php" class="nav-link">Login</a>
                </li>

                <li class="nav-item">
                    <a href="SignUpPage.php" class="nav-signup">Sign Up</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="container">
        <div class="hero-box text-center">
            <img src="images/BorrowMateFullLogoTransparent.png" class="hero-logo">

            <h1>Your loan companion, every step of the way.</h1>

            <p class="hero-text">
                BorrowMate is a web-based loaning system that helps members apply for loans,
                employees manage loan approvals, and admins monitor the whole system in one organized place.
            </p>

            <div class="hero-buttons">
                <a href="SignUpPage.php" class="main-btn">Apply Now</a>
                <a href="LoginPage.php" class="second-btn">Login Account</a>
            </div>
        </div>
    </div>
</section>

<section class="content-section" id="about">
    <div class="container">
        <div class="section-title text-center">
            <h2>What is BorrowMate?</h2>
            <p>
                BorrowMate is made to make loan applications, approvals, payments, and records easier to manage.
            </p>
        </div>

        <div class="row mt-5">
            <div class="col-md-4 mb-4">
                <div class="info-card">
                    <h3>For Members</h3>
                    <p>
                        Members can create an account, verify it through OTP, apply for loans,
                        view loan status, and check payment records.
                    </p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="info-card">
                    <h3>For Employees</h3>
                    <p>
                        Employees can manage members, add loan records, approve pending loans,
                        and record member payments.
                    </p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="info-card">
                    <h3>For Admins</h3>
                    <p>
                        Admins can manage users, members, loan types, loans, payments,
                        and view activity logs for system monitoring.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content-section light-section" id="process">
    <div class="container">
        <div class="section-title text-center">
            <h2>How the Loan Process Works</h2>
            <p>
                BorrowMate keeps the loan process simple and easy to follow.
            </p>
        </div>

        <div class="row mt-5">
            <div class="col-md-3 mb-4">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Register</h3>
                    <p>Create a member account and verify it using the OTP sent to your email.</p>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Apply</h3>
                    <p>Choose a loan type, enter your loan amount, and set your loan term.</p>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Approval</h3>
                    <p>An employee reviews and approves the loan application.</p>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h3>Payment</h3>
                    <p>Payments are recorded and the outstanding balance is updated.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content-section" id="loanTypes">
    <div class="container">
        <div class="section-title text-center">
            <h2>Available Loan Types</h2>
            <p>
                These are the sample loan types currently used in BorrowMate.
            </p>
        </div>

        <div class="row mt-5">
            <div class="col-md-4 mb-4">
                <div class="loan-card">
                    <h3>Educational Loan</h3>
                    <p class="rate-text">3% Annual Rate</p>
                    <p>
                        A loan for tuition, school fees, and other educational needs.
                    </p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="loan-card">
                    <h3>Emergency Loan</h3>
                    <p class="rate-text">5% Annual Rate</p>
                    <p>
                        A loan for urgent financial needs and emergency expenses.
                    </p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="loan-card">
                    <h3>Gadget Loan</h3>
                    <p class="rate-text">4% Annual Rate</p>
                    <p>
                        A loan for gadgets, devices, and technology-related needs.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content-section light-section" id="calculation">
    <div class="container">
        <div class="section-title text-center">
            <h2>Loan Computation</h2>
            <p>
                BorrowMate uses a simple loan computation to calculate the interest, total amount, and monthly payment.
            </p>
        </div>

        <div class="formula-box mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h3>Formula</h3>

                    <p><strong>T = months / 12</strong></p>
                    <p><strong>Interest = Principal Amount × Interest Rate × T</strong></p>
                    <p><strong>Total Amount = Principal Amount + Interest</strong></p>
                    <p><strong>Monthly Payment = Total Amount / Loan Term</strong></p>
                </div>

                <div class="col-md-6">
                    <h3>Example</h3>

                    <p>Loan Amount: <strong>10,000</strong></p>
                    <p>Interest Rate: <strong>3%</strong></p>
                    <p>Loan Term: <strong>6 months</strong></p>

                    <p class="example-result">
                        Total Amount: 10,150<br>
                        Monthly Payment: 1,691.66
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="cta-box text-center">
            <h2>Ready to start with BorrowMate?</h2>
            <p>
                Create an account, verify your email, and start applying for loans with ease.
            </p>

            <div class="hero-buttons">
                <a href="SignUpPage.php" class="main-btn">Create Account</a>
                <a href="LoginPage.php" class="second-btn">Login</a>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <p>BorrowMate © 2026 | Your loan companion, every step of the way.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>