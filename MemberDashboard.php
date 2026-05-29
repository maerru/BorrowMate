<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorrowMate Member Dashboard</title>
    <link rel="icon" type="image/png" href="images/BorrowMateLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/MemberDashboard.css?v=2">
</head>
<body>

<nav class="navbar navbar-expand-lg member-navbar">
    <div class="container-fluid nav-container">
        <a class="navbar-brand d-flex align-items-center" href="#dashboard">
            <img src="images/BorrowMateLogo.png" class="nav-logo">
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
                        This page is for the Member role. Members can apply for loans, view loan status, and check payment records.
                    </p>
                    <span class="sample-badge">MEMBER DASHBOARD</span>
                </div>
            </section>

            <section class="section-box" id="applyLoan">
                <h1>Apply Loan</h1>
                <p>Fill out this form to apply for a loan.</p>

                <form action="MemberDashboard.php#applyLoan" method="post" class="mt-4">
                    <div class="row mb-4">
                        <div class="col">
                            <label>Loan Type</label>
                            <select name="loanTypeId" class="form-control modal-input" required>
                                <option value="" selected disabled>-- Select Loan Type --</option>

                                <?php

                                require_once "includes/db_Conn.php";

                                $loanTypeSql = "SELECT * FROM tbl_loanType ORDER BY loan_type_name ASC";
                                $loanTypeResult = $conn->query($loanTypeSql);

                                if ($loanTypeResult->num_rows > 0) {

                                    foreach ($loanTypeResult as $loanTypeField) {

                                        echo "<option value='".$loanTypeField['loan_type_id']."'>".$loanTypeField['loan_type_name']." - ".$loanTypeField['loan_type_rate']."%</option>";

                                    }

                                }

                                ?>
                            </select>
                        </div>

                        <div class="col">
                            <label>Loan Amount</label>
                            <input type="number" step="0.01" name="loanAmount" class="form-control modal-input" required>
                        </div>

                        <div class="col">
                            <label>Loan Term</label>
                            <input type="number" name="loanTerm" class="form-control modal-input" placeholder="Months" required>
                        </div>
                    </div>

                    <input type="submit" name="btnApplyLoan" value="Submit Loan Application" class="member-submit-btn">
                </form>
            </section>

            <section class="section-box" id="myLoans">
                <div class="section-title-row">
                    <div>
                        <h1>My Loans</h1>
                        <p>This section shows your loan applications and loan status.</p>
                    </div>
                </div>

                <form action="MemberDashboard.php#myLoans" method="post">
                    <div class="row mt-4 mb-4">
                        <div class="col-md-10">
                            <input type="search" name="searchMyLoans" class="form-control search-box" placeholder="Search my loans">
                        </div>

                        <div class="col-md-2">
                            <input type="submit" name="btnSearchMyLoans" value="Search" class="search-btn form-control">
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover borrowmate-table">
                        <tr>
                            <th>Loan ID</th>
                            <th>Loan Type</th>
                            <th>Loan Amount</th>
                            <th>Interest Rate</th>
                            <th>Term</th>
                            <th>Interest Amount</th>
                            <th>Total Amount</th>
                            <th>Monthly Payment</th>
                            <th>Date Applied</th>
                            <th>Date Approved</th>
                            <th>Date Disbursed</th>
                            <th>Outstanding Balance</th>
                            <th>Status</th>
                        </tr>

                        <?php

                        $currentUserId = "";

                        if (isset($_SESSION['user_id'])) {
                            $currentUserId = $_SESSION['user_id'];
                        }

                        $memberSql = "
                            SELECT * FROM tbl_member
                            WHERE user_id = '".$currentUserId."'
                        ";

                        $memberResult = $conn->query($memberSql);

                        if ($memberResult->num_rows == 1) {

                            $memberField = $memberResult->fetch_assoc();
                            $memberId = $memberField['member_id'];

                            if (isset($_POST['btnSearchMyLoans'])) {

                                $searchMyLoans = $_POST['searchMyLoans'];
                                $searchInput = trim($searchMyLoans);

                                if ($searchInput != NULL && $searchInput != "") {

                                    $displayLoanSql = "
                                        SELECT tbl_loan.*, tbl_loanType.loan_type_name
                                        FROM tbl_loan
                                        INNER JOIN tbl_loanType ON tbl_loan.loan_type_id = tbl_loanType.loan_type_id
                                        WHERE tbl_loan.borrower_id = '".$memberId."'
                                        AND (
                                            tbl_loan.loan_id LIKE '%".$searchInput."%'
                                            OR tbl_loanType.loan_type_name LIKE '%".$searchInput."%'
                                            OR tbl_loan.loan_amount LIKE '%".$searchInput."%'
                                            OR tbl_loan.interest_rate LIKE '%".$searchInput."%'
                                            OR tbl_loan.loan_status LIKE '%".$searchInput."%'
                                            OR tbl_loan.date_applied LIKE '%".$searchInput."%'
                                        )
                                        ORDER BY tbl_loan.date_applied DESC
                                    ";

                                } else {

                                    $displayLoanSql = "
                                        SELECT tbl_loan.*, tbl_loanType.loan_type_name
                                        FROM tbl_loan
                                        INNER JOIN tbl_loanType ON tbl_loan.loan_type_id = tbl_loanType.loan_type_id
                                        WHERE tbl_loan.borrower_id = '".$memberId."'
                                        ORDER BY tbl_loan.date_applied DESC
                                    ";

                                }

                            } else {

                                $displayLoanSql = "
                                    SELECT tbl_loan.*, tbl_loanType.loan_type_name
                                    FROM tbl_loan
                                    INNER JOIN tbl_loanType ON tbl_loan.loan_type_id = tbl_loanType.loan_type_id
                                    WHERE tbl_loan.borrower_id = '".$memberId."'
                                    ORDER BY tbl_loan.date_applied DESC
                                ";

                            }

                            $loanResult = $conn->query($displayLoanSql);

                            if ($loanResult->num_rows > 0) {

                                foreach ($loanResult as $loanField) {

                                    $termInYears = $loanField['loan_term'] / 12;
                                    $interestAmount = $loanField['loan_amount'] * ($loanField['interest_rate'] / 100) * $termInYears;
                                    $totalAmount = $loanField['loan_amount'] + $interestAmount;
                                    $monthlyPayment = $totalAmount / $loanField['loan_term'];

                                    echo "<tr>";
                                    echo "<td>".$loanField['loan_id']."</td>";
                                    echo "<td>".$loanField['loan_type_name']."</td>";
                                    echo "<td>".number_format($loanField['loan_amount'], 2)."</td>";
                                    echo "<td>".$loanField['interest_rate']."%</td>";
                                    echo "<td>".$loanField['loan_term']." months</td>";
                                    echo "<td>".number_format($interestAmount, 2)."</td>";
                                    echo "<td>".number_format($totalAmount, 2)."</td>";
                                    echo "<td>".number_format($monthlyPayment, 2)."</td>";
                                    echo "<td>".$loanField['date_applied']."</td>";
                                    echo "<td>".$loanField['date_approved']."</td>";
                                    echo "<td>".$loanField['date_disbursed']."</td>";
                                    echo "<td>".number_format($loanField['outstanding_balance'], 2)."</td>";
                                    echo "<td>".$loanField['loan_status']."</td>";
                                    echo "</tr>";

                                }

                            } else {

                                echo "<tr>";
                                echo "<td colspan='13' class='text-center'>No loans found</td>";
                                echo "</tr>";

                            }

                        } else {

                            echo "<tr>";
                            echo "<td colspan='13' class='text-center'>No member record found</td>";
                            echo "</tr>";

                        }

                        ?>
                    </table>
                </div>
            </section>

            <section class="section-box" id="myPayments">
                <div class="section-title-row">
                    <div>
                        <h1>My Payments</h1>
                        <p>This section shows your payment records.</p>
                    </div>
                </div>

                <form action="MemberDashboard.php#myPayments" method="post">
                    <div class="row mt-4 mb-4">
                        <div class="col-md-10">
                            <input type="search" name="searchMyPayments" class="form-control search-box" placeholder="Search my payments">
                        </div>

                        <div class="col-md-2">
                            <input type="submit" name="btnSearchMyPayments" value="Search" class="search-btn form-control">
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover borrowmate-table">
                        <tr>
                            <th>Payment ID</th>
                            <th>Loan Type</th>
                            <th>Loan Amount</th>
                            <th>Payment Amount</th>
                            <th>Payment Date</th>
                        </tr>

                        <?php

                        if (isset($_SESSION['user_id'])) {

                            $memberPaymentSql = "
                                SELECT * FROM tbl_member
                                WHERE user_id = '".$_SESSION['user_id']."'
                            ";

                            $memberPaymentResult = $conn->query($memberPaymentSql);

                            if ($memberPaymentResult->num_rows == 1) {

                                $memberPaymentField = $memberPaymentResult->fetch_assoc();
                                $memberPaymentId = $memberPaymentField['member_id'];

                                if (isset($_POST['btnSearchMyPayments'])) {

                                    $searchMyPayments = $_POST['searchMyPayments'];
                                    $searchInput = trim($searchMyPayments);

                                    if ($searchInput != NULL && $searchInput != "") {

                                        $displayPaymentSql = "
                                            SELECT tbl_payment.*, tbl_loan.loan_amount, tbl_loanType.loan_type_name
                                            FROM tbl_payment
                                            INNER JOIN tbl_loan ON tbl_payment.loan_id = tbl_loan.loan_id
                                            INNER JOIN tbl_loanType ON tbl_loan.loan_type_id = tbl_loanType.loan_type_id
                                            WHERE tbl_loan.borrower_id = '".$memberPaymentId."'
                                            AND (
                                                tbl_payment.payment_id LIKE '%".$searchInput."%'
                                                OR tbl_loanType.loan_type_name LIKE '%".$searchInput."%'
                                                OR tbl_loan.loan_amount LIKE '%".$searchInput."%'
                                                OR tbl_payment.payment_amount LIKE '%".$searchInput."%'
                                                OR tbl_payment.payment_date LIKE '%".$searchInput."%'
                                            )
                                            ORDER BY tbl_payment.payment_date DESC
                                        ";

                                    } else {

                                        $displayPaymentSql = "
                                            SELECT tbl_payment.*, tbl_loan.loan_amount, tbl_loanType.loan_type_name
                                            FROM tbl_payment
                                            INNER JOIN tbl_loan ON tbl_payment.loan_id = tbl_loan.loan_id
                                            INNER JOIN tbl_loanType ON tbl_loan.loan_type_id = tbl_loanType.loan_type_id
                                            WHERE tbl_loan.borrower_id = '".$memberPaymentId."'
                                            ORDER BY tbl_payment.payment_date DESC
                                        ";

                                    }

                                } else {

                                    $displayPaymentSql = "
                                        SELECT tbl_payment.*, tbl_loan.loan_amount, tbl_loanType.loan_type_name
                                        FROM tbl_payment
                                        INNER JOIN tbl_loan ON tbl_payment.loan_id = tbl_loan.loan_id
                                        INNER JOIN tbl_loanType ON tbl_loan.loan_type_id = tbl_loanType.loan_type_id
                                        WHERE tbl_loan.borrower_id = '".$memberPaymentId."'
                                        ORDER BY tbl_payment.payment_date DESC
                                    ";

                                }

                                $paymentResult = $conn->query($displayPaymentSql);

                                if ($paymentResult->num_rows > 0) {

                                    foreach ($paymentResult as $paymentField) {

                                        echo "<tr>";
                                        echo "<td>".$paymentField['payment_id']."</td>";
                                        echo "<td>".$paymentField['loan_type_name']."</td>";
                                        echo "<td>".number_format($paymentField['loan_amount'], 2)."</td>";
                                        echo "<td>".number_format($paymentField['payment_amount'], 2)."</td>";
                                        echo "<td>".$paymentField['payment_date']."</td>";
                                        echo "</tr>";

                                    }

                                } else {

                                    echo "<tr>";
                                    echo "<td colspan='5' class='text-center'>No payments found</td>";
                                    echo "</tr>";

                                }

                            } else {

                                echo "<tr>";
                                echo "<td colspan='5' class='text-center'>No member record found</td>";
                                echo "</tr>";

                            }
                        }

                        ?>
                    </table>
                </div>
            </section>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

require_once "includes/db_Conn.php";

if (isset($_POST['btnApplyLoan'])) {

    $loanTypeId = $_POST['loanTypeId'];
    $loanAmount = $_POST['loanAmount'];
    $loanTerm = $_POST['loanTerm'];

    $memberCheckSql = "
        SELECT * FROM tbl_member
        WHERE user_id = '".$_SESSION['user_id']."'
    ";

    $memberCheckResult = $conn->query($memberCheckSql);

    if ($memberCheckResult->num_rows == 1) {

        $memberCheckField = $memberCheckResult->fetch_assoc();
        $borrowerId = $memberCheckField['member_id'];

        $loanTypeCheckSql = "
            SELECT * FROM tbl_loanType
            WHERE loan_type_id = '".$loanTypeId."'
        ";

        $loanTypeCheckResult = $conn->query($loanTypeCheckSql);
        $loanTypeCheckField = $loanTypeCheckResult->fetch_assoc();

        $interestRate = $loanTypeCheckField['loan_type_rate'];

        $termInYears = $loanTerm / 12;
        $interestAmount = $loanAmount * ($interestRate / 100) * $termInYears;
        $totalAmount = $loanAmount + $interestAmount;
        $outstandingBalance = $totalAmount;

        $insertLoanSql = "
            INSERT INTO tbl_loan(borrower_id, loan_type_id, loan_amount, interest_rate, loan_term, date_applied, date_approved, date_disbursed, outstanding_balance, loan_status)
            VALUES ('$borrowerId', '$loanTypeId', '$loanAmount', '$interestRate', '$loanTerm', NOW(), NULL, NULL, '$outstandingBalance', 'Pending')
        ";

        $insertLoanResult = $conn->query($insertLoanSql);

        if ($insertLoanResult == true) {

            $loanId = $conn->insert_id;

            $logSql = "
                INSERT INTO tbl_logs(user_id, log_msg, log_date)
                VALUES ('".$_SESSION['user_id']."', 'Applied for loan ID: ".$loanId."', NOW())
            ";

            $conn->query($logSql);

            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Loan Application Submitted',
                    text: 'Your loan application has been submitted and is now pending approval.',
                    confirmButtonColor: '#723531'
                }).then(() => {
                    window.location.href = 'MemberDashboard.php#myLoans';
                });
            </script>
            ";

        } else {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Application Failed',
                    text: '".addslashes($conn->error)."',
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
                title: 'Member Record Missing',
                text: 'No member record is connected to your account.',
                confirmButtonColor: '#723531'
            });
        </script>
        ";

    }
}

?>