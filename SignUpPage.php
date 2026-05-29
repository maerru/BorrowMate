<?php
session_start();

$fullNameValue = "";
$contactInfoValue = "";
$emailValue = "";
$addressValue = "";
$usernameValue = "";

if (isset($_POST['btnsignup'])) {
    $fullNameValue = $_POST['fullName'];
    $contactInfoValue = $_POST['contactInfo'];
    $emailValue = $_POST['email'];
    $addressValue = $_POST['address'];
    $usernameValue = $_POST['username'];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorrowMate Sign Up</title>
    <link rel="icon" type="image/png" href="images/BorrowMateLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/SignUpPage.css?v=2">
</head>
<body>

<div class="container signup-container">
    <div class="row signup-box">

        <div class="col-md-5 left-box">
            <div class="logo-area">
                <img src="images/BorrowMateLogo.png" class="side-logo">
                <span class="side-logo-text">BorrowMate</span>
            </div>

            <div class="welcome-area text-center">
                <p class="small-text">Start your journey with us</p>
                <h1>SIGN UP</h1>
                <div class="line"></div>
                <p class="side-description">
                    Create your BorrowMate account and apply for loans with simple tracking and secure verification.
                </p>
            </div>
        </div>

        <div class="col-md-7 right-box">
            <div class="form-box">
                <h3>Create Account</h3>
                <p class="form-description">
                    Fill out the form below to register as a BorrowMate member.
                </p>

                <form action="SignUpPage.php" method="post">

                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="fullName" class="form-control input-box" placeholder="Full Name" value="<?php echo htmlspecialchars($fullNameValue); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="contactInfo" class="form-control input-box" placeholder="Contact Information" value="<?php echo htmlspecialchars($contactInfoValue); ?>" required>
                        </div>

                        <div class="col">
                            <input type="email" name="email" class="form-control input-box" placeholder="Email Address" value="<?php echo htmlspecialchars($emailValue); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="address" class="form-control input-box" placeholder="Address" value="<?php echo htmlspecialchars($addressValue); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="username" class="form-control input-box" placeholder="Username" value="<?php echo htmlspecialchars($usernameValue); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="password" name="password" class="form-control input-box" placeholder="Password" required>
                        </div>

                        <div class="col">
                            <input type="password" name="confirmPassword" class="form-control input-box" placeholder="Confirm Password" required>
                        </div>
                    </div>

                    <input type="submit" name="btnsignup" value="SIGN UP" class="signup-btn form-control">

                </form>

                <div class="text-center mt-4">
                    <span class="small-label">Already have an account?</span>
                    <a href="LoginPage.php" class="login-link">Log In</a>
                </div>

                <div class="text-center mt-2">
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
require_once "includes/verifyotpemail.php";

if (isset($_POST['btnsignup'])) {

    $fullName = $_POST['fullName'];
    $contactInfo = $_POST['contactInfo'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $confirmPassword = md5($_POST['confirmPassword']);

    $role = "Member";
    $status = "Pending";
    $otp = rand(100000, 999999);

    if ($password != $confirmPassword) {

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'Password and confirm password do not match.',
                confirmButtonColor: '#723531'
            });
        </script>
        ";

    } else {

        $checkSql = "
            SELECT * FROM tbl_user
            WHERE user_name = '".$username."'
            OR user_email = '".$email."'
        ";

        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Account Already Exists',
                    text: 'Username or email is already used.',
                    confirmButtonColor: '#723531'
                });
            </script>
            ";

        } else {

            $insertUserSql = "
                INSERT INTO tbl_user(user_name, user_role, user_pass, user_email, user_otp, user_status)
                VALUES ('$username', '$role', '$password', '$email', '$otp', '$status')
            ";

            $userResult = $conn->query($insertUserSql);

            if ($userResult == true) {

                $userId = $conn->insert_id;

                $_SESSION['otp_user_id'] = $userId;

                $insertMemberSql = "
                    INSERT INTO tbl_member(user_id, member_name, contact_information, member_address)
                    VALUES ('$userId', '$fullName', '$contactInfo', '$address')
                ";

                $memberResult = $conn->query($insertMemberSql);

                if ($memberResult == true) {

                    $logSql = "
                        INSERT INTO tbl_logs(user_id, log_msg, log_date)
                        VALUES ('$userId', 'Registered account and pending OTP verification', NOW())
                    ";

                    $conn->query($logSql);

                    send_verification($fullName, $email, $otp);

                    echo "
                    <script>
                        Swal.fire({
                            title: 'Registration Successful!',
                            text: 'Please check your email for the OTP.',
                            icon: 'success',
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
                            title: 'Member Record Failed',
                            text: 'Account was created but member record was not saved.',
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
                        title: 'Registration Failed',
                        text: 'Something went wrong while creating your account.',
                        confirmButtonColor: '#723531'
                    });
                </script>
                ";

            }
        }
    }
}

?>