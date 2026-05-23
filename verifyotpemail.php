<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function send_verification($fullname, $email, $otp){

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        $mail->Username   = 'manoahlinuel.dane.cics@ust.edu.ph';
        $mail->Password   = 'hgoy iocl lvka pqop';

        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('manoahlinuel.dane.cics@ust.edu.ph', 'BorrowMate');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "BorrowMate OTP Verification";

        $mail->Body = '
        <div style="font-family: Arial, sans-serif; background-color: #e6e1d1; padding: 30px;">
            <div style="background-color: #f8f4ea; border: 3px solid #c1b3a2; border-radius: 15px; padding: 30px;">
                <h2 style="color: #723531;">Hello, '.$fullname.'</h2>

                <p style="color: #723531;">
                    Thank you for signing up at <strong>BorrowMate</strong>.
                </p>

                <p style="color: #723531;">
                    To complete your registration, please enter the OTP code below on the verification page.
                </p>

                <div style="background-color: #723531; color: #e6e1d1; padding: 18px; border-radius: 10px; text-align: center; font-size: 28px; font-weight: bold; letter-spacing: 5px;">
                    '.$otp.'
                </div>

                <p style="margin-top: 25px; color: #9f825b;">
                    Your loan companion, every step of the way.
                </p>

                <p style="color: #a8604a; font-size: 14px;">
                    — BorrowMate
                </p>
            </div>
        </div>
        ';

        $mail->send();

    } catch (Exception $e) {

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Email Failed!',
                text: 'OTP email could not be sent.',
                confirmButtonColor: '#723531'
            });
        </script>
        ";

    }
}

?>