# NPA Results Management System

A web-based school results management system designed for handling student records, results processing, and administrative management.

---

## 📌 Overview

This system helps schools manage:
- Student records
- Result computation and processing
- Class/subject management
- Administrative control panel

---

## ⚠️ Important Notice

This repository does NOT include live configuration files containing sensitive data such as database credentials or school-specific settings.

Instead, a sample configuration folder is provided: /config.example

It contains:
- `npa.config.ini` (configuration template)
- `npa_results.sql` (database structure)

---

## ⚙️ Installation Guide

### A. Database Setup

1. Create a new MySQL database
2. Import the file: npa_results.sql

This will automatically create all required tables for the system.

---

### B. Configuration Setup

1. Move the configuration file: npa.config.ini into a folder called config outside the web root

i.e  config/npa.config.ini
(config folder and public_html folder should be in the same directory)

2. Update the values inside the `.ini` file:

- Database host
- Database name
- Database username
- Database password
- School name and system constants

⚠️ Ensure all required keys are filled correctly. Missing or incorrect keys may cause system failure.

---

### C. File Structure Requirement

The system expects:
/home/username/config/npa.config.ini
/home/username/public_html/scripts here

---

## 🔐 Security Note

- Do NOT expose `config/` folder to public access
- Keep database credentials secure
- Keep email credentials secure

This why configuration file must be stored outside the document root, all files inside the document are stealable by site clon

---

## 🚀 Usage

After setup:
- Open the system via your domain
- Login using admin credentials (defined in system setup)
- Begin managing students and results

---

## 🧑‍💻 Developer Notes

This system is designed to be flexible but depends on strict configuration structure.  
Ensure that all required configuration keys exist in the `.ini` file before running the system.

---

## 📞 Support / Contact

For setup issues, ensure:
- Database is correctly imported
- Config file path is correct
- Server supports PHP 8.0+ and MySQL

---

For setup help or issues with this system, contact:

- Email: johnella@webdevhub.com.ng
- GitHub: https://github.com/john-physics  


## 📜 License

This project is for educational and institutional use.
