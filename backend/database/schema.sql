-- =============================================
-- FlatFinders Database Schema
-- Property Rental Platform
-- =============================================

-- Create database
CREATE DATABASE IF NOT EXISTS flatfinders_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE flatfinders_db;

-- =============================================
-- Table: users
-- Stores all user accounts (admin, owner, customer)
-- =============================================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'owner', 'customer') DEFAULT 'customer',
    profile_image VARCHAR(255),
    status ENUM('active', 'suspended', 'deleted') DEFAULT 'active',
    email_verified BOOLEAN DEFAULT FALSE,
    verification_token VARCHAR(100),
    reset_token VARCHAR(100),
    reset_token_expiry DATETIME,
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: properties
-- Stores property listings
-- =============================================
CREATE TABLE IF NOT EXISTS properties (
    id INT PRIMARY KEY AUTO_INCREMENT,
    owner_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    property_type ENUM('bachelor', 'apartment', 'house', 'studio', 'sublet') NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    bedrooms INT NOT NULL,
    bathrooms INT NOT NULL,
    area_sqft INT NOT NULL,
    floor VARCHAR(20),
    location VARCHAR(100) NOT NULL,
    city VARCHAR(50) DEFAULT 'Dhaka',
    address VARCHAR(255) NOT NULL,
    nearby_places TEXT,
    is_bachelor_only BOOLEAN DEFAULT FALSE,
    is_furnished BOOLEAN DEFAULT FALSE,
    contact_name VARCHAR(100) NOT NULL,
    contact_phone VARCHAR(20) NOT NULL,
    contact_email VARCHAR(100) NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'inactive') DEFAULT 'pending',
    views INT DEFAULT 0,
    featured BOOLEAN DEFAULT FALSE,
    available_from DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_owner (owner_id),
    INDEX idx_type (property_type),
    INDEX idx_location (location),
    INDEX idx_price (price),
    INDEX idx_status (status),
    INDEX idx_featured (featured),
    FULLTEXT KEY ft_search (title, description, location)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: property_images
-- Stores multiple images for each property
-- =============================================
CREATE TABLE IF NOT EXISTS property_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    INDEX idx_property (property_id),
    INDEX idx_primary (is_primary)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: amenities
-- Master list of available amenities
-- =============================================
CREATE TABLE IF NOT EXISTS amenities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    icon VARCHAR(50),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default amenities
INSERT INTO amenities (name, icon, display_order) VALUES
('wifi', 'wifi', 1),
('ac', 'air_conditioner', 2),
('parking', 'parking', 3),
('security', 'security', 4),
('elevator', 'elevator', 5),
('generator', 'generator', 6),
('gas', 'gas', 7),
('cctv', 'cctv', 8),
('balcony', 'balcony', 9),
('furnished', 'furniture', 10),
('gym', 'gym', 11),
('rooftop', 'rooftop', 12)
ON DUPLICATE KEY UPDATE name=name;

-- =============================================
-- Table: property_amenities
-- Many-to-many relationship between properties and amenities
-- =============================================
CREATE TABLE IF NOT EXISTS property_amenities (
    property_id INT NOT NULL,
    amenity_id INT NOT NULL,
    PRIMARY KEY (property_id, amenity_id),
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (amenity_id) REFERENCES amenities(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: inquiries
-- Stores customer inquiries about properties
-- =============================================
CREATE TABLE IF NOT EXISTS inquiries (
    id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    customer_id INT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied', 'closed') DEFAULT 'new',
    replied_at DATETIME,
    reply_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_property (property_id),
    INDEX idx_customer (customer_id),
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: favorites
-- Stores user's favorite properties
-- =============================================
CREATE TABLE IF NOT EXISTS favorites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    property_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_favorite (user_id, property_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_property (property_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: recently_viewed
-- Tracks recently viewed properties by users
-- =============================================
CREATE TABLE IF NOT EXISTS recently_viewed (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    property_id INT NOT NULL,
    session_id VARCHAR(100),
    viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_session (session_id),
    INDEX idx_property (property_id),
    INDEX idx_viewed (viewed_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: notifications
-- Stores user notifications
-- =============================================
CREATE TABLE IF NOT EXISTS notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    link VARCHAR(255),
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_read (is_read),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: contacts
-- Stores contact form submissions
-- =============================================
CREATE TABLE IF NOT EXISTS contacts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('new', 'in_progress', 'resolved') DEFAULT 'new',
    replied_at DATETIME,
    reply_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Create default admin user
-- Email: admin@flatfinders.com
-- Password: admin123 (PLEASE CHANGE IN PRODUCTION!)
-- =============================================
INSERT INTO users (name, email, phone, password_hash, role, email_verified, status) VALUES
('Admin User', 'admin@flatfinders.com', '+880-1700-000000', 
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 'admin', TRUE, 'active')
ON DUPLICATE KEY UPDATE name=name;

-- =============================================
-- Create sample owner user
-- Email: owner@flatfinders.com
-- Password: owner123
-- =============================================
INSERT INTO users (name, email, phone, password_hash, role, email_verified, status) VALUES
('Abdul Rahman', 'owner@flatfinders.com', '+880-1711-111111', 
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 'owner', TRUE, 'active')
ON DUPLICATE KEY UPDATE name=name;

-- =============================================
-- Create sample customer user
-- Email: customer@flatfinders.com
-- Password: customer123
-- =============================================
INSERT INTO users (name, email, phone, password_hash, role, email_verified, status) VALUES
('Rafiq Ahmed', 'customer@flatfinders.com', '+880-1722-222222', 
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 'customer', TRUE, 'active')
ON DUPLICATE KEY UPDATE name=name;

