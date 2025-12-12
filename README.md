# 🏠 FlatFinders - Property Rental Platform

> A modern, full-featured property rental platform for Bangladesh, built with PHP, MySQL, HTML, CSS, and JavaScript.

[![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com)
[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1.svg)](https://mysql.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

---

## 📖 Table of Contents

- [Features](#features)
- [Quick Start](#quick-start)
- [Installation](#installation)
- [Documentation](#documentation)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [API Endpoints](#api-endpoints)
- [Login Credentials](#login-credentials)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [License](#license)

---

## ✨ Features

### 🎯 Core Functionality

- **Multi-Role System:** Admin, Property Owner, and Customer accounts
- **Advanced Search:** Filter by location, price, type, amenities, and more
- **Property Management:** Full CRUD operations for property listings
- **Inquiry System:** Customers can send inquiries directly to property owners
- **Favorites:** Save and manage favorite properties
- **Notifications:** Real-time notification system for all user actions
- **Responsive Design:** Works seamlessly on desktop, tablet, and mobile
- **RESTful API:** Well-documented JSON API for all operations

### 👥 User Roles

#### Admin
- Approve or reject property listings
- Manage all users
- View system-wide analytics and statistics
- Handle contact form submissions
- Full system control

#### Property Owner
- List unlimited properties
- Manage property listings (edit, update, delete)
- Receive and respond to inquiries
- Track property views and statistics
- Get notifications for new inquiries

#### Customer
- Search and filter properties
- View detailed property information
- Save favorite properties
- Send inquiries to property owners
- Receive notifications for inquiry responses

---

## 🚀 Quick Start

### Prerequisites

- **XAMPP** (Apache + MySQL + PHP)
- **Web Browser** (Chrome, Firefox, or Edge recommended)
- **2GB free disk space**

### Installation (5 minutes)

1. **Install XAMPP**
   ```
   Download from: https://www.apachefriends.org/
   Install to: C:\xampp\
   ```

2. **Copy Project Files**
   ```
   Copy Flatfinder folder to: C:\xampp\htdocs\
   ```

3. **Start Services**
   ```
   Open XAMPP Control Panel
   Start Apache
   Start MySQL
   ```

4. **Setup Database**
   ```
   Open browser: http://localhost/Flatfinder/setup.php
   Click "Run Setup"
   Wait for success message
   ```

5. **Access Application**
   ```
   Homepage: http://localhost/Flatfinder/
   Login: http://localhost/Flatfinder/public/login.html
   ```

**That's it! You're ready to go! 🎉**

---

## 📚 Documentation

Complete guides are available in the following files:

| Document | Description | Size |
|----------|-------------|------|
| **[QUICK_START.md](QUICK_START.md)** | Get started in 5 minutes | 2 pages |
| **[XAMPP_SETUP_GUIDE.md](XAMPP_SETUP_GUIDE.md)** | Complete XAMPP setup guide | 20 pages |
| **[CREDENTIALS.md](CREDENTIALS.md)** | All login credentials | 3 pages |
| **[API_TESTING_GUIDE.md](API_TESTING_GUIDE.md)** | API endpoint documentation | 15 pages |
| **[PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)** | Complete project overview | 10 pages |

**Total Documentation:** 50+ pages of comprehensive guides!

---

## 🛠️ Technology Stack

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling with Flexbox/Grid
- **JavaScript (ES6+)** - Interactive functionality
- **Responsive Design** - Mobile-first approach

### Backend
- **PHP 8.x** - Server-side scripting
- **MySQL 8.x** - Relational database
- **mysqli** - Database connectivity
- **RESTful API** - JSON-based communication

### Development Tools
- **XAMPP** - Local development environment
- **Apache** - Web server
- **phpMyAdmin** - Database management
- **Git** - Version control (optional)

---

## 📁 Project Structure

```
Flatfinder/
├── backend/                    # Backend PHP application
│   ├── api/                   # API endpoints (26 files)
│   │   ├── auth/             # Authentication
│   │   ├── properties/        # Property management
│   │   ├── inquiries/         # Inquiry system
│   │   ├── favorites/         # Favorites management
│   │   ├── notifications/     # Notification system
│   │   ├── users/            # User profiles
│   │   ├── admin/            # Admin functions
│   │   └── contact/          # Contact form
│   ├── config/               # Configuration files
│   ├── database/             # SQL scripts
│   └── includes/             # Reusable functions
│
├── public/                    # Frontend application
│   ├── assets/               # Static assets
│   │   ├── css/             # Stylesheets
│   │   └── js/              # JavaScript files
│   └── *.html               # HTML pages (20+ files)
│
├── setup.php                 # Database setup interface
├── setup-handler.php         # Setup backend
└── Documentation files       # 5 comprehensive guides
```

---

## 📡 API Endpoints

### Authentication
```
POST   /api/auth/login.php          - User login
POST   /api/auth/register.php       - User registration
GET    /api/auth/session.php        - Check session
POST   /api/auth/logout.php         - User logout
```

### Properties
```
GET    /api/properties/list.php     - List properties (public)
GET    /api/properties/get.php      - Get property details (public)
POST   /api/properties/create.php   - Create property (owner/admin)
PUT    /api/properties/update.php   - Update property (owner/admin)
DELETE /api/properties/delete.php   - Delete property (owner/admin)
```

### Inquiries
```
POST   /api/inquiries/create.php    - Create inquiry
GET    /api/inquiries/list.php      - List user inquiries
```

### Favorites
```
POST   /api/favorites/add.php       - Add to favorites
DELETE /api/favorites/remove.php    - Remove from favorites
GET    /api/favorites/list.php      - List favorites
```

### Admin
```
GET    /api/admin/statistics.php    - Get statistics (admin)
GET    /api/admin/users.php         - List all users (admin)
POST   /api/admin/approve-property.php - Approve property (admin)
POST   /api/admin/reject-property.php  - Reject property (admin)
```

**Full API documentation:** See [API_TESTING_GUIDE.md](API_TESTING_GUIDE.md)

---

## 🔑 Login Credentials

### All passwords: `password123`

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@flatfinders.com | password123 |
| **Owner** | abdul.rahman@gmail.com | password123 |
| **Owner** | fatima.begum@gmail.com | password123 |
| **Customer** | rafiq.ahmed@gmail.com | password123 |
| **Customer** | sultana.akter@gmail.com | password123 |

**More accounts available!** See [CREDENTIALS.md](CREDENTIALS.md) for all 15 user accounts.

---

## 🗄️ Database

### Schema
- **10 tables** with proper relationships
- **Full indexing** for optimized queries
- **Foreign key constraints** for data integrity
- **UTF8MB4 encoding** for international support

### Sample Data
- **15 Users:** 1 admin, 5 owners, 9 customers
- **15 Properties:** Various types and locations in Dhaka
- **12 Inquiries:** Sample customer inquiries
- **14 Favorites:** Saved properties
- **12 Notifications:** System notifications
- **10 Contact Messages:** Contact form submissions
- **12 Amenities:** WiFi, AC, Parking, etc.

**Total Records:** 100+ sample data entries ready to explore!

---

## 🎨 Design Features

### Color Palette
- **Primary:** #6C5CE7 (Purple)
- **Success:** #2ECC71 (Green)
- **Danger:** #E74C3C (Red)
- **Background:** #F5F6FA (Light Gray)

### Typography
- **Font Family:** Poppins (Google Fonts)
- **Sizes:** 14px - 36px
- **Weights:** 400, 500, 600, 700

### Responsive Breakpoints
- **Mobile:** < 768px
- **Tablet:** 768px - 1024px
- **Desktop:** > 1024px

---

## 🔒 Security Features

- ✅ **Password Hashing** - bcrypt algorithm
- ✅ **SQL Injection Prevention** - Prepared statements
- ✅ **XSS Protection** - Input sanitization
- ✅ **Session Management** - Secure session handling
- ✅ **File Upload Validation** - Type and size checks
- ✅ **Role-Based Access Control** - Permission system
- ✅ **CSRF Protection** - Token-based (implement in production)

---

## 📊 Statistics

### Code Metrics
- **Total Files:** 50+
- **Lines of Code:** 10,000+
- **API Endpoints:** 26
- **HTML Pages:** 20+
- **Database Tables:** 10
- **Documentation Pages:** 50+

### Features
- **User Roles:** 3 (Admin, Owner, Customer)
- **Property Types:** 5 (Apartment, Bachelor, House, Studio, Sublet)
- **Search Filters:** 8+ (Location, Price, Type, Amenities, etc.)
- **Notification Types:** 4 (Info, Success, Warning, Error)

---

## 📸 Screenshots

### Homepage
```
Modern landing page with featured properties
Property search and filter options
Responsive navigation menu
```

### Property Listings
```
Grid layout with property cards
Advanced filtering sidebar
Sort options (Price, Newest, Popular)
```

### Property Details
```
Image gallery
Full property information
Amenities list
Contact owner button
```

### Dashboards
```
Admin: System statistics and management
Owner: Property management and inquiries
Customer: Favorites and inquiry history
```

---

## 🧪 Testing

### Test Accounts Ready
Login and test all features with pre-configured accounts:
- 1 Admin account
- 5 Owner accounts
- 9 Customer accounts

### API Testing
Use Postman or cURL to test all 26 API endpoints:
```bash
# Example: Login
curl -X POST http://localhost/Flatfinder/backend/api/auth/login.php \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@flatfinders.com","password":"password123"}'
```

See [API_TESTING_GUIDE.md](API_TESTING_GUIDE.md) for complete testing instructions.

---

## 🚀 Deployment

### Production Checklist
- [ ] Change all default passwords
- [ ] Update database credentials
- [ ] Configure email settings (SMTP)
- [ ] Enable HTTPS/SSL
- [ ] Update CORS settings
- [ ] Disable error display
- [ ] Optimize database
- [ ] Setup backup system
- [ ] Configure domain DNS
- [ ] Test all features

---

## 🐛 Troubleshooting

### Common Issues

**Can't access localhost?**
- Check if Apache is running in XAMPP
- Verify project is in `C:\xampp\htdocs\Flatfinder\`
- Make sure no other program is using port 80

**Database connection failed?**
- Check if MySQL is running in XAMPP
- Verify database credentials in `backend/config/database.php`
- Try running setup.php again

**Login not working?**
- Verify database is set up correctly
- Check that sample data was imported
- Clear browser cookies and cache

**See [XAMPP_SETUP_GUIDE.md](XAMPP_SETUP_GUIDE.md) for detailed troubleshooting.**

---

## 📖 Learning Resources

### For Beginners
1. Start with [QUICK_START.md](QUICK_START.md)
2. Read [XAMPP_SETUP_GUIDE.md](XAMPP_SETUP_GUIDE.md)
3. Explore the code in `backend/api/`
4. Customize CSS in `public/assets/css/style.css`

### For Developers
1. Review [API_TESTING_GUIDE.md](API_TESTING_GUIDE.md)
2. Check database schema in `backend/database/schema.sql`
3. Study API architecture
4. Extend with new features

---

## 🎯 Use Cases

### For Students
- Learn full-stack web development
- Understand RESTful API design
- Practice database design
- Study authentication systems

### For Developers
- Use as a starting template
- Learn PHP best practices
- Understand MVC pattern
- Study responsive design

### For Businesses
- Deploy for real estate agencies
- Customize for local market
- Add payment integration
- Extend features as needed

---

## 🔄 Future Enhancements

### Planned Features
- [ ] Email verification system
- [ ] Payment gateway integration
- [ ] Google Maps integration
- [ ] Real-time chat between users
- [ ] Advanced analytics dashboard
- [ ] Social media authentication
- [ ] Mobile application (React Native)
- [ ] Multi-language support

---

## 🤝 Contributing

We welcome contributions! Here's how you can help:

1. **Report Bugs:** Open an issue describing the bug
2. **Suggest Features:** Open an issue with your idea
3. **Submit Pull Requests:** Fork, make changes, submit PR
4. **Improve Documentation:** Fix typos, add examples
5. **Share Feedback:** Tell us what you think!

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**FlatFinders Development Team**
- Version: 1.0.0
- Release Date: December 2025
- Contact: Check documentation files for support

---

## 🙏 Acknowledgments

- **PHP Community** - For excellent documentation
- **MySQL** - For robust database system
- **XAMPP** - For easy development environment
- **Google Fonts** - For beautiful typography
- **You** - For using FlatFinders!

---

## 📞 Support

### Documentation
- 📖 [Quick Start Guide](QUICK_START.md)
- 🛠️ [XAMPP Setup Guide](XAMPP_SETUP_GUIDE.md)
- 🔐 [Login Credentials](CREDENTIALS.md)
- 🧪 [API Testing Guide](API_TESTING_GUIDE.md)
- 📊 [Project Summary](PROJECT_SUMMARY.md)

### Getting Help
1. Check the documentation files
2. Review error logs in `C:\xampp\apache\logs\`
3. Search for similar issues online
4. Contact support (see documentation)

---

## 🌟 Star This Project!

If you find this project helpful:
- ⭐ Star the repository
- 🔀 Fork and customize
- 📣 Share with others
- 💡 Contribute improvements

---

## ✅ Project Status

**Status:** ✅ Complete and Ready to Use

**What's Included:**
- ✅ Complete backend API (26 endpoints)
- ✅ Responsive frontend (20+ pages)
- ✅ Database with sample data (100+ records)
- ✅ User authentication system
- ✅ Admin dashboard
- ✅ Owner dashboard
- ✅ Customer dashboard
- ✅ Comprehensive documentation (50+ pages)
- ✅ One-click setup
- ✅ Production-ready code

---

## 🎊 Get Started Now!

```bash
1. Download XAMPP: https://www.apachefriends.org/
2. Install and start Apache + MySQL
3. Copy project to C:\xampp\htdocs\
4. Visit: http://localhost/Flatfinder/setup.php
5. Click "Run Setup"
6. Login and explore!
```

**Default Login:**
```
Email: admin@flatfinders.com
Password: password123
```

---

## 📈 Version History

### Version 1.0.0 (December 2025)
- ✨ Initial release
- 🎯 Complete feature set
- 📖 Comprehensive documentation
- 🗄️ Sample data included
- 🚀 Ready for production

---

## 🏆 Features Highlights

- **26 API Endpoints** - Complete REST API
- **10 Database Tables** - Normalized structure
- **15 Sample Users** - Ready to test
- **15 Sample Properties** - Real-world data
- **3 User Roles** - Admin, Owner, Customer
- **20+ HTML Pages** - Full frontend
- **3,240 Lines CSS** - Beautiful design
- **50+ Documentation Pages** - Everything explained

---

## 💬 Feedback

We'd love to hear from you!
- 📧 Send feedback
- 🐛 Report bugs
- 💡 Suggest features
- ⭐ Rate the project

---

**Happy Coding! 🚀**

---

**Links:**
- 🏠 [Homepage](http://localhost/Flatfinder/)
- 🔑 [Login](http://localhost/Flatfinder/public/login.html)
- 🛠️ [Setup](http://localhost/Flatfinder/setup.php)
- 📊 [phpMyAdmin](http://localhost/phpmyadmin)
- 📚 [Documentation](QUICK_START.md)

---

*Made with ❤️ for property seekers in Bangladesh*

---

**Last Updated:** December 12, 2025  
**Version:** 1.0.0  
**Status:** Production Ready ✅
