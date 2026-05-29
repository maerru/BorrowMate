<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorrowMate Login</title>
    <link rel="icon" type="image/png" href="images/BorrowMateLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/LoginPage.css">
</head>
<body>

<div class="container login-container">
    <div class="row login-box">

        <div class="col-md-6 left-box">
            <div class="logo-area">
                <img src="images/BorrowMateLogo.png" class="side-logo">
                <span class="side-logo-text">BorrowMate</span>
            </div>

            <div class="welcome-area text-center">
                <p class="small-text">Nice to see you again</p>
                <h1>WELCOME BACK</h1>
                <div class="line"></div>
                <p class="side-description">
                    Manage your loans, payments, and member records with ease.
                </p>
            </div>
        </div>

        <div class="col-md-6 right-box">
            <div class="form-box">
                <h3>Login Account</h3>
                <p class="form-description">
                    Enter your username and password to continue using BorrowMate.
                </p>

                <form action="LoginPage.php" method="post">

                    <div class="mb-3">
                        <input type="text" name="username" class="form-control input-box" placeholder="Username" required>
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password" class="form-control input-box" placeholder="Password" required>
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <input type="checkbox" name="rememberme">
                            <label class="small-label">Keep me signed in</label>
                        </div>

                        <div class="col text-end">
                            <a href="SignUpPage.php" class="member-link">Not a member?</a>
                        </div>
                    </div>

                    <input type="submit" name="btnlogin" value="LOG IN" class="login-btn form-control">

                </form>

                <div class="text-center mt-4">
                    <a href="StartPage.php" class="back-link">Back to Start Page</a>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

require_once "includes/db_Conn.php";

if (isset($_POST['btnlogin'])) {

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $loginSql = "
        SELECT * FROM tbl_user
        WHERE user_name = '".$username."'
        AND user_pass = '".$password."'
        AND user_status = 'Active'
    ";

    $result = $conn->query($loginSql);

    if ($result->num_rows == 1) {

        $field = $result->fetch_assoc();

        $_SESSION['user_id'] = $field['user_id'];
        $_SESSION['user_name'] = $field['user_name'];
        $_SESSION['user_role'] = $field['user_role'];
        $_SESSION['user_email'] = $field['user_email'];

        $logSql = "
            INSERT INTO tbl_logs(user_id, log_msg, log_date)
            VALUES ('".$_SESSION['user_id']."', 'Logged in', NOW())
        ";

        $conn->query($logSql);

        if ($_SESSION['user_role'] == "Admin") {

            echo "
            <script>
                window.location.href = 'AdminDashboard.php';
            </script>
            ";

        } else if ($_SESSION['user_role'] == "Employee") {

            echo "
            <script>
                window.location.href = 'EmployeeDashboard.php';
            </script>
            ";

        } else if ($_SESSION['user_role'] == "Member") {

            echo "
            <script>
                window.location.href = 'MemberDashboard.php';
            </script>
            ";

        }

    } else {

        $checkSql = "
            SELECT * FROM tbl_user
            WHERE user_name = '".$username."'
            AND user_pass = '".$password."'
        ";

        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows == 1) {

            $pendingField = $checkResult->fetch_assoc();

            $_SESSION['otp_user_id'] = $pendingField['user_id'];

            echo "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Account Not Verified',
                    text: 'Please verify your account using the OTP sent to your email.',
                    confirmButtonColor: '#723531'
                }).then(() => {
                    window.location.href = 'OTPVerification.php';
                });
            </script>
            ";

        } else {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: 'Invalid username or password.',
                    confirmButtonColor: '#723531'
                });
            </script>
            ";

        }
    }
}

?>