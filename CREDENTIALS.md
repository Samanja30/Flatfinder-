# 🔐 FlatFinders - Login Credentials

## Default User Accounts

All accounts use the password: **password123**

---

## 👨‍💼 Admin Account

**Purpose:** Full system access, manage properties, users, and view analytics

- **Email:** `admin@flatfinders.com`
- **Password:** `password123`
- **Role:** Administrator
- **Access:**
  - Approve/Reject properties
  - Manage all users
  - View system statistics
  - Handle contact inquiries
  - Full dashboard access

**Login URL:** http://localhost/Flatfinder/public/login.html

---

## 🏢 Property Owner Accounts

**Purpose:** List and manage rental properties

### Owner 1 - Abdul Rahman
- **Email:** `abdul.rahman@gmail.com`
- **Password:** `password123`
- **Phone:** +880-1711-111111
- **Properties:** 4 properties listed
- **Role:** Owner

### Owner 2 - Fatima Begum
- **Email:** `fatima.begum@gmail.com`
- **Password:** `password123`
- **Phone:** +880-1712-222222
- **Properties:** 3 properties listed
- **Role:** Owner

### Owner 3 - Karim Ahmed
- **Email:** `karim.ahmed@yahoo.com`
- **Password:** `password123`
- **Phone:** +880-1713-333333
- **Properties:** 2 properties listed
- **Role:** Owner

### Owner 4 - Ayesha Khan
- **Email:** `ayesha.khan@gmail.com`
- **Password:** `password123`
- **Phone:** +880-1714-444444
- **Properties:** 3 properties listed
- **Role:** Owner

### Owner 5 - Mohammad Hasan
- **Email:** `mohammad.hasan@outlook.com`
- **Password:** `password123`
- **Phone:** +880-1715-555555
- **Properties:** 3 properties listed
- **Role:** Owner

**Login URL:** http://localhost/Flatfinder/public/login.html

---

## 👥 Customer Accounts

**Purpose:** Search properties, make inquiries, save favorites

### Customer 1 - Rafiq Ahmed
- **Email:** `rafiq.ahmed@gmail.com`
- **Password:** `password123`
- **Phone:** +880-1721-111111
- **Role:** Customer

### Customer 2 - Sultana Akter
- **Email:** `sultana.akter@gmail.com`
- **Password:** `password123`
- **Phone:** +880-1722-222222
- **Role:** Customer

### Customer 3 - Tanvir Islam
- **Email:** `tanvir.islam@yahoo.com`
- **Password:** `password123`
- **Phone:** +880-1723-333333
- **Role:** Customer

### Customer 4 - Nadia Rahman
- **Email:** `nadia.rahman@gmail.com`
- **Password:** `password123`
- **Phone:** +880-1724-444444
- **Role:** Customer

### Customer 5 - Imran Hossain
- **Email:** `imran.hossain@outlook.com`
- **Password:** `password123`
- **Phone:** +880-1725-555555
- **Role:** Customer

### Customer 6 - Sabrina Chowdhury
- **Email:** `sabrina.ch@gmail.com`
- **Password:** `password123`
- **Phone:** +880-1726-666666
- **Role:** Customer

### Customer 7 - Jahangir Alam
- **Email:** `jahangir.alam@yahoo.com`
- **Password:** `password123`
- **Phone:** +880-1727-777777
- **Role:** Customer

### Customer 8 - Farzana Yasmin
- **Email:** `farzana.yasmin@gmail.com`
- **Password:** `password123`
- **Phone:** +880-1728-888888
- **Role:** Customer

### Customer 9 - Shakil Ahmed
- **Email:** `shakil.ahmed@gmail.com`
- **Password:** `password123`
- **Phone:** +880-1729-999999
- **Role:** Customer

**Login URL:** http://localhost/Flatfinder/public/login.html

---

## 📊 Database Credentials

**Database Name:** `flatfinders_db`
**MySQL Host:** `localhost`
**MySQL User:** `root`
**MySQL Password:** *(empty/blank)*
**Port:** `3306`
**phpMyAdmin URL:** http://localhost/phpmyadmin

---

## 🔑 Important Security Notes

⚠️ **WARNING: These are development credentials only!**

- Change all passwords before deploying to production
- Update the database credentials in `backend/config/database.php`
- Enable email verification in production
- Use strong, unique passwords for all accounts
- Enable HTTPS in production environment
- Update the JWT secret key in `backend/config/config.php`

---

## 📋 Sample Data Statistics

The database includes:
- **15 Users** (1 admin, 5 owners, 9 customers)
- **15 Properties** (13 approved, 2 pending)
- **12 Inquiries** (various statuses)
- **14 Favorites** (across different users)
- **12 Notifications** (for owners and customers)
- **10 Contact Messages** (various statuses)
- **12 Amenities** (wifi, AC, parking, etc.)
- **15+ Property Images**
- **Recently Viewed** tracking data

---

## 🎯 Quick Start

1. Start XAMPP (Apache + MySQL)
2. Open: http://localhost/Flatfinder/setup.php
3. Click "Run Setup" to initialize database
4. Login with any of the above credentials
5. Explore the platform!

---

## 📞 Support

For issues or questions:
- Check the `README.md` file
- Review `XAMPP_SETUP_GUIDE.md`
- Check error logs in XAMPP control panel

---

**Last Updated:** December 12, 2025
**Version:** 1.0.0
