<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorrowMate Employee Dashboard</title>
    <link rel="icon" type="image/png" href="images/BorrowMateLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/EmployeeDashboard.css">
</head>
<body>

<nav class="navbar navbar-expand-lg employee-navbar">
    <div class="container-fluid nav-container">
        <a class="navbar-brand d-flex align-items-center" href="#dashboard">
            <img src="images/BorrowMateLogo.png" class="nav-logo">
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
                        This page is for the Employee role. Employee can manage members, loan types, loans, loan approvals, and payments.
                    </p>
                    <span class="sample-badge">EMPLOYEE DASHBOARD</span>
                </div>
            </section>

            <section class="section-box" id="members">
                <div class="section-title-row">
                    <div>
                        <h1>Members</h1>
                        <p>This section contains the members table.</p>
                    </div>

                    <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                        Add Member
                    </button>
                </div>

                <form action="EmployeeDashboard.php#members" method="post">
                    <div class="row mt-4 mb-4">
                        <div class="col-md-10">
                            <input type="search" name="searchMembers" class="form-control search-box" placeholder="Search members">
                        </div>

                        <div class="col-md-2">
                            <input type="submit" name="btnSearchMembers" value="Search" class="search-btn form-control">
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover borrowmate-table">
                        <tr>
                            <th>Member ID</th>
                            <th>Username</th>
                            <th>Member Name</th>
                            <th>Contact Information</th>
                            <th>Address</th>
                        </tr>

                        <?php

                        require_once "includes/db_Conn.php";

                        if (isset($_POST['btnSearchMembers'])) {

                            $searchMembers = $_POST['searchMembers'];
                            $searchInput = trim($searchMembers);

                            if ($searchInput != NULL && $searchInput != "") {

                                $displayMemberSql = "
                                    SELECT tbl_member.*, tbl_user.user_name
                                    FROM tbl_member
                                    INNER JOIN tbl_user ON tbl_member.user_id = tbl_user.user_id
                                    WHERE tbl_member.member_id LIKE '%".$searchInput."%'
                                    OR tbl_user.user_name LIKE '%".$searchInput."%'
                                    OR tbl_member.member_name LIKE '%".$searchInput."%'
                                    OR tbl_member.contact_information LIKE '%".$searchInput."%'
                                    OR tbl_member.member_address LIKE '%".$searchInput."%'
                                ";

                            } else {

                                $displayMemberSql = "
                                    SELECT tbl_member.*, tbl_user.user_name
                                    FROM tbl_member
                                    INNER JOIN tbl_user ON tbl_member.user_id = tbl_user.user_id
                                ";

                            }

                        } else {

                            $displayMemberSql = "
                                SELECT tbl_member.*, tbl_user.user_name
                                FROM tbl_member
                                INNER JOIN tbl_user ON tbl_member.user_id = tbl_user.user_id
                            ";

                        }

                        $memberResult = $conn->query($displayMemberSql);

                        if ($memberResult->num_rows > 0) {

                            foreach ($memberResult as $memberField) {

                                echo "<tr>";
                                echo "<td>".$memberField['member_id']."</td>";
                                echo "<td>".$memberField['user_name']."</td>";
                                echo "<td>".$memberField['member_name']."</td>";
                                echo "<td>".$memberField['contact_information']."</td>";
                                echo "<td>".$memberField['member_address']."</td>";
                                echo "</tr>";

                            }

                        } else {

                            echo "<tr>";
                            echo "<td colspan='5' class='text-center'>No members found</td>";
                            echo "</tr>";

                        }

                        ?>
                    </table>
                </div>
            </section>

            <section class="section-box" id="loanTypes">
                <div class="section-title-row">
                    <div>
                        <h1>Loan Types</h1>
                        <p>This section contains the loan type table.</p>
                    </div>

                    <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#addLoanTypeModal">
                        Add Loan Type
                    </button>
                </div>

                <form action="EmployeeDashboard.php#loanTypes" method="post">
                    <div class="row mt-4 mb-4">
                        <div class="col-md-10">
                            <input type="search" name="searchLoanTypes" class="form-control search-box" placeholder="Search loan types">
                        </div>

                        <div class="col-md-2">
                            <input type="submit" name="btnSearchLoanTypes" value="Search" class="search-btn form-control">
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover borrowmate-table">
                        <tr>
                            <th>Loan Type ID</th>
                            <th>Loan Type Name</th>
                            <th>Description</th>
                        </tr>

                        <?php

                        if (isset($_POST['btnSearchLoanTypes'])) {

                            $searchLoanTypes = $_POST['searchLoanTypes'];
                            $searchInput = trim($searchLoanTypes);

                            if ($searchInput != NULL && $searchInput != "") {

                                $displayLoanTypeSql = "
                                    SELECT * FROM tbl_loanType
                                    WHERE loan_type_id LIKE '%".$searchInput."%'
                                    OR loan_type_name LIKE '%".$searchInput."%'
                                    OR loan_type_description LIKE '%".$searchInput."%'
                                ";

                            } else {

                                $displayLoanTypeSql = "SELECT * FROM tbl_loanType";

                            }

                        } else {

                            $displayLoanTypeSql = "SELECT * FROM tbl_loanType";

                        }

                        $loanTypeResult = $conn->query($displayLoanTypeSql);

                        if ($loanTypeResult->num_rows > 0) {

                            foreach ($loanTypeResult as $loanTypeField) {

                                echo "<tr>";
                                echo "<td>".$loanTypeField['loan_type_id']."</td>";
                                echo "<td>".$loanTypeField['loan_type_name']."</td>";
                                echo "<td>".$loanTypeField['loan_type_description']."</td>";
                                echo "</tr>";

                            }

                        } else {

                            echo "<tr>";
                            echo "<td colspan='3' class='text-center'>No loan types found</td>";
                            echo "</tr>";

                        }

                        ?>
                    </table>
                </div>
            </section>

            <section class="section-box" id="loans">
                <div class="section-title-row">
                    <div>
                        <h1>Loans</h1>
                        <p>This section contains the loans table and loan approval actions.</p>
                    </div>

                    <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#addLoanModal">
                        Add Loan
                    </button>
                </div>

                <form action="EmployeeDashboard.php#loans" method="post">
                    <div class="row mt-4 mb-4">
                        <div class="col-md-7">
                            <input type="search" name="searchLoans" class="form-control search-box" placeholder="Search loans">
                        </div>

                        <div class="col-md-3">
                            <select name="loanStatusSort" class="form-control search-box">
                                <option value="">All Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Paid">Paid</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <input type="submit" name="btnSearchLoans" value="Search" class="search-btn form-control">
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover borrowmate-table">
                        <tr>
                            <th>Loan ID</th>
                            <th>Borrower</th>
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
                            <th>Action</th>
                        </tr>

                        <?php

                        if (isset($_POST['btnSearchLoans'])) {

                            $searchLoans = $_POST['searchLoans'];
                            $loanStatusSort = $_POST['loanStatusSort'];
                            $searchInput = trim($searchLoans);

                            $displayLoanSql = "
                                SELECT tbl_loan.*, tbl_member.member_name, tbl_loanType.loan_type_name
                                FROM tbl_loan
                                INNER JOIN tbl_member ON tbl_loan.borrower_id = tbl_member.member_id
                                INNER JOIN tbl_loanType ON tbl_loan.loan_type_id = tbl_loanType.loan_type_id
                                WHERE 1
                            ";

                            if ($searchInput != NULL && $searchInput != "") {

                                $displayLoanSql .= "
                                    AND (
                                        tbl_loan.loan_id LIKE '%".$searchInput."%'
                                        OR tbl_member.member_name LIKE '%".$searchInput."%'
                                        OR tbl_loanType.loan_type_name LIKE '%".$searchInput."%'
                                        OR tbl_loan.loan_amount LIKE '%".$searchInput."%'
                                        OR tbl_loan.interest_rate LIKE '%".$searchInput."%'
                                        OR tbl_loan.loan_status LIKE '%".$searchInput."%'
                                    )
                                ";

                            }

                            if ($loanStatusSort != NULL && $loanStatusSort != "") {

                                $displayLoanSql .= " AND tbl_loan.loan_status = '".$loanStatusSort."'";

                            }

                            $displayLoanSql .= " ORDER BY tbl_loan.date_applied DESC";

                        } else {

                            $displayLoanSql = "
                                SELECT tbl_loan.*, tbl_member.member_name, tbl_loanType.loan_type_name
                                FROM tbl_loan
                                INNER JOIN tbl_member ON tbl_loan.borrower_id = tbl_member.member_id
                                INNER JOIN tbl_loanType ON tbl_loan.loan_type_id = tbl_loanType.loan_type_id
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
                                echo "<td>".$loanField['member_name']."</td>";
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

                                if ($loanField['loan_status'] == "Pending") {
                                    echo "<td>
                                            <form action='EmployeeDashboard.php#loans' method='post'>
                                                <input type='hidden' name='approveLoanId' value='".$loanField['loan_id']."'>
                                                <input type='submit' name='btnApproveLoan' value='Approve' class='table-action-btn'>
                                            </form>
                                          </td>";
                                } else {
                                    echo "<td>No action</td>";
                                }

                                echo "</tr>";

                            }

                        } else {

                            echo "<tr>";
                            echo "<td colspan='15' class='text-center'>No loans found</td>";
                            echo "</tr>";

                        }

                        ?>
                    </table>
                </div>
            </section>

            <section class="section-box" id="payments">
                <div class="section-title-row">
                    <div>
                        <h1>Payments</h1>
                        <p>This section contains the payments table.</p>
                    </div>

                    <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                        Add Payment
                    </button>
                </div>

                <form action="EmployeeDashboard.php#payments" method="post">
                    <div class="row mt-4 mb-4">
                        <div class="col-md-10">
                            <input type="search" name="searchPayments" class="form-control search-box" placeholder="Search payments">
                        </div>

                        <div class="col-md-2">
                            <input type="submit" name="btnSearchPayments" value="Search" class="search-btn form-control">
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover borrowmate-table">
                        <tr>
                            <th>Payment ID</th>
                            <th>Borrower</th>
                            <th>Loan Amount</th>
                            <th>Payment Amount</th>
                            <th>Payment Date</th>
                        </tr>

                        <?php

                        if (isset($_POST['btnSearchPayments'])) {

                            $searchPayments = $_POST['searchPayments'];
                            $searchInput = trim($searchPayments);

                            if ($searchInput != NULL && $searchInput != "") {

                                $displayPaymentSql = "
                                    SELECT tbl_payment.*, tbl_loan.loan_amount, tbl_member.member_name
                                    FROM tbl_payment
                                    INNER JOIN tbl_loan ON tbl_payment.loan_id = tbl_loan.loan_id
                                    INNER JOIN tbl_member ON tbl_loan.borrower_id = tbl_member.member_id
                                    WHERE tbl_payment.payment_id LIKE '%".$searchInput."%'
                                    OR tbl_member.member_name LIKE '%".$searchInput."%'
                                    OR tbl_loan.loan_amount LIKE '%".$searchInput."%'
                                    OR tbl_payment.payment_amount LIKE '%".$searchInput."%'
                                    OR tbl_payment.payment_date LIKE '%".$searchInput."%'
                                    ORDER BY tbl_payment.payment_date DESC
                                ";

                            } else {

                                $displayPaymentSql = "
                                    SELECT tbl_payment.*, tbl_loan.loan_amount, tbl_member.member_name
                                    FROM tbl_payment
                                    INNER JOIN tbl_loan ON tbl_payment.loan_id = tbl_loan.loan_id
                                    INNER JOIN tbl_member ON tbl_loan.borrower_id = tbl_member.member_id
                                    ORDER BY tbl_payment.payment_date DESC
                                ";

                            }

                        } else {

                            $displayPaymentSql = "
                                SELECT tbl_payment.*, tbl_loan.loan_amount, tbl_member.member_name
                                FROM tbl_payment
                                INNER JOIN tbl_loan ON tbl_payment.loan_id = tbl_loan.loan_id
                                INNER JOIN tbl_member ON tbl_loan.borrower_id = tbl_member.member_id
                                ORDER BY tbl_payment.payment_date DESC
                            ";

                        }

                        $paymentResult = $conn->query($displayPaymentSql);

                        if ($paymentResult->num_rows > 0) {

                            foreach ($paymentResult as $paymentField) {

                                echo "<tr>";
                                echo "<td>".$paymentField['payment_id']."</td>";
                                echo "<td>".$paymentField['member_name']."</td>";
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

                        ?>
                    </table>
                </div>
            </section>

        </div>
    </div>
</div>

<div class="modal fade" id="addMemberModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content add-modal">

            <div class="modal-header modal-title-box">
                <h5 class="modal-title">Add Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="EmployeeDashboard.php#members" method="post">
                <div class="modal-body">

                    <div class="mb-3">
                        <label>User Account</label>
                        <select name="memberUserId" class="form-control modal-input" required>
                            <option value="" selected disabled>-- Select User Account --</option>

                            <?php

                            $userMemberSql = "
                                SELECT * FROM tbl_user
                                WHERE user_role = 'Member'
                                AND user_id NOT IN (SELECT user_id FROM tbl_member)
                            ";

                            $userMemberResult = $conn->query($userMemberSql);

                            if ($userMemberResult->num_rows > 0) {

                                foreach ($userMemberResult as $userMemberField) {

                                    echo "<option value='".$userMemberField['user_id']."'>".$userMemberField['user_name']."</option>";

                                }

                            }

                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Member Name</label>
                        <input type="text" name="memberName" class="form-control modal-input" required>
                    </div>

                    <div class="mb-3">
                        <label>Contact Information</label>
                        <input type="text" name="contactInformation" class="form-control modal-input" required>
                    </div>

                    <div class="mb-3">
                        <label>Address</label>
                        <input type="text" name="memberAddress" class="form-control modal-input" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="submit" name="btnAddMember" value="Save Member" class="modal-save-btn">
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="addLoanTypeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content add-modal">

            <div class="modal-header modal-title-box">
                <h5 class="modal-title">Add Loan Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="EmployeeDashboard.php#loanTypes" method="post">
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Loan Type Name</label>
                        <input type="text" name="loanTypeName" class="form-control modal-input" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="loanTypeDescription" class="form-control modal-input" rows="4" required></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="submit" name="btnAddLoanType" value="Save Loan Type" class="modal-save-btn">
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="addLoanModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content add-modal">

            <div class="modal-header modal-title-box">
                <h5 class="modal-title">Add Loan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="EmployeeDashboard.php#loans" method="post">
                <div class="modal-body">

                    <div class="row mb-3">
                        <div class="col">
                            <label>Borrower</label>
                            <select name="borrowerId" class="form-control modal-input" required>
                                <option value="" selected disabled>-- Select Borrower --</option>

                                <?php

                                $borrowerSql = "SELECT * FROM tbl_member ORDER BY member_name ASC";
                                $borrowerResult = $conn->query($borrowerSql);

                                if ($borrowerResult->num_rows > 0) {

                                    foreach ($borrowerResult as $borrowerField) {

                                        echo "<option value='".$borrowerField['member_id']."'>".$borrowerField['member_name']."</option>";

                                    }

                                }

                                ?>
                            </select>
                        </div>

                        <div class="col">
                            <label>Loan Type</label>
                            <select name="loanTypeId" class="form-control modal-input" required>
                                <option value="" selected disabled>-- Select Loan Type --</option>

                                <?php

                                $loanTypeSelectSql = "SELECT * FROM tbl_loanType ORDER BY loan_type_name ASC";
                                $loanTypeSelectResult = $conn->query($loanTypeSelectSql);

                                if ($loanTypeSelectResult->num_rows > 0) {

                                    foreach ($loanTypeSelectResult as $loanTypeSelectField) {

                                        echo "<option value='".$loanTypeSelectField['loan_type_id']."'>".$loanTypeSelectField['loan_type_name']."</option>";

                                    }

                                }

                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label>Loan Amount</label>
                            <input type="number" step="0.01" name="loanAmount" class="form-control modal-input" required>
                        </div>

                        <div class="col">
                            <label>Interest Rate</label>
                            <input type="number" step="0.0001" name="interestRate" class="form-control modal-input" placeholder="Example: 3 for 3%" required>
                        </div>

                        <div class="col">
                            <label>Loan Term</label>
                            <input type="number" name="loanTerm" class="form-control modal-input" placeholder="Months" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label>Date Applied</label>
                            <input type="datetime-local" name="dateApplied" class="form-control modal-input" required>
                        </div>

                        <div class="col">
                            <label>Date Approved</label>
                            <input type="datetime-local" name="dateApproved" class="form-control modal-input">
                        </div>

                        <div class="col">
                            <label>Date Disbursed</label>
                            <input type="datetime-local" name="dateDisbursed" class="form-control modal-input">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Loan Status</label>
                        <select name="loanStatus" class="form-control modal-input" required>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Paid">Paid</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="submit" name="btnAddLoan" value="Save Loan" class="modal-save-btn">
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="addPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content add-modal">

            <div class="modal-header modal-title-box">
                <h5 class="modal-title">Add Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="EmployeeDashboard.php#payments" method="post">
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Loan</label>
                        <select name="paymentLoanId" class="form-control modal-input" required>
                            <option value="" selected disabled>-- Select Loan --</option>

                            <?php

                            $paymentLoanSql = "
                                SELECT tbl_loan.*, tbl_member.member_name
                                FROM tbl_loan
                                INNER JOIN tbl_member ON tbl_loan.borrower_id = tbl_member.member_id
                                WHERE tbl_loan.outstanding_balance > 0
                                AND tbl_loan.loan_status = 'Approved'
                                ORDER BY tbl_loan.date_applied DESC
                            ";

                            $paymentLoanResult = $conn->query($paymentLoanSql);

                            if ($paymentLoanResult->num_rows > 0) {

                                foreach ($paymentLoanResult as $paymentLoanField) {

                                    echo "<option value='".$paymentLoanField['loan_id']."'>".$paymentLoanField['member_name']." - Balance: ".number_format($paymentLoanField['outstanding_balance'], 2)."</option>";

                                }

                            }

                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Payment Amount</label>
                        <input type="number" step="0.01" name="paymentAmount" class="form-control modal-input" required>
                    </div>

                    <div class="mb-3">
                        <label>Payment Date</label>
                        <input type="datetime-local" name="paymentDate" class="form-control modal-input" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="submit" name="btnAddPayment" value="Save Payment" class="modal-save-btn">
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

require_once "includes/db_Conn.php";

if (isset($_POST['btnAddMember'])) {

    $memberUserId = $_POST['memberUserId'];
    $memberName = $_POST['memberName'];
    $contactInformation = $_POST['contactInformation'];
    $memberAddress = $_POST['memberAddress'];

    $insertMemberSql = "
        INSERT INTO tbl_member(user_id, member_name, contact_information, member_address)
        VALUES ('$memberUserId', '$memberName', '$contactInformation', '$memberAddress')
    ";

    $insertMemberResult = $conn->query($insertMemberSql);

    if ($insertMemberResult == true) {

        if (isset($_SESSION['user_id'])) {

            $logSql = "
                INSERT INTO tbl_logs(user_id, log_msg, log_date)
                VALUES ('".$_SESSION['user_id']."', 'Added new member: ".$memberName."', NOW())
            ";

            $conn->query($logSql);
        }

        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Member Added',
                text: 'New member was added successfully.',
                confirmButtonColor: '#723531'
            }).then(() => {
                window.location.href = 'EmployeeDashboard.php#members';
            });
        </script>
        ";

    } else {

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Insert Failed',
                text: '".addslashes($conn->error)."',
                confirmButtonColor: '#723531'
            });
        </script>
        ";

    }

}

if (isset($_POST['btnAddLoanType'])) {

    $loanTypeName = $_POST['loanTypeName'];
    $loanTypeDescription = $_POST['loanTypeDescription'];

    $insertLoanTypeSql = "
        INSERT INTO tbl_loanType(loan_type_name, loan_type_description)
        VALUES ('$loanTypeName', '$loanTypeDescription')
    ";

    $insertLoanTypeResult = $conn->query($insertLoanTypeSql);

    if ($insertLoanTypeResult == true) {

        if (isset($_SESSION['user_id'])) {

            $logSql = "
                INSERT INTO tbl_logs(user_id, log_msg, log_date)
                VALUES ('".$_SESSION['user_id']."', 'Added loan type: ".$loanTypeName."', NOW())
            ";

            $conn->query($logSql);
        }

        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Loan Type Added',
                text: 'New loan type was added successfully.',
                confirmButtonColor: '#723531'
            }).then(() => {
                window.location.href = 'EmployeeDashboard.php#loanTypes';
            });
        </script>
        ";

    } else {

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Insert Failed',
                text: '".addslashes($conn->error)."',
                confirmButtonColor: '#723531'
            });
        </script>
        ";

    }

}

if (isset($_POST['btnAddLoan'])) {

    $borrowerId = $_POST['borrowerId'];
    $loanTypeId = $_POST['loanTypeId'];
    $loanAmount = $_POST['loanAmount'];
    $interestRate = $_POST['interestRate'];
    $loanTerm = $_POST['loanTerm'];
    $dateApplied = str_replace("T", " ", $_POST['dateApplied']);
    $dateApproved = $_POST['dateApproved'];
    $dateDisbursed = $_POST['dateDisbursed'];
    $loanStatus = $_POST['loanStatus'];

    $termInYears = $loanTerm / 12;
    $interestAmount = $loanAmount * ($interestRate / 100) * $termInYears;
    $totalAmount = $loanAmount + $interestAmount;

    if ($loanStatus == "Paid") {
        $outstandingBalance = 0;
    } else {
        $outstandingBalance = $totalAmount;
    }

    if ($dateApproved == NULL || $dateApproved == "") {
        if ($loanStatus == "Approved" || $loanStatus == "Paid") {
            $dateApprovedValue = "NOW()";
        } else {
            $dateApprovedValue = "NULL";
        }
    } else {
        $dateApprovedValue = "'".str_replace("T", " ", $dateApproved)."'";
    }

    if ($dateDisbursed == NULL || $dateDisbursed == "") {
        $dateDisbursedValue = "NULL";
    } else {
        $dateDisbursedValue = "'".str_replace("T", " ", $dateDisbursed)."'";
    }

    $insertLoanSql = "
        INSERT INTO tbl_loan(borrower_id, loan_type_id, loan_amount, interest_rate, loan_term, date_applied, date_approved, date_disbursed, outstanding_balance, loan_status)
        VALUES ('$borrowerId', '$loanTypeId', '$loanAmount', '$interestRate', '$loanTerm', '$dateApplied', $dateApprovedValue, $dateDisbursedValue, '$outstandingBalance', '$loanStatus')
    ";

    $insertLoanResult = $conn->query($insertLoanSql);

    if ($insertLoanResult == true) {

        $loanId = $conn->insert_id;

        if (isset($_SESSION['user_id'])) {

            $logSql = "
                INSERT INTO tbl_logs(user_id, log_msg, log_date)
                VALUES ('".$_SESSION['user_id']."', 'Added loan ID: ".$loanId."', NOW())
            ";

            $conn->query($logSql);
        }

        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Loan Added',
                text: 'New loan was added successfully.',
                confirmButtonColor: '#723531'
            }).then(() => {
                window.location.href = 'EmployeeDashboard.php#loans';
            });
        </script>
        ";

    } else {

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Insert Failed',
                text: '".addslashes($conn->error)."',
                confirmButtonColor: '#723531'
            });
        </script>
        ";

    }

}

if (isset($_POST['btnApproveLoan'])) {

    $approveLoanId = $_POST['approveLoanId'];

    $approveLoanSql = "
        UPDATE tbl_loan
        SET loan_status = 'Approved', date_approved = NOW()
        WHERE loan_id = '".$approveLoanId."'
    ";

    $approveLoanResult = $conn->query($approveLoanSql);

    if ($approveLoanResult == true) {

        if (isset($_SESSION['user_id'])) {

            $logSql = "
                INSERT INTO tbl_logs(user_id, log_msg, log_date)
                VALUES ('".$_SESSION['user_id']."', 'Approved loan ID: ".$approveLoanId."', NOW())
            ";

            $conn->query($logSql);
        }

        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Loan Approved',
                text: 'Loan has been approved successfully.',
                confirmButtonColor: '#723531'
            }).then(() => {
                window.location.href = 'EmployeeDashboard.php#loans';
            });
        </script>
        ";

    } else {

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Approval Failed',
                text: '".addslashes($conn->error)."',
                confirmButtonColor: '#723531'
            });
        </script>
        ";

    }
}

if (isset($_POST['btnAddPayment'])) {

    $paymentLoanId = $_POST['paymentLoanId'];
    $paymentAmount = $_POST['paymentAmount'];
    $paymentDate = str_replace("T", " ", $_POST['paymentDate']);

    $insertPaymentSql = "
        INSERT INTO tbl_payment(loan_id, payment_amount, payment_date)
        VALUES ('$paymentLoanId', '$paymentAmount', '$paymentDate')
    ";

    $insertPaymentResult = $conn->query($insertPaymentSql);

    if ($insertPaymentResult == true) {

        $getLoanSql = "
            SELECT * FROM tbl_loan
            WHERE loan_id = '".$paymentLoanId."'
        ";

        $getLoanResult = $conn->query($getLoanSql);
        $loanField = $getLoanResult->fetch_assoc();

        $newBalance = $loanField['outstanding_balance'] - $paymentAmount;

        if ($newBalance <= 0) {
            $newBalance = 0;
            $newStatus = "Paid";
        } else {
            $newStatus = $loanField['loan_status'];
        }

        $updateLoanSql = "
            UPDATE tbl_loan
            SET outstanding_balance = '".$newBalance."', loan_status = '".$newStatus."'
            WHERE loan_id = '".$paymentLoanId."'
        ";

        $conn->query($updateLoanSql);

        if (isset($_SESSION['user_id'])) {

            $logSql = "
                INSERT INTO tbl_logs(user_id, log_msg, log_date)
                VALUES ('".$_SESSION['user_id']."', 'Added payment for loan ID: ".$paymentLoanId."', NOW())
            ";

            $conn->query($logSql);

            if ($newStatus == "Paid") {

                $paidLogSql = "
                    INSERT INTO tbl_logs(user_id, log_msg, log_date)
                    VALUES ('".$_SESSION['user_id']."', 'Marked loan ID ".$paymentLoanId." as Paid', NOW())
                ";

                $conn->query($paidLogSql);

            } else {

                $balanceLogSql = "
                    INSERT INTO tbl_logs(user_id, log_msg, log_date)
                    VALUES ('".$_SESSION['user_id']."', 'Updated outstanding balance for loan ID: ".$paymentLoanId."', NOW())
                ";

                $conn->query($balanceLogSql);

            }
        }

        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Payment Added',
                text: 'Payment was added successfully.',
                confirmButtonColor: '#723531'
            }).then(() => {
                window.location.href = 'EmployeeDashboard.php#payments';
            });
        </script>
        ";

    } else {

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Insert Failed',
                text: '".addslashes($conn->error)."',
                confirmButtonColor: '#723531'
            });
        </script>
        ";

    }

}

?>