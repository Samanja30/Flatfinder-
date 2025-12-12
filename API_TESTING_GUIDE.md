# 🧪 FlatFinders - API Testing Guide

Complete guide for testing all API endpoints with sample requests and responses.

---

## 🔑 Authentication Required

Most endpoints require authentication. Use the session cookie returned after login.

---

## 📍 Base URL

```
http://localhost/Flatfinder/backend/api/
```

---

## 1️⃣ Authentication Endpoints

### 1.1 User Login

**Endpoint:** `POST /auth/login.php`

**Request Body:**
```json
{
  "email": "admin@flatfinders.com",
  "password": "password123"
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@flatfinders.com",
      "phone": "+880-1700-000000",
      "role": "admin",
      "profile_image": null
    }
  }
}
```

### 1.2 User Registration

**Endpoint:** `POST /auth/register.php`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "phone": "+880-1234567890",
  "role": "customer"
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Registration successful",
  "data": {
    "user": {
      "id": 16,
      "name": "John Doe",
      "email": "john@example.com",
      "role": "customer",
      "phone": "+880-1234567890"
    }
  }
}
```

### 1.3 Check Session

**Endpoint:** `GET /auth/session.php`

**Response (Success):**
```json
{
  "success": true,
  "message": "Session is valid",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@flatfinders.com",
      "phone": "+880-1700-000000",
      "role": "admin",
      "profile_image": null
    }
  }
}
```

### 1.4 Logout

**Endpoint:** `POST /auth/logout.php`

**Response (Success):**
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

---

## 2️⃣ Property Endpoints

### 2.1 List Properties (Public)

**Endpoint:** `GET /properties/list.php`

**Query Parameters:**
- `location` - Filter by location (e.g., "Dhanmondi")
- `type` - Filter by property type (bachelor, apartment, house, studio, sublet)
- `minPrice` - Minimum price
- `maxPrice` - Maximum price
- `bedrooms` - Minimum bedrooms
- `bachelorOnly` - Filter bachelor-only (true/false)
- `amenities` - Comma-separated amenities (e.g., "wifi,ac,parking")
- `search` - Search in title, description, location
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 12)
- `sort` - Sort order (newest, price-low, price-high, popular)

**Example Request:**
```
GET /properties/list.php?location=Dhanmondi&minPrice=10000&maxPrice=50000&bedrooms=2&amenities=wifi,ac&page=1
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Properties retrieved successfully",
  "data": {
    "properties": [
      {
        "id": 1,
        "title": "Spacious 3 Bedroom Apartment in Dhanmondi",
        "description": "Beautiful and spacious 3 bedroom apartment...",
        "type": "apartment",
        "price": 35000,
        "bedrooms": 3,
        "bathrooms": 2,
        "area_sqft": 1400,
        "floor": "5th Floor",
        "location": "Dhanmondi",
        "city": "Dhaka",
        "address": "Road 15, Block A, Dhanmondi, Dhaka 1209",
        "is_bachelor_only": false,
        "contact_name": "Abdul Rahman",
        "contact_phone": "+880-1711-111111",
        "contact_email": "abdul.rahman@gmail.com",
        "views": 245,
        "featured": true,
        "primary_image": "properties/prop1_main.jpg",
        "amenities": ["wifi", "ac", "parking", "elevator", "gas"],
        "created_at": "2024-02-15 10:30:00"
      }
    ],
    "pagination": {
      "current_page": 1,
      "per_page": 12,
      "total": 13,
      "total_pages": 2
    }
  }
}
```

### 2.2 Get Single Property

**Endpoint:** `GET /properties/get.php?id={property_id}`

**Response (Success):**
```json
{
  "success": true,
  "message": "Property retrieved successfully",
  "data": {
    "property": {
      "id": 1,
      "title": "Spacious 3 Bedroom Apartment in Dhanmondi",
      "description": "Full description here...",
      "type": "apartment",
      "price": 35000,
      "bedrooms": 3,
      "bathrooms": 2,
      "area_sqft": 1400,
      "floor": "5th Floor",
      "location": "Dhanmondi",
      "city": "Dhaka",
      "address": "Road 15, Block A, Dhanmondi, Dhaka 1209",
      "nearby_places": "Dhanmondi Lake, City College, ISD Road",
      "is_bachelor_only": false,
      "is_furnished": true,
      "contact_name": "Abdul Rahman",
      "contact_phone": "+880-1711-111111",
      "contact_email": "abdul.rahman@gmail.com",
      "views": 246,
      "featured": true,
      "available_from": "2024-04-01",
      "created_at": "2024-02-15 10:30:00",
      "images": [
        {
          "path": "properties/prop1_main.jpg",
          "is_primary": true
        },
        {
          "path": "properties/prop1_living.jpg",
          "is_primary": false
        }
      ],
      "amenities": [
        {
          "name": "wifi",
          "icon": "wifi"
        },
        {
          "name": "ac",
          "icon": "air_conditioner"
        }
      ],
      "owner": {
        "name": "Abdul Rahman",
        "email": "abdul.rahman@gmail.com",
        "phone": "+880-1711-111111"
      }
    }
  }
}
```

### 2.3 Create Property (Owner/Admin)

**Endpoint:** `POST /properties/create.php`

**Authentication:** Required (Owner or Admin)

**Request Body (multipart/form-data):**
```
title: "New Apartment in Gulshan"
description: "Beautiful 2 bedroom apartment with modern amenities..."
type: "apartment"
price: 45000
bedrooms: 2
bathrooms: 2
area: 1100
floor: "7th Floor"
location: "Gulshan"
city: "Dhaka"
address: "Road 42, Gulshan 2, Dhaka"
nearbyPlaces: "Gulshan Lake, Restaurants"
bachelorOnly: false
contactName: "John Doe"
contactPhone: "+880-1234567890"
contactEmail: "john@example.com"
amenities: ["wifi", "ac", "parking"]
images: [file1, file2, file3]
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Property submitted for review successfully",
  "data": {
    "property_id": 16,
    "status": "pending"
  }
}
```

### 2.4 Update Property (Owner/Admin)

**Endpoint:** `PUT /properties/update.php?id={property_id}`

**Authentication:** Required (Owner of property or Admin)

**Request Body:**
```json
{
  "title": "Updated Title",
  "price": 48000,
  "description": "Updated description..."
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Property updated successfully"
}
```

### 2.5 Delete Property (Owner/Admin)

**Endpoint:** `DELETE /properties/delete.php?id={property_id}`

**Authentication:** Required (Owner of property or Admin)

**Response (Success):**
```json
{
  "success": true,
  "message": "Property deleted successfully"
}
```

---

## 3️⃣ Inquiry Endpoints

### 3.1 Create Inquiry

**Endpoint:** `POST /inquiries/create.php`

**Request Body:**
```json
{
  "property_id": 1,
  "name": "Rafiq Ahmed",
  "email": "rafiq@example.com",
  "phone": "+880-1234567890",
  "message": "I am interested in this property. Can I schedule a visit?"
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Inquiry sent successfully",
  "data": {
    "inquiry_id": 13
  }
}
```

### 3.2 List Inquiries

**Endpoint:** `GET /inquiries/list.php`

**Authentication:** Required

**Query Parameters:**
- `status` - Filter by status (new, read, replied, closed)
- `page` - Page number
- `per_page` - Items per page

**Response (Success - Owner):**
```json
{
  "success": true,
  "message": "Inquiries retrieved successfully",
  "data": {
    "inquiries": [
      {
        "id": 1,
        "name": "Rafiq Ahmed",
        "email": "rafiq.ahmed@gmail.com",
        "phone": "+880-1721-111111",
        "message": "Hello, I am interested in this apartment...",
        "status": "new",
        "created_at": "2024-03-15 10:30:00",
        "property": {
          "id": 1,
          "title": "Spacious 3 Bedroom Apartment in Dhanmondi",
          "price": 35000
        }
      }
    ],
    "pagination": {
      "current_page": 1,
      "per_page": 20,
      "total": 3,
      "total_pages": 1
    }
  }
}
```

---

## 4️⃣ Favorites Endpoints

### 4.1 Add to Favorites

**Endpoint:** `POST /favorites/add.php`

**Authentication:** Required

**Request Body:**
```json
{
  "property_id": 3
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Property added to favorites",
  "data": {
    "favorite_id": 15
  }
}
```

### 4.2 Remove from Favorites

**Endpoint:** `DELETE /favorites/remove.php?property_id={property_id}`

**Authentication:** Required

**Response (Success):**
```json
{
  "success": true,
  "message": "Property removed from favorites"
}
```

### 4.3 List Favorites

**Endpoint:** `GET /favorites/list.php`

**Authentication:** Required

**Response (Success):**
```json
{
  "success": true,
  "message": "Favorites retrieved successfully",
  "data": {
    "favorites": [
      {
        "favorite_id": 1,
        "favorited_at": "2024-03-10 10:00:00",
        "property": {
          "id": 1,
          "title": "Spacious 3 Bedroom Apartment in Dhanmondi",
          "description": "Beautiful and spacious...",
          "type": "apartment",
          "price": 35000,
          "bedrooms": 3,
          "bathrooms": 2,
          "area_sqft": 1400,
          "location": "Dhanmondi",
          "city": "Dhaka",
          "is_bachelor_only": false,
          "contact_name": "Abdul Rahman",
          "contact_phone": "+880-1711-111111",
          "contact_email": "abdul.rahman@gmail.com",
          "primary_image": "properties/prop1_main.jpg"
        }
      }
    ],
    "total": 3
  }
}
```

---

## 5️⃣ Notification Endpoints

### 5.1 List Notifications

**Endpoint:** `GET /notifications/list.php`

**Authentication:** Required

**Query Parameters:**
- `unread_only` - Show only unread (true/false)
- `limit` - Number of notifications (default: 20)

**Response (Success):**
```json
{
  "success": true,
  "message": "Notifications retrieved successfully",
  "data": {
    "notifications": [
      {
        "id": 1,
        "title": "Property Approved",
        "message": "Your property 'Spacious 3 Bedroom Apartment in Dhanmondi' has been approved!",
        "type": "success",
        "link": "/property-detail.html?id=1",
        "is_read": false,
        "created_at": "2024-03-01 09:00:00",
        "read_at": null,
        "time_ago": "2 days ago"
      }
    ],
    "unread_count": 2,
    "total": 3
  }
}
```

### 5.2 Mark Notification as Read

**Endpoint:** `POST /notifications/mark-read.php`

**Authentication:** Required

**Request Body (Single):**
```json
{
  "notification_id": 1
}
```

**Request Body (All):**
```json
{
  "mark_all": true
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Notification marked as read"
}
```

---

## 6️⃣ User Profile Endpoints

### 6.1 Get User Profile

**Endpoint:** `GET /users/profile.php`

**Authentication:** Required

**Query Parameters:**
- `id` - User ID (optional, defaults to current user)

**Response (Success - Owner):**
```json
{
  "success": true,
  "message": "Profile retrieved successfully",
  "data": {
    "user": {
      "id": 2,
      "name": "Abdul Rahman",
      "email": "abdul.rahman@gmail.com",
      "phone": "+880-1711-111111",
      "role": "owner",
      "profile_image": null,
      "status": "active",
      "email_verified": true,
      "created_at": "2024-01-05 14:30:00",
      "last_login": "2024-03-26 10:00:00",
      "property_stats": {
        "total_properties": 4,
        "approved_properties": 3,
        "pending_properties": 1,
        "total_views": 1011
      }
    }
  }
}
```

### 6.2 Update User Profile

**Endpoint:** `PUT /users/update-profile.php`

**Authentication:** Required

**Request Body:**
```json
{
  "name": "Updated Name",
  "phone": "+880-1234567890",
  "current_password": "password123",
  "new_password": "newpassword123"
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Profile updated successfully",
  "data": {
    "user": {
      "id": 2,
      "name": "Updated Name",
      "email": "abdul.rahman@gmail.com",
      "phone": "+880-1234567890",
      "role": "owner",
      "profile_image": null,
      "status": "active"
    }
  }
}
```

---

## 7️⃣ Admin Endpoints

### 7.1 Get Statistics

**Endpoint:** `GET /admin/statistics.php`

**Authentication:** Required (Admin only)

**Response (Success):**
```json
{
  "success": true,
  "message": "Statistics retrieved successfully",
  "data": {
    "statistics": {
      "total_properties": 15,
      "pending_properties": 2,
      "approved_properties": 13,
      "total_users": 15,
      "active_users": 15,
      "users_by_role": {
        "admin": 1,
        "owner": 5,
        "customer": 9
      },
      "total_inquiries": 12,
      "new_inquiries": 5,
      "properties_by_type": {
        "apartment": 6,
        "bachelor": 3,
        "house": 2,
        "studio": 2
      },
      "monthly_properties": [
        {
          "month": "2024-02",
          "count": 8
        },
        {
          "month": "2024-03",
          "count": 7
        }
      ],
      "recent_activity": []
    }
  }
}
```

### 7.2 List All Users

**Endpoint:** `GET /admin/users.php`

**Authentication:** Required (Admin only)

**Query Parameters:**
- `role` - Filter by role (admin, owner, customer)
- `status` - Filter by status (active, suspended, deleted)
- `search` - Search in name, email, phone
- `page` - Page number
- `per_page` - Items per page

**Response (Success):**
```json
{
  "success": true,
  "message": "Users retrieved successfully",
  "data": {
    "users": [
      {
        "id": 1,
        "name": "Admin User",
        "email": "admin@flatfinders.com",
        "phone": "+880-1700-000000",
        "role": "admin",
        "status": "active",
        "email_verified": true,
        "last_login": "2024-03-26 09:00:00",
        "created_at": "2024-01-01 10:00:00"
      }
    ],
    "pagination": {
      "current_page": 1,
      "per_page": 20,
      "total": 15,
      "total_pages": 1
    }
  }
}
```

### 7.3 Approve Property

**Endpoint:** `POST /admin/approve-property.php`

**Authentication:** Required (Admin only)

**Request Body:**
```json
{
  "property_id": 14
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Property approved successfully"
}
```

### 7.4 Reject Property

**Endpoint:** `POST /admin/reject-property.php`

**Authentication:** Required (Admin only)

**Request Body:**
```json
{
  "property_id": 15,
  "reason": "Property does not meet quality standards"
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Property rejected successfully"
}
```

---

## 8️⃣ Contact Endpoint

### 8.1 Submit Contact Form

**Endpoint:** `POST /contact/submit.php`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+880-1234567890",
  "subject": "General Inquiry",
  "message": "I have a question about listing properties..."
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Your message has been sent successfully. We will get back to you soon!",
  "data": {
    "contact_id": 11
  }
}
```

---

## 🧪 Testing with cURL

### Example: Login
```bash
curl -X POST http://localhost/Flatfinder/backend/api/auth/login.php \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@flatfinders.com","password":"password123"}' \
  -c cookies.txt
```

### Example: List Properties
```bash
curl -X GET "http://localhost/Flatfinder/backend/api/properties/list.php?location=Dhanmondi" \
  -H "Content-Type: application/json"
```

### Example: Create Inquiry (with session)
```bash
curl -X POST http://localhost/Flatfinder/backend/api/inquiries/create.php \
  -H "Content-Type: application/json" \
  -b cookies.txt \
  -d '{"property_id":1,"name":"Test User","email":"test@example.com","phone":"+880-1234567890","message":"I am interested"}'
```

---

## 🧪 Testing with Postman

1. **Import Collection:**
   - Create a new collection in Postman
   - Add all endpoints from this guide

2. **Set Environment Variables:**
   - `base_url`: `http://localhost/Flatfinder/backend/api`

3. **Enable Cookies:**
   - Go to Postman Settings
   - Enable "Automatically follow redirects"
   - Enable "Send cookies with requests"

4. **Test Flow:**
   - Login first (stores session cookie)
   - Test other authenticated endpoints
   - Logout when done

---

## ⚠️ Common Error Responses

### 400 Bad Request
```json
{
  "success": false,
  "message": "Email is required"
}
```

### 401 Unauthorized
```json
{
  "success": false,
  "message": "Unauthorized access"
}
```

### 403 Forbidden
```json
{
  "success": false,
  "message": "Insufficient permissions"
}
```

### 404 Not Found
```json
{
  "success": false,
  "message": "Property not found"
}
```

### 500 Internal Server Error
```json
{
  "success": false,
  "message": "Database connection failed"
}
```

---

## 📝 Testing Checklist

### Authentication
- ✅ Login with admin account
- ✅ Login with owner account
- ✅ Login with customer account
- ✅ Login with invalid credentials (should fail)
- ✅ Register new user
- ✅ Check session
- ✅ Logout

### Properties
- ✅ List all properties
- ✅ Filter properties by location
- ✅ Filter properties by price range
- ✅ Search properties
- ✅ Get single property details
- ✅ Create new property (as owner)
- ✅ Update property (as owner)
- ✅ Delete property (as owner)

### Inquiries
- ✅ Create inquiry (logged in)
- ✅ Create inquiry (not logged in)
- ✅ List inquiries (as owner)
- ✅ List inquiries (as customer)

### Favorites
- ✅ Add property to favorites
- ✅ List user favorites
- ✅ Remove from favorites

### Admin
- ✅ View statistics
- ✅ List all users
- ✅ Approve pending property
- ✅ Reject pending property

---

**API Testing Guide Version:** 1.0.0  
**Last Updated:** December 12, 2025
