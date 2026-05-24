# BorrowMate

**BorrowMate** is a web-based loaning system designed to manage loan applications, loan approvals, payments, members, users, and system activity logs.

**Tagline:** Your loan companion, every step of the way.

---

## About the Project

BorrowMate helps make the loaning process easier and more organized. It allows members to apply for loans, employees to review and approve loan applications, and admins to manage the whole system.

The system keeps important records such as users, members, loan types, loan applications, payment records, and activity logs in one place.

---

## Tech Stack

BorrowMate was built using the following technologies:

| Technology | Purpose |
|---|---|
| **PHP** | Used for server-side scripting, form processing, login, signup, OTP verification, dashboards, and database operations. |
| **MySQL** | Used as the database for storing users, members, loan types, loans, payments, and activity logs. |
| **HTML** | Used to structure the website pages and forms. |
| **CSS** | Used for custom styling and the BorrowMate rustic color theme. |
| **Bootstrap** | Used for responsive layout, grid system, forms, tables, navbar, and modals. |
| **JavaScript** | Used for page redirects and interactive actions. |
| **SweetAlert2** | Used for alert messages such as success, error, login failed, and verification messages. |
| **PHPMailer** | Used for sending OTP verification emails. |
| **Composer** | Used to install and manage PHPMailer dependencies. |
| **XAMPP** | Used as the local development environment for Apache and MySQL. |

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