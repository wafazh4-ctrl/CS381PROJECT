# YIC Found: Lost and Found Web Portal

## Project Overview
YIC Found is a web-based portal developed for Yanbu Industrial College (YIC) to manage on-campus lost and found entries. The system is engineered entirely using native PHP (PDO), HTML5, CSS3, and JavaScript, strictly adhering to the course policy prohibiting external frameworks or libraries.

## 🎥 Project Video Walkthrough
You can watch our full 5-minute project demonstration, system flow, and security countermeasures breakdown here:

[Watch the Video Walkthrough](https://drive.google.com/file/d/1QkmTD6rQF8Wp4mtuBdc1Vkq5mOlBK3a_/view?usp=drivesdk)



## System Architecture
```text
CS381Project/
├── assets/
│   ├── css/
│   │   └── style.css
│   └── image/
│       └── YICLogo.jpg
├── includes/
│   ├── db_connect.php
│   └── security.php
├── admin_dashboard.php
├── browse.php
├── details.php
├── index.php
├── login.php
├── logout.php
├── register.php
└──report_item.php
 

Implemented Security Controls
SQL Injection Prevention: Handled via PDO Prepared Statements and strict input parameter binding.

Cross-Site Scripting (XSS) Defense: Output contextual sanitization implemented globally via custom data scrubbing functions and htmlspecialchars.

Cross-Site Request Forgery (CSRF) Mitigation: Enforced via the Synchronizer Token Pattern on all state-changing POST forms.

Session and Cookie Hardening: Secured via runtime initialization configurations (HttpOnly, SameSite=Strict) and automated session ID regeneration upon verification.

Deployment Steps
Move the complete project directory into your local server root folder (e.g., Laragon www).

Create a local database named yic_found_db using phpMyAdmin.

Import the database schema file yic_found_db.sql into the newly created database.

Verify server configuration parameters inside includes/db_connect.php.

Access the application homepage via: http://localhost/CS381Project/index.php

Testing Accounts
The imported database includes pre-configured records for functional testing:

Admin Role: admin@yic.edu.sa

Student Role: jana@yic.edu.sa
