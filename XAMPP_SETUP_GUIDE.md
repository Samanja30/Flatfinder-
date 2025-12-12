# 🚀 FlatFinders - XAMPP Setup Guide

**Complete Step-by-Step Installation & Configuration Guide**

---

## 📋 Table of Contents

1. [Prerequisites](#prerequisites)
2. [Installing XAMPP](#installing-xampp)
3. [Starting XAMPP Services](#starting-xampp-services)
4. [Setting Up FlatFinders](#setting-up-flatfinders)
5. [Database Configuration](#database-configuration)
6. [Running the Application](#running-the-application)
7. [Troubleshooting](#troubleshooting)
8. [Common Issues & Solutions](#common-issues--solutions)

---

## 📥 Prerequisites

Before starting, ensure you have:

- ✅ Windows 10 or later
- ✅ At least 2GB free disk space
- ✅ Administrator access to your computer
- ✅ Internet connection (for initial setup)
- ✅ A modern web browser (Chrome, Firefox, or Edge)

---

## 💿 Installing XAMPP

### Step 1: Download XAMPP

1. Open your web browser
2. Go to: **https://www.apachefriends.org/**
3. Click on **"Download"** button
4. Select **XAMPP for Windows** (latest version, PHP 8.x recommended)
5. Wait for the download to complete (~150MB)

### Step 2: Install XAMPP

1. **Locate the downloaded file** (usually in `Downloads` folder)
   - File name: `xampp-windows-x64-8.x.x-installer.exe`

2. **Right-click** the installer and select **"Run as Administrator"**

3. **Security Warning:** Click **"Yes"** if User Account Control (UAC) appears

4. **Setup Wizard:**
   - Click **"Next"** on the welcome screen
   
5. **Component Selection:**
   - ✅ Apache (must be checked)
   - ✅ MySQL (must be checked)
   - ✅ PHP (must be checked)
   - ✅ phpMyAdmin (must be checked)
   - ⬜ Other components are optional
   - Click **"Next"**

6. **Installation Folder:**
   - Default: `C:\xampp`
   - **Recommended:** Keep the default location
   - Click **"Next"**

7. **Language:**
   - Select **English**
   - Click **"Next"**

8. **Ready to Install:**
   - Click **"Next"** to begin installation
   - Wait 5-10 minutes for installation to complete

9. **Installation Complete:**
   - ✅ Check "Do you want to start the Control Panel now?"
   - Click **"Finish"**

---

## ▶️ Starting XAMPP Services

### Step 1: Open XAMPP Control Panel

1. **Method 1:** Double-click the XAMPP Control Panel icon on your desktop
2. **Method 2:** Go to `C:\xampp\` and run `xampp-control.exe`

### Step 2: Start Required Services

1. **Start Apache:**
   - Click the **"Start"** button next to **Apache**
   - Wait for status to turn green
   - Port: 80 and 443

2. **Start MySQL:**
   - Click the **"Start"** button next to **MySQL**
   - Wait for status to turn green
   - Port: 3306

3. **Success Indicators:**
   - ✅ Apache and MySQL background should be **GREEN**
   - ✅ Status should show as **"Running"**

### Step 3: Verify XAMPP is Running

1. Open your web browser
2. Visit: **http://localhost**
3. You should see the XAMPP welcome page
4. Visit: **http://localhost/phpmyadmin**
5. You should see the phpMyAdmin interface

---

## 🏗️ Setting Up FlatFinders

### Step 1: Copy Project Files

1. **Locate your FlatFinder project folder**
   - Current location: `C:\Users\sheik\Desktop\Flatfinder`

2. **Copy the entire Flatfinder folder**

3. **Navigate to XAMPP htdocs:**
   - Go to: `C:\xampp\htdocs\`

4. **Paste the Flatfinder folder** into htdocs
   - Final path should be: `C:\xampp\htdocs\Flatfinder\`

### Step 2: Verify File Structure

Check that these folders exist in `C:\xampp\htdocs\Flatfinder\`:

```
Flatfinder/
├── backend/
│   ├── api/
│   ├── config/
│   ├── database/
│   └── includes/
├── public/
│   ├── assets/
│   ├── *.html files
├── index.php
├── setup.php
├── setup-handler.php
└── README.md
```

---

## 🗄️ Database Configuration

### Method 1: Automatic Setup (Recommended)

1. **Open your browser**

2. **Navigate to:**
   ```
   http://localhost/Flatfinder/setup.php
   ```

3. **Read the setup information**

4. **Click the "🚀 Run Setup" button**

5. **Wait for completion**
   - Database will be created automatically
   - Tables will be generated
   - Sample data will be inserted

6. **Success!**
   - You'll see a success message
   - Database setup is complete

### Method 2: Manual Setup (Alternative)

If automatic setup fails:

#### Step 1: Open phpMyAdmin

1. Go to: **http://localhost/phpmyadmin**
2. Default login: username = `root`, password = (empty)

#### Step 2: Create Database

1. Click **"New"** in the left sidebar
2. Database name: `flatfinders_db`
3. Collation: `utf8mb4_unicode_ci`
4. Click **"Create"**

#### Step 3: Import Schema

1. Click on **flatfinders_db** in the left sidebar
2. Click the **"Import"** tab at the top
3. Click **"Choose File"** button
4. Navigate to: `C:\xampp\htdocs\Flatfinder\backend\database\schema.sql`
5. Select the file and click **"Open"**
6. Scroll down and click **"Go"**
7. Wait for success message

#### Step 4: Import Sample Data

1. Stay in **flatfinders_db** database
2. Click the **"Import"** tab again
3. Click **"Choose File"** button
4. Navigate to: `C:\xampp\htdocs\Flatfinder\backend\database\sample-data.sql`
5. Select the file and click **"Open"**
6. Scroll down and click **"Go"**
7. Wait for success message

#### Step 5: Verify Database

1. Click **flatfinders_db** in left sidebar
2. You should see tables:
   - ✅ users
   - ✅ properties
   - ✅ property_images
   - ✅ amenities
   - ✅ property_amenities
   - ✅ inquiries
   - ✅ favorites
   - ✅ notifications
   - ✅ contacts
   - ✅ recently_viewed

---

## 🌐 Running the Application

### Step 1: Access the Application

1. **Homepage:**
   ```
   http://localhost/Flatfinder/
   ```
   or
   ```
   http://localhost/Flatfinder/public/index.html
   ```

2. **Login Page:**
   ```
   http://localhost/Flatfinder/public/login.html
   ```

3. **Setup Page:**
   ```
   http://localhost/Flatfinder/setup.php
   ```

### Step 2: Login with Sample Accounts

Use any of these accounts (all passwords: **password123**):

**Admin Account:**
```
Email: admin@flatfinders.com
Password: password123
```

**Owner Account:**
```
Email: abdul.rahman@gmail.com
Password: password123
```

**Customer Account:**
```
Email: rafiq.ahmed@gmail.com
Password: password123
```

See **CREDENTIALS.md** for complete list of accounts.

### Step 3: Explore Features

**As Admin:**
- View dashboard at: `http://localhost/Flatfinder/public/admin-dashboard.html`
- Manage properties
- View statistics
- Manage users

**As Owner:**
- View dashboard at: `http://localhost/Flatfinder/public/owner-dashboard.html`
- Post new properties
- Manage inquiries
- View property analytics

**As Customer:**
- View dashboard at: `http://localhost/Flatfinder/public/customer-dashboard.html`
- Search properties
- Save favorites
- Send inquiries

---

## 🔧 Troubleshooting

### Issue 1: Apache Won't Start

**Problem:** Port 80 is already in use

**Solutions:**

1. **Find conflicting program:**
   - Open XAMPP Control Panel
   - Click **"Netstat"** button
   - Look for programs using port 80
   - Common conflicts: Skype, IIS, other web servers

2. **Change Apache Port:**
   - Click **"Config"** next to Apache
   - Select **"httpd.conf"**
   - Find line: `Listen 80`
   - Change to: `Listen 8080`
   - Save and restart Apache
   - Access via: `http://localhost:8080/Flatfinder/`

3. **Stop conflicting service:**
   - Press `Win + R`
   - Type: `services.msc`
   - Find and stop "World Wide Web Publishing Service"
   - Restart Apache

### Issue 2: MySQL Won't Start

**Problem:** Port 3306 is already in use

**Solutions:**

1. **Check for existing MySQL:**
   - Press `Win + R`
   - Type: `services.msc`
   - Look for "MySQL" service
   - Stop it
   - Restart XAMPP MySQL

2. **Change MySQL Port:**
   - Click **"Config"** next to MySQL
   - Select **"my.ini"**
   - Find: `port=3306`
   - Change to: `port=3307`
   - Update `backend/config/database.php` accordingly

### Issue 3: Database Connection Failed

**Problem:** Cannot connect to database

**Solutions:**

1. **Verify MySQL is running:**
   - Check XAMPP Control Panel
   - MySQL should show green

2. **Check database credentials:**
   - Open: `backend/config/database.php`
   - Verify:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'flatfinders_db');
     ```

3. **Test phpMyAdmin:**
   - Visit: `http://localhost/phpmyadmin`
   - If this works, database is accessible

### Issue 4: 404 Not Found Errors

**Problem:** Pages not loading

**Solutions:**

1. **Check file location:**
   - Files must be in: `C:\xampp\htdocs\Flatfinder\`
   - NOT in Desktop or other locations

2. **Check URL:**
   - Correct: `http://localhost/Flatfinder/public/index.html`
   - Wrong: `http://localhost/index.html`

3. **Restart Apache:**
   - Stop Apache in XAMPP Control Panel
   - Wait 5 seconds
   - Start Apache again

### Issue 5: API Requests Failing

**Problem:** API calls return errors

**Solutions:**

1. **Check PHP errors:**
   - Open: `C:\xampp\apache\logs\error.log`
   - Look for recent errors

2. **Enable error reporting:**
   - Open: `backend/config/config.php`
   - Verify:
     ```php
     error_reporting(E_ALL);
     ini_set('display_errors', 1);
     ```

3. **Check browser console:**
   - Press F12 in browser
   - Check Console tab for errors
   - Check Network tab for failed requests

### Issue 6: File Upload Not Working

**Problem:** Cannot upload property images

**Solutions:**

1. **Create uploads folder:**
   - Go to: `C:\xampp\htdocs\Flatfinder\backend\`
   - Create folder: `uploads`
   - Create subfolder: `uploads/properties`

2. **Set permissions:**
   - Right-click `uploads` folder
   - Properties → Security
   - Edit → Add → Everyone
   - Allow Full Control

3. **Check PHP settings:**
   - Open: `C:\xampp\php\php.ini`
   - Find and update:
     ```ini
     upload_max_filesize = 10M
     post_max_size = 10M
     ```
   - Restart Apache

---

## ✅ Common Issues & Solutions

### White Screen / Blank Page

**Cause:** PHP error
**Solution:**
1. Check `C:\xampp\apache\logs\error.log`
2. Enable error display in `config.php`
3. Verify all required files exist

### Session Not Working

**Cause:** Session files not writable
**Solution:**
1. Check: `C:\xampp\tmp\` folder exists
2. Verify folder is writable
3. Clear browser cookies

### Images Not Displaying

**Cause:** Incorrect file paths
**Solution:**
1. Verify images are in `backend/uploads/properties/`
2. Check file permissions
3. Check image paths in database

### Slow Performance

**Cause:** Low system resources
**Solution:**
1. Close unnecessary applications
2. Increase PHP memory limit in `php.ini`:
   ```ini
   memory_limit = 256M
   ```
3. Restart Apache

---

## 📞 Additional Help

### XAMPP Documentation
- Official Docs: https://www.apachefriends.org/docs/

### PHP Documentation
- PHP Manual: https://www.php.net/manual/

### MySQL Documentation
- MySQL Docs: https://dev.mysql.com/doc/

### Video Tutorials
- Search YouTube: "XAMPP installation Windows"
- Search YouTube: "PHP MySQL project setup"

---

## 🎯 Quick Reference

### Important URLs
```
Homepage:      http://localhost/Flatfinder/
Setup:         http://localhost/Flatfinder/setup.php
Login:         http://localhost/Flatfinder/public/login.html
phpMyAdmin:    http://localhost/phpmyadmin
XAMPP:         http://localhost
```

### Important Paths
```
Project:       C:\xampp\htdocs\Flatfinder\
Config:        C:\xampp\htdocs\Flatfinder\backend\config\
Database:      C:\xampp\htdocs\Flatfinder\backend\database\
Logs:          C:\xampp\apache\logs\
PHP Config:    C:\xampp\php\php.ini
```

### Important Commands
```
Start Services:    Open XAMPP Control Panel → Start Apache & MySQL
Stop Services:     Open XAMPP Control Panel → Stop Apache & MySQL
View Logs:         XAMPP Control Panel → Logs button
Check Ports:       XAMPP Control Panel → Netstat button
```

---

## 🎉 Success Checklist

Before considering setup complete, verify:

- ✅ XAMPP installed successfully
- ✅ Apache service running (green in Control Panel)
- ✅ MySQL service running (green in Control Panel)
- ✅ Can access http://localhost
- ✅ Can access http://localhost/phpmyadmin
- ✅ Project files in C:\xampp\htdocs\Flatfinder\
- ✅ Database created (flatfinders_db)
- ✅ Tables created (users, properties, etc.)
- ✅ Sample data inserted
- ✅ Can access http://localhost/Flatfinder/
- ✅ Can login with test accounts
- ✅ No error messages in browser console
- ✅ API calls working properly

---

**Setup Guide Version:** 1.0.0  
**Last Updated:** December 12, 2025  
**Compatible with:** XAMPP 8.x, PHP 8.x, MySQL 8.x

---

## 🆘 Still Having Issues?

1. **Restart Everything:**
   - Stop all XAMPP services
   - Close XAMPP Control Panel
   - Restart computer
   - Start XAMPP services again

2. **Check Antivirus:**
   - Some antivirus software blocks XAMPP
   - Add XAMPP folder to antivirus exceptions

3. **Reinstall XAMPP:**
   - Uninstall XAMPP completely
   - Delete C:\xampp folder
   - Restart computer
   - Install XAMPP again

4. **Check Windows Firewall:**
   - Allow Apache and MySQL through firewall
   - Control Panel → Windows Firewall → Allow an app

---

**Good luck with your FlatFinders setup! 🏠🎉**
