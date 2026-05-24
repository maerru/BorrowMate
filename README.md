# BorrowMate

**BorrowMate** is a web-based loaning system designed to manage loan applications, loan approvals, payments, members, users, and system activity logs.

**Tagline:** Your loan companion, every step of the way.

---

## About the Project

BorrowMate helps make the loaning process easier and more organized. It allows members to apply for loans, employees to review and approve loan applications, and admins to manage the whole system.

The system keeps important records such as users, members, loan types, loan applications, payment records, and activity logs in one place.

---

## User Roles

### Admin

The Admin can manage the entire system.

Admin can:
- View and add users
- View and add members
- View and add loan types
- View and add loans
- View and add payments
- View system logs

### Employee

The Employee can manage loan-related records.

Employee can:
- View and add members
- View and add loan types
- View and add loans
- Approve pending loans
- View and add payments

### Member

The Member can use the system to apply for loans and track their own records.

Member can:
- Register an account
- Verify account through OTP
- Apply for a loan
- View loan status
- View payment records

---

## Features

- Landing page
- Login page
- Sign up page
- OTP email verification using PHPMailer
- Role-based login redirection
- Admin dashboard
- Employee dashboard
- Member dashboard
- Loan application
- Loan approval
- Payment recording
- Outstanding balance update
- System activity logs
- Search bars for table sections
- Rustic BorrowMate-themed interface

---

## Loan Computation

BorrowMate uses a simple interest formula for loan computation.

### Formula

```txt
T = months / 12

Interest = Principal Amount * Interest Rate * T

Total Amount = Principal Amount + Interest

Monthly Payment = Total Amount / Loan Term in months