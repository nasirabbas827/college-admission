# College Admission Management System (Updated)

A lightweight PHP web application for managing college admissions, merit lists, and applicant data. The system provides separate admin and applicant interfaces, secure authentication, and basic CRUD operations on a MySQL database.

---

## Overview

The **College Admission Management System** streamlines the admission workflow for colleges:

- Applicants can register, submit their transcripts, and view their application status.
- Administrators can log in, upload merit lists, review applications, and manage applicant profiles.
- A simple, responsive UI built with plain CSS.

The repository contains the full source code, database schema, and sample documentation.

---

## Features

| Feature | Description |
|---------|-------------|
| **User Authentication** | Secure login/logout for both admins and applicants. |
| **Applicant Registration** | Register, upload transcripts, and edit profile. |
| **Merit List Management** | Admins can upload and publish merit lists (`post_merit_list.php`). |
| **Application Review** | Admin view of all applications with detailed applicant info. |
| **Status Tracking** | Applicants can view their current admission status (`view_application.php`). |
| **Responsive UI** | Simple navigation bar (`navbar.php`, `admin_navbar.php`) and CSS styling (`css/style.css`). |
| **Database Export** | Ready-to-import MySQL dump (`Database/college_db.sql`). |
| **Documentation** | Project overview (`CAMS.docx`). |

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend** | PHP 7.4+ |
| **Database** | MySQL / MariaDB |
| **Frontend** | HTML5, CSS3 |
| **Server** | Apache / Nginx (compatible with any LAMP stack) |
| **Version Control** | Git |

---

## Installation

### Prerequisites

- PHP 7.4 or higher with PDO extension enabled.
- MySQL server.
- A web server (Apache/Nginx) configured to serve PHP files.
- Composer (optional, for future dependency management).

### Steps

1. **Clone the repository**

   ```bash
   git clone https://github.com/your-username/College-Admission-updated.git
   cd College-Admission-updated
   ```

2. **Create the database**

   ```bash
   mysql -u root -p
   CREATE DATABASE college_admission;
   \q
   ```

   Then import the provided schema:

   ```bash
   mysql -u root -p college_admission < Database/college_db.sql
   ```

3. **Configure database connection**

   Edit `config.php` (and `admin/config.php` if needed) and replace the placeholder values with your own credentials:

   ```php
   // config.php
   $db_host = 'localhost';
   $db_name = 'college_admission';
   $db_user = 'YOUR_DB_USERNAME';
   $db_pass = 'YOUR_DB_PASSWORD';
   ```

4. **Set up file permissions**

   Ensure the web server can read the PHP files and write to any upload directories (e.g., `transcript_files/`).

   ```bash
   chmod -R 755 .
   ```

5. **Start the server**

   - **Apache** – place the project folder inside `htdocs` (or configure a virtual host).
   - **Built‑in PHP server** (for quick testing):

     ```bash
     php -S localhost:8000
     ```

6. **Visit the application**

   Open your browser and navigate to `http://localhost/College-Admission-updated/` (or the virtual host you configured).

---

## Usage

### Applicant Flow

1. **Register** – `register.php`
2. **Login** – `login.php`
3. **Upload Transcript** – `update_profile.php` (or during registration)
4. **View Application Status** – `view_application.php`
5. **Logout** – `logout