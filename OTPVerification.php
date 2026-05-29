<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorrowMate OTP Verification</title>
    <link rel="icon" type="image/png" href="images/BorrowMateLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/OTPVerification.css?v=2">
</head>
<body>

<div class="container otp-container">
    <div class="otp-box text-center">

        <div class="logo-area mb-4">
            <img src="images/BorrowMateLogo.png" class="otp-logo">
            <h2>BorrowMate</h2>
        </div>

        <h1>OTP Verification</h1>

        <p class="otp-text mt-3">
            One Time Password was sent to your email.
        </p>

        <p class="otp-small-text">
            Enter the OTP code below to activate your BorrowMate account.
        </p>

        <form action="OTPVerification.php" method="post" class="mt-4">

            <div class="mb-4">
                <input type="text" name="otp" class="form-control otp-input text-center" placeholder="Enter OTP Code" required>
            </div>

            <input type="submit" name="btnverify" value="VERIFY ACCOUNT" class="verify-btn form-control">

        </form>

        <hr class="mt-4 mb-4">

        <p class="otp-small-text">
            Did not receive the OTP?
        </p>

        <form action="OTPVerification.php" method="post">
            <input type="submit" name="btnresend" value="RESEND OTP" class="resend-btn form-control">
        </form>

        <div class="mt-4">
            <a href="LoginPage.php" class="back-link">Back to Login</a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

require_once "includes/db_Conn.php";
require_once "includes/verifyotpemail.php";

if (isset($_POST['btnverify'])) {

    $otp = $_POST['otp'];

    $otpSql = "
        SELECT * FROM tbl_user
        WHERE user_otp = '".$otp."'
        AND user_status = 'Pending'
    ";

    $result = $conn->query($otpSql);

    if ($result->num_rows == 1) {

        $otpField = $result->fetch_assoc();
        $verifiedUserId = $otpField['user_id'];

        $updateSql = "
            UPDATE tbl_user
            SET user_otp = NULL, user_status = 'Active'
            WHERE user_id = '".$verifiedUserId."'
        ";

        $updateResult = $conn->query($updateSql);

        if ($updateResult == true) {

            $logSql = "
                INSERT INTO tbl_logs(user_id, log_msg, log_date)
                VALUES ('$verifiedUserId', 'Verified account using OTP', NOW())
            ";

            $conn->query($logSql);

            unset($_SESSION['otp_user_id']);

            echo "
            <script>
                Swal.fire({
                    title: 'Account Verified!',
                    text: 'Your account is now active. You may now log in.',
                    icon: 'success',
                    confirmButtonColor: '#723531'
                }).then(() => {
                    window.location.href = 'LoginPage.php';
                });
            </script>
            ";

        } else {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Verification Failed',
                    text: 'Something went wrong while verifying your account.',
                    confirmButtonColor: '#723531'
                });
            </script>
            ";

        }

    } else {

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid OTP',
                text: 'Please enter the correct OTP code.',
                confirmButtonColor: '#723531'
            });
        </script>
        ";

    }
}

if (isset($_POST['btnresend'])) {

    if (isset($_SESSION['otp_user_id'])) {

        $otpUserId = $_SESSION['otp_user_id'];

        $checkUserSql = "
            SELECT * FROM tbl_user
            WHERE user_id = '".$otpUserId."'
            AND user_status = 'Pending'
        ";

        $checkUserResult = $conn->query($checkUserSql);

        if ($checkUserResult->num_rows == 1) {

            $userField = $checkUserResult->fetch_assoc();

            $userId = $userField['user_id'];
            $userName = $userField['user_name'];
            $userEmail = $userField['user_email'];
            $newOtp = rand(100000, 999999);

            $updateOtpSql = "
                UPDATE tbl_user
                SET user_otp = '".$newOtp."'
                WHERE user_id = '".$userId."'
            ";

            $updateOtpResult = $conn->query($updateOtpSql);

            if ($updateOtpResult == true) {

                send_verification($userName, $userEmail, $newOtp);

                $logSql = "
                    INSERT INTO tbl_logs(user_id, log_msg, log_date)
                    VALUES ('$userId', 'Resent OTP verification code', NOW())
                ";

                $conn->query($logSql);

                echo "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'OTP Sent',
                        text: 'A new OTP was sent to your registered email.',
                        confirmButtonColor: '#723531'
                    });
                </script>
                ";

            } else {

                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Resend Failed',
                        text: 'Something went wrong while generating a new OTP.',
                        confirmButtonColor: '#723531'
                    });
                </script>
                ";

            }

        } else {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Account Not Found',
                    text: 'No pending account was found for OTP resend.',
                    confirmButtonColor: '#723531'
                }).then(() => {
                    window.location.href = 'LoginPage.php';
                });
            </script>
            ";

        }

    } else {

        echo "
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Session Expired',
                text: 'Please log in again or register again to resend your OTP.',
                confirmButtonColor: '#723531'
            }).then(() => {
                window.location.href = 'LoginPage.php';
            });
        </script>
        ";

    }
}

?>