# ⚡ FlatFinders - Quick Start Guide

**Get up and running in 5 minutes!**

---

## 🎯 Prerequisites Checklist

Before starting, ensure:
- ✅ Windows 10 or later
- ✅ 2GB free disk space
- ✅ XAMPP installed (download from https://www.apachefriends.org/)
- ✅ Apache and MySQL running in XAMPP Control Panel

---

## 🚀 3-Step Installation

### Step 1: Copy Project (30 seconds)
```
1. Locate: C:\Users\sheik\Desktop\Flatfinder
2. Copy the entire folder
3. Paste to: C:\xampp\htdocs\
4. Result: C:\xampp\htdocs\Flatfinder\
```

### Step 2: Setup Database (1 minute)
```
1. Open browser
2. Go to: http://localhost/Flatfinder/setup.php
3. Click "🚀 Run Setup" button
4. Wait for success message
5. Done!
```

### Step 3: Start Using (30 seconds)
```
1. Go to: http://localhost/Flatfinder/
2. Click "Login"
3. Use any credentials below
4. Start exploring!
```

---

## 🔑 Login Credentials (Password: password123)

### Try These Accounts:

**Admin Account:**
```
Email:    admin@flatfinders.com
Password: password123
Access:   Full system control
```

**Property Owner:**
```
Email:    abdul.rahman@gmail.com
Password: password123
Access:   Manage properties, view inquiries
```

**Customer:**
```
Email:    rafiq.ahmed@gmail.com
Password: password123
Access:   Search properties, save favorites
```

---

## 🌐 Important URLs

| Purpose | URL |
|---------|-----|
| Homepage | http://localhost/Flatfinder/ |
| Login | http://localhost/Flatfinder/public/login.html |
| Setup | http://localhost/Flatfinder/setup.php |
| phpMyAdmin | http://localhost/phpmyadmin |
| API Docs | http://localhost/Flatfinder/backend/ |

---

## 🎨 What You Can Do

### As Admin
- ✅ Approve/reject property listings
- ✅ View system statistics
- ✅ Manage all users
- ✅ Handle contact inquiries

### As Owner
- ✅ Post property listings
- ✅ Manage your properties
- ✅ View and respond to inquiries
- ✅ Track property views

### As Customer
- ✅ Search and filter properties
- ✅ Save favorite properties
- ✅ Send inquiries to owners
- ✅ Get property recommendations

---

## 📊 What's Already There

The database includes:
- **15 Users** (1 admin, 5 owners, 9 customers)
- **15 Properties** (various types and locations)
- **12 Inquiries** (sample customer inquiries)
- **14 Favorites** (saved properties)
- **12 Notifications** (system notifications)

All ready to explore!

---

## 🔧 Troubleshooting

### Problem: "Database connection failed"
**Solution:**
1. Open XAMPP Control Panel
2. Check MySQL is running (should be green)
3. Click "Start" if it's not running

### Problem: "404 Not Found"
**Solution:**
1. Verify files are in: `C:\xampp\htdocs\Flatfinder\`
2. Check Apache is running in XAMPP
3. Use correct URL: `http://localhost/Flatfinder/`

### Problem: "Setup button doesn't work"
**Solution:**
1. Refresh the page
2. Check browser console (F12) for errors
3. Try manual setup via phpMyAdmin

### Problem: "Can't login"
**Solution:**
1. Make sure setup completed successfully
2. Verify credentials (password is: password123)
3. Clear browser cookies and try again

---

## 📖 Need More Help?

| Document | Purpose |
|----------|---------|
| **CREDENTIALS.md** | All 15 user accounts |
| **XAMPP_SETUP_GUIDE.md** | Detailed setup instructions |
| **API_TESTING_GUIDE.md** | Test all API endpoints |
| **PROJECT_SUMMARY.md** | Complete project overview |

---

## ⚠️ Important Notes

1. **Default Password:** All accounts use `password123`
2. **Change Passwords:** Before production use
3. **Development Only:** This setup is for local development
4. **Port 80:** Make sure no other program is using it
5. **Backup Data:** Before making changes

---

## 🎯 Quick Test Flow

### Test as Customer (5 minutes):
```
1. Login: rafiq.ahmed@gmail.com / password123
2. Browse properties on homepage
3. Click on a property to view details
4. Click "Add to Favorites" ⭐
5. Send an inquiry
6. Check notifications 🔔
7. View your dashboard
8. Logout
```

### Test as Owner (5 minutes):
```
1. Login: abdul.rahman@gmail.com / password123
2. View your dashboard
3. Click "Post Property" ➕
4. Fill in property details
5. View inquiries received
6. Check your property statistics
7. Edit a property
8. Logout
```

### Test as Admin (5 minutes):
```
1. Login: admin@flatfinders.com / password123
2. View system statistics
3. Check pending properties
4. Approve a property ✅
5. View all users
6. Check contact messages
7. View analytics
8. Logout
```

---

## 📱 Test Responsive Design

1. **Desktop View:**
   - Open normally in browser
   - Should show full layout

2. **Mobile View:**
   - Press F12 (DevTools)
   - Click "Toggle Device Toolbar"
   - Select a mobile device
   - Test navigation and features

3. **Tablet View:**
   - Select iPad or similar
   - Verify layout adapts

---

## ✅ Final Checklist

Before considering setup complete:

- [x] XAMPP installed
- [x] Apache running (green)
- [x] MySQL running (green)
- [x] Project in htdocs
- [x] Database created
- [x] Sample data inserted
- [x] Can access homepage
- [x] Can login successfully
- [x] Can browse properties
- [x] No errors in browser console

---

## 🎓 Learning Resources

### Explore the Code:
```
Frontend:  public/assets/css/style.css (3240 lines)
Backend:   backend/api/ (26 endpoints)
Database:  backend/database/schema.sql
```

### Try the APIs:
```
1. Use Postman or browser
2. Follow API_TESTING_GUIDE.md
3. Test with different user roles
```

### Customize:
```
1. Colors:     public/assets/css/style.css
2. Config:     backend/config/config.php
3. Database:   backend/config/database.php
```

---

## 💡 Pro Tips

1. **Use Browser DevTools (F12):**
   - Check console for errors
   - Monitor network requests
   - Debug JavaScript

2. **Check Logs:**
   - PHP errors: `C:\xampp\apache\logs\error.log`
   - MySQL errors: `C:\xampp\mysql\data\*.err`

3. **Backup Database:**
   - Go to phpMyAdmin
   - Select `flatfinders_db`
   - Click Export
   - Save SQL file

4. **Reset Database:**
   - Go to phpMyAdmin
   - Drop `flatfinders_db`
   - Run setup.php again

5. **Test API with cURL:**
   ```bash
   curl http://localhost/Flatfinder/backend/api/auth/session.php
   ```

---

## 🎉 You're Ready!

Your FlatFinders platform is now:
- ✅ Fully installed
- ✅ Database populated
- ✅ Ready to use
- ✅ Ready to customize

**Start Exploring:**
http://localhost/Flatfinder/

**Login and try:**
- Browse properties 🏠
- Save favorites ⭐
- Send inquiries 💬
- Manage listings 📝
- View analytics 📊

---

## 📞 Need More Help?

**If you're stuck:**
1. Read XAMPP_SETUP_GUIDE.md (comprehensive)
2. Check PROJECT_SUMMARY.md (overview)
3. Test APIs with API_TESTING_GUIDE.md
4. Review error logs
5. Restart Apache and MySQL

**Common Issues:**
- Port already in use → Change Apache port
- Database not found → Run setup.php again
- Can't login → Check credentials (password123)
- Page not found → Check file path

---

## 🌟 Have Fun!

You now have a complete property rental platform with:
- 15 users ready to test
- 15 properties to browse
- Full admin dashboard
- Complete API backend
- Responsive frontend
- Professional design

**Enjoy exploring FlatFinders! 🏠🎊**

---

**Version:** 1.0.0  
**Setup Time:** ~5 minutes  
**Default Password:** password123  
**Support:** Check documentation files

---

**Quick Links:**
- 🏠 [Homepage](http://localhost/Flatfinder/)
- 🔑 [Login](http://localhost/Flatfinder/public/login.html)
- 🛠️ [Setup](http://localhost/Flatfinder/setup.php)
- 📊 [phpMyAdmin](http://localhost/phpmyadmin)

**Happy property hunting! 🎯**
