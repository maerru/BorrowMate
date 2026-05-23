<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BorrowMate Admin Dashboard</title>
    <link rel="icon" type="image/png" href="BorrowMateLogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="AdminDashboard.css">
</head>
<body>

<nav class="navbar navbar-expand-lg admin-navbar">
    <div class="container-fluid nav-container">
        <a class="navbar-brand d-flex align-items-center" href="#dashboard">
            <img src="BorrowMateLogo.png" class="nav-logo">
            <span class="brand-text">BorrowMate</span>
        </a>

        <div class="user-box">
            <span class="user-role">Admin</span>
            <span class="user-name">
                <?php
                    if (isset($_SESSION['user_name'])) {
                        echo $_SESSION['user_name'];
                    } else {
                        echo "Admin User";
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
                Admin Panel
            </div>

            <a href="#dashboard" class="sidebar-link active-link">Dashboard</a>
            <a href="#users" class="sidebar-link">Users</a>
            <a href="#members" class="sidebar-link">Members</a>
            <a href="#loanTypes" class="sidebar-link">Loan Types</a>
            <a href="#loans" class="sidebar-link">Loans</a>
            <a href="#payments" class="sidebar-link">Payments</a>
            <a href="#logs" class="sidebar-link">Logs</a>

            <div class="logout-area">
                <a href="LoginPage.php" class="logout-link">Log Out</a>
            </div>
        </div>

        <div class="col-md-10 content-area">

            <section class="section-box" id="dashboard">
                <h1>Admin Dashboard</h1>
                <p>Welcome to BorrowMate admin dashboard.</p>

                <div class="sample-card mt-4">
                    <h3>Admin Access</h3>
                    <p>
                        This page is for the Admin role. Admin can manage users, members, loan types, loans, and payments.
                    </p>
                    <span class="sample-badge">ADMIN DASHBOARD</span>
                </div>
            </section>

            <section class="section-box" id="users">
                <div class="section-title-row">
                    <div>
                        <h1>Users</h1>
                        <p>This section contains the system users table.</p>
                    </div>

                    <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        Add User
                    </button>
                </div>

                <form action="AdminDashboard.php#users" method="post">
                    <div class="row mt-4 mb-4">
                        <div class="col-md-10">
                            <input type="search" name="searchUsers" class="form-control search-box" placeholder="Search users">
                        </div>

                        <div class="col-md-2">
                            <input type="submit" name="btnSearchUsers" value="Search" class="search-btn form-control">
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover borrowmate-table">
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>

                        <?php

                        require_once "db_Conn.php";

                        if (isset($_POST['btnSearchUsers'])) {

                            $searchUsers = $_POST['searchUsers'];
                            $searchInput = trim($searchUsers);

                            if ($searchInput != NULL && $searchInput != "") {

                                $displayUserSql = "
                                    SELECT * FROM tbl_user
                                    WHERE user_id LIKE '%".$searchInput."%'
                                    OR user_name LIKE '%".$searchInput."%'
                                    OR user_role LIKE '%".$searchInput."%'
                                    OR user_email LIKE '%".$searchInput."%'
                                    OR user_status LIKE '%".$searchInput."%'
                                ";

                            } else {

                                $displayUserSql = "SELECT * FROM tbl_user";

                            }

                        } else {

                            $displayUserSql = "SELECT * FROM tbl_user";

                        }

                        $userResult = $conn->query($displayUserSql);

                        if ($userResult->num_rows > 0) {

                            foreach ($userResult as $userField) {

                                echo "<tr>";
                                echo "<td>".$userField['user_id']."</td>";
                                echo "<td>".$userField['user_name']."</td>";
                                echo "<td>".$userField['user_role']."</td>";
                                echo "<td>".$userField['user_email']."</td>";
                                echo "<td>".$userField['user_status']."</td>";
                                echo "</tr>";

                            }

                        } else {

                            echo "<tr>";
                            echo "<td colspan='5' class='text-center'>No users found</td>";
                            echo "</tr>";

                        }

                        ?>
                    </table>
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

                <form action="AdminDashboard.php#members" method="post">
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

                <form action="AdminDashboard.php#loanTypes" method="post">
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
                        <p>This section contains the loans table.</p>
                    </div>

                    <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#addLoanModal">
                        Add Loan
                    </button>
                </div>

                <form action="AdminDashboard.php#loans" method="post">
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
                                echo "</tr>";

                            }

                        } else {

                            echo "<tr>";
                            echo "<td colspan='14' class='text-center'>No loans found</td>";
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

                <form action="AdminDashboard.php#payments" method="post">
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

        <section class="section-box" id="logs">
            <div class="section-title-row">
                <div>
                    <h1>Logs</h1>
                    <p>This section contains the system activity logs.</p>
                </div>
            </div>

            <form action="AdminDashboard.php#logs" method="post">
                <div class="row mt-4 mb-4">
                    <div class="col-md-10">
                        <input type="search" name="searchLogs" class="form-control search-box" placeholder="Search logs">
                    </div>

                    <div class="col-md-2">
                        <input type="submit" name="btnSearchLogs" value="Search" class="search-btn form-control">
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover borrowmate-table">
                    <tr>
                        <th>Log ID</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Date and Time</th>
                    </tr>

                    <?php

                    require_once "db_Conn.php";

                    if (isset($_POST['btnSearchLogs'])) {

                        $searchLogs = $_POST['searchLogs'];
                        $searchInput = trim($searchLogs);

                        if ($searchInput != NULL && $searchInput != "") {

                            $displayLogSql = "
                                SELECT tbl_logs.*, tbl_user.user_name
                                FROM tbl_logs
                                INNER JOIN tbl_user ON tbl_logs.user_id = tbl_user.user_id
                                WHERE tbl_logs.log_id LIKE '%".$searchInput."%'
                                OR tbl_user.user_name LIKE '%".$searchInput."%'
                                OR tbl_logs.log_msg LIKE '%".$searchInput."%'
                                OR tbl_logs.log_date LIKE '%".$searchInput."%'
                                ORDER BY tbl_logs.log_date DESC
                            ";

                        } else {

                            $displayLogSql = "
                                SELECT tbl_logs.*, tbl_user.user_name
                                FROM tbl_logs
                                INNER JOIN tbl_user ON tbl_logs.user_id = tbl_user.user_id
                                ORDER BY tbl_logs.log_date DESC
                            ";

                        }

                    } else {

                        $displayLogSql = "
                            SELECT tbl_logs.*, tbl_user.user_name
                            FROM tbl_logs
                            INNER JOIN tbl_user ON tbl_logs.user_id = tbl_user.user_id
                            ORDER BY tbl_logs.log_date DESC
                        ";

                    }

                    $logResult = $conn->query($displayLogSql);

                    if ($logResult->num_rows > 0) {

                        foreach ($logResult as $logField) {

                            echo "<tr>";
                            echo "<td>".$logField['log_id']."</td>";
                            echo "<td>".$logField['user_name']."</td>";
                            echo "<td>".$logField['log_msg']."</td>";
                            echo "<td>".$logField['log_date']."</td>";
                            echo "</tr>";

                        }

                    } else {

                        echo "<tr>";
                        echo "<td colspan='4' class='text-center'>No logs found</td>";
                        echo "</tr>";

                    }

                    ?>
                </table>
            </div>
        </section>

        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content add-modal">

            <div class="modal-header modal-title-box">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="AdminDashboard.php#users" method="post">
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="userName" class="form-control modal-input" required>
                    </div>

                    <div class="mb-3">
                        <label>User Role</label>
                        <select name="userRole" class="form-control modal-input" required>
                            <option value="" selected disabled>-- Select Role --</option>
                            <option value="Admin">Admin</option>
                            <option value="Employee">Employee</option>
                            <option value="Member">Member</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="userEmail" class="form-control modal-input" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="userPassword" class="form-control modal-input" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="submit" name="btnAddUser" value="Save User" class="modal-save-btn">
                </div>
            </form>

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

            <form action="AdminDashboard.php#members" method="post">
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

            <form action="AdminDashboard.php#loanTypes" method="post">
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

            <form action="AdminDashboard.php#loans" method="post">
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

            <form action="AdminDashboard.php#payments" method="post">
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

require_once "db_Conn.php";

if (isset($_POST['btnAddUser'])) {

    $userName = $_POST['userName'];
    $userRole = $_POST['userRole'];
    $userEmail = $_POST['userEmail'];
    $userPassword = md5($_POST['userPassword']);

    $checkUserSql = "
        SELECT * FROM tbl_user
        WHERE user_name = '".$userName."'
        OR user_email = '".$userEmail."'
    ";

    $checkUserResult = $conn->query($checkUserSql);

    if ($checkUserResult->num_rows > 0) {

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'User Already Exists',
                text: 'Username or email is already used.',
                confirmButtonColor: '#723531'
            });
        </script>
        ";

    } else {

        $insertUserSql = "
            INSERT INTO tbl_user(user_name, user_role, user_pass, user_email, user_otp, user_status)
            VALUES ('$userName', '$userRole', '$userPassword', '$userEmail', NULL, 'Active')
        ";

        $insertUserResult = $conn->query($insertUserSql);

        if ($insertUserResult == true) {

            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'User Added',
                    text: 'New user was added successfully.',
                    confirmButtonColor: '#723531'
                }).then(() => {
                    window.location.href = 'AdminDashboard.php#users';
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

}

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

        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Member Added',
                text: 'New member was added successfully.',
                confirmButtonColor: '#723531'
            }).then(() => {
                window.location.href = 'AdminDashboard.php#members';
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

        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Loan Type Added',
                text: 'New loan type was added successfully.',
                confirmButtonColor: '#723531'
            }).then(() => {
                window.location.href = 'AdminDashboard.php#loanTypes';
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
        $dateApprovedValue = "NULL";
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

        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Loan Added',
                text: 'New loan was added successfully.',
                confirmButtonColor: '#723531'
            }).then(() => {
                window.location.href = 'AdminDashboard.php#loans';
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

        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Payment Added',
                text: 'Payment was added successfully.',
                confirmButtonColor: '#723531'
            }).then(() => {
                window.location.href = 'AdminDashboard.php#payments';
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