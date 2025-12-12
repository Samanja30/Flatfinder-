-- =============================================
-- FlatFinders Sample Data
-- Property Rental Platform
-- This file contains sample data for testing and development
-- =============================================

USE flatfinders_db;

-- =============================================
-- Insert Sample Users (10-15 users)
-- Password for all users: password123
-- =============================================

INSERT INTO users (name, email, phone, password_hash, role, email_verified, status, created_at) VALUES
-- Admin user
('Admin User', 'admin@flatfinders.com', '+880-1700-000000', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', TRUE, 'active', '2024-01-01 10:00:00'),

-- Property Owners (5 owners)
('Abdul Rahman', 'abdul.rahman@gmail.com', '+880-1711-111111', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', TRUE, 'active', '2024-01-05 14:30:00'),
('Fatima Begum', 'fatima.begum@gmail.com', '+880-1712-222222', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', TRUE, 'active', '2024-01-10 09:15:00'),
('Karim Ahmed', 'karim.ahmed@yahoo.com', '+880-1713-333333', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', TRUE, 'active', '2024-01-15 16:45:00'),
('Ayesha Khan', 'ayesha.khan@gmail.com', '+880-1714-444444', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', TRUE, 'active', '2024-01-20 11:20:00'),
('Mohammad Hasan', 'mohammad.hasan@outlook.com', '+880-1715-555555', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', TRUE, 'active', '2024-01-25 13:00:00'),

-- Customers (9 customers)
('Rafiq Ahmed', 'rafiq.ahmed@gmail.com', '+880-1721-111111', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', TRUE, 'active', '2024-02-01 10:30:00'),
('Sultana Akter', 'sultana.akter@gmail.com', '+880-1722-222222', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', TRUE, 'active', '2024-02-05 15:45:00'),
('Tanvir Islam', 'tanvir.islam@yahoo.com', '+880-1723-333333', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', TRUE, 'active', '2024-02-10 09:00:00'),
('Nadia Rahman', 'nadia.rahman@gmail.com', '+880-1724-444444', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', TRUE, 'active', '2024-02-15 12:30:00'),
('Imran Hossain', 'imran.hossain@outlook.com', '+880-1725-555555', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', TRUE, 'active', '2024-02-20 14:15:00'),
('Sabrina Chowdhury', 'sabrina.ch@gmail.com', '+880-1726-666666', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', TRUE, 'active', '2024-02-25 16:00:00'),
('Jahangir Alam', 'jahangir.alam@yahoo.com', '+880-1727-777777', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', TRUE, 'active', '2024-03-01 11:45:00'),
('Farzana Yasmin', 'farzana.yasmin@gmail.com', '+880-1728-888888', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', TRUE, 'active', '2024-03-05 13:30:00'),
('Shakil Ahmed', 'shakil.ahmed@gmail.com', '+880-1729-999999', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', TRUE, 'active', '2024-03-10 10:00:00')
ON DUPLICATE KEY UPDATE name=name;

-- =============================================
-- Insert Sample Properties (15 properties)
-- =============================================

INSERT INTO properties (owner_id, title, description, property_type, price, bedrooms, bathrooms, area_sqft, floor, location, city, address, nearby_places, is_bachelor_only, is_furnished, contact_name, contact_phone, contact_email, status, views, featured, available_from, created_at) VALUES
-- Owner 2 properties
(2, 'Spacious 3 Bedroom Apartment in Dhanmondi', 'Beautiful and spacious 3 bedroom apartment located in the heart of Dhanmondi. Features include modern kitchen, balcony with city views, and parking space. Close to restaurants, shopping centers, and public transport.', 'apartment', 35000.00, 3, 2, 1400, '5th Floor', 'Dhanmondi', 'Dhaka', 'Road 15, Block A, Dhanmondi, Dhaka 1209', 'Dhanmondi Lake, City College, ISD Road', FALSE, TRUE, 'Abdul Rahman', '+880-1711-111111', 'abdul.rahman@gmail.com', 'approved', 245, TRUE, '2024-04-01', '2024-02-15 10:30:00'),
(2, 'Cozy Bachelor Studio in Mohammadpur', 'Perfect studio apartment for bachelor students or working professionals. Fully furnished with AC, wifi, and all utilities included. Security guard and elevator available.', 'studio', 12000.00, 1, 1, 450, '3rd Floor', 'Mohammadpur', 'Dhaka', 'Shyamoli Square, Mohammadpur, Dhaka 1207', 'Shyamoli Square, Asad Gate, Mohammadpur Bus Stand', TRUE, TRUE, 'Abdul Rahman', '+880-1711-111111', 'abdul.rahman@gmail.com', 'approved', 189, FALSE, '2024-03-15', '2024-02-20 14:00:00'),
(2, 'Modern 2 Bedroom in Gulshan', 'Luxurious 2 bedroom apartment in Gulshan with contemporary design. Features include gym access, swimming pool, rooftop garden, and 24/7 security.', 'apartment', 55000.00, 2, 2, 1200, '8th Floor', 'Gulshan', 'Dhaka', 'Road 45, Gulshan 2, Dhaka 1212', 'Gulshan Lake, American Embassy, Scholastica School', FALSE, TRUE, 'Abdul Rahman', '+880-1711-111111', 'abdul.rahman@gmail.com', 'approved', 567, TRUE, '2024-04-10', '2024-03-01 09:15:00'),

-- Owner 3 properties
(3, 'Affordable Bachelor Flat in Mirpur', 'Budget-friendly bachelor accommodation in Mirpur 10. Single room with attached bathroom, shared kitchen facility available. Perfect for students.', 'bachelor', 8000.00, 1, 1, 320, '2nd Floor', 'Mirpur', 'Dhaka', 'Block C, Mirpur 10, Dhaka 1216', 'Mirpur 10 Circle, National University, Sony Square', TRUE, FALSE, 'Fatima Begum', '+880-1712-222222', 'fatima.begum@gmail.com', 'approved', 134, FALSE, '2024-03-20', '2024-02-25 11:45:00'),
(3, 'Family House in Uttara', 'Spacious 4 bedroom house with garden and parking for 2 cars. Quiet residential area, perfect for families. Modern amenities and 24/7 security.', 'house', 75000.00, 4, 3, 2500, 'Ground Floor', 'Uttara', 'Dhaka', 'Sector 7, Road 12, Uttara, Dhaka 1230', 'Uttara Jasimuddin Park, Airport, University of Development', FALSE, TRUE, 'Fatima Begum', '+880-1712-222222', 'fatima.begum@gmail.com', 'approved', 423, TRUE, '2024-04-20', '2024-03-05 16:30:00'),
(3, '2 Bedroom Sublet in Banani', 'Short-term sublet available for 6 months. Fully furnished 2 bedroom apartment in Banani. All utilities included in rent.', 'sublet', 28000.00, 2, 1, 900, '6th Floor', 'Banani', 'Dhaka', 'Road 11, Block B, Banani, Dhaka 1213', 'Banani Graveyard, NSU, Banani Bazar', FALSE, TRUE, 'Fatima Begum', '+880-1712-222222', 'fatima.begum@gmail.com', 'approved', 278, FALSE, '2024-03-25', '2024-03-08 12:00:00'),

-- Owner 4 properties
(4, 'Luxury Penthouse in Baridhara', 'Exclusive 3 bedroom penthouse with panoramic city views. Features include private rooftop terrace, jacuzzi, and premium furnishings.', 'apartment', 95000.00, 3, 3, 2200, '12th Floor', 'Baridhara', 'Dhaka', 'Block J, Road 5, Baridhara DOHS, Dhaka 1206', 'Baridhara Lake, Diplomatic Zone, International Schools', FALSE, TRUE, 'Karim Ahmed', '+880-1713-333333', 'karim.ahmed@yahoo.com', 'approved', 789, TRUE, '2024-04-15', '2024-03-10 10:45:00'),
(4, 'Comfortable Bachelor Room in Bashundhara', 'Clean and comfortable bachelor accommodation in Bashundhara R/A. Includes wifi, AC, and access to common area.', 'bachelor', 10000.00, 1, 1, 400, '4th Floor', 'Bashundhara', 'Dhaka', 'Block D, Road 7, Bashundhara R/A, Dhaka 1229', 'Jamuna Future Park, Apollo Hospital, NSU', TRUE, TRUE, 'Karim Ahmed', '+880-1713-333333', 'karim.ahmed@yahoo.com', 'approved', 156, FALSE, '2024-03-30', '2024-03-12 15:20:00'),

-- Owner 5 properties
(5, 'Student Friendly Apartment in Mohakhali', '2 bedroom apartment perfect for students sharing. Close to universities and public transport. Affordable rent with all basic amenities.', 'apartment', 18000.00, 2, 1, 750, '3rd Floor', 'Mohakhali', 'Dhaka', 'Wireless Gate, Mohakhali, Dhaka 1212', 'Mohakhali Bus Stand, BICC, Square Hospital', FALSE, FALSE, 'Ayesha Khan', '+880-1714-444444', 'ayesha.khan@gmail.com', 'approved', 312, FALSE, '2024-04-05', '2024-03-15 09:30:00'),
(5, 'Premium Studio in Niketan', 'High-end studio apartment in Gulshan-Niketan area. Ideal for single professionals. Fully furnished with modern appliances.', 'studio', 22000.00, 1, 1, 550, '7th Floor', 'Niketan', 'Dhaka', 'Road 113, Gulshan-Niketan, Dhaka 1212', 'Niketan Post Office, Bir Uttam Rafiqul Islam Avenue', TRUE, TRUE, 'Ayesha Khan', '+880-1714-444444', 'ayesha.khan@gmail.com', 'approved', 445, TRUE, '2024-04-12', '2024-03-18 14:00:00'),

-- Owner 6 properties
(6, 'Spacious 3BR in Old Dhaka', 'Traditional 3 bedroom apartment in Old Dhaka area. High ceilings, spacious rooms, perfect for families. Near historic landmarks.', 'apartment', 20000.00, 3, 2, 1300, '2nd Floor', 'Old Dhaka', 'Dhaka', 'Nawabpur Road, Old Dhaka, Dhaka 1100', 'Ahsan Manzil, Lalbagh Fort, Sadarghat', FALSE, FALSE, 'Mohammad Hasan', '+880-1715-555555', 'mohammad.hasan@outlook.com', 'approved', 198, FALSE, '2024-04-01', '2024-03-20 11:15:00'),
(6, 'Modern House in Lalmatia', 'Beautiful 3 bedroom house with garden in Lalmatia. Newly renovated with modern kitchen and bathrooms. Parking available.', 'house', 45000.00, 3, 2, 1800, 'Ground Floor', 'Lalmatia', 'Dhaka', 'Block B, Road 5, Lalmatia, Dhaka 1207', 'Lalmatia Girls School, Panthapath, Dhanmondi Lake', FALSE, TRUE, 'Mohammad Hasan', '+880-1715-555555', 'mohammad.hasan@outlook.com', 'approved', 356, FALSE, '2024-04-08', '2024-03-22 13:45:00'),
(6, 'Economy Bachelor in Tejgaon', 'Basic bachelor accommodation in Tejgaon industrial area. Perfect for workers. Very affordable rent.', 'bachelor', 6500.00, 1, 1, 280, '1st Floor', 'Tejgaon', 'Dhaka', 'Tejgaon Industrial Area, Dhaka 1208', 'Tejgaon Railway Station, Satrasta, Karwan Bazar', TRUE, FALSE, 'Mohammad Hasan', '+880-1715-555555', 'mohammad.hasan@outlook.com', 'approved', 89, FALSE, '2024-03-28', '2024-03-24 10:00:00'),

-- Pending properties
(2, '4 Bedroom Villa in Cantonment', 'Luxurious villa in Dhaka Cantonment area. Premium location with high security. Perfect for diplomatic or executive families.', 'house', 120000.00, 4, 4, 3200, 'Ground + 1st Floor', 'Cantonment', 'Dhaka', 'Road 3, Dhaka Cantonment, Dhaka 1206', 'CMH, Army Golf Club, Cantonment Board', FALSE, TRUE, 'Abdul Rahman', '+880-1711-111111', 'abdul.rahman@gmail.com', 'pending', 12, FALSE, '2024-05-01', '2024-03-25 16:00:00'),
(5, 'Shared Apartment in Kawran Bazar', 'Looking for 2 roommates to share 3 bedroom apartment. Rent per person is very affordable. Close to offices.', 'sublet', 15000.00, 3, 2, 1100, '9th Floor', 'Kawran Bazar', 'Dhaka', 'Kawran Bazar, Tejgaon, Dhaka 1215', 'Kawran Bazar Market, Sonargaon Hotel, Media Offices', FALSE, TRUE, 'Ayesha Khan', '+880-1714-444444', 'ayesha.khan@gmail.com', 'pending', 8, FALSE, '2024-04-18', '2024-03-26 12:30:00');

-- =============================================
-- Insert Property Images (2-3 images per property)
-- =============================================

INSERT INTO property_images (property_id, image_path, is_primary, display_order) VALUES
-- Property 1 images
(1, 'properties/prop1_main.jpg', TRUE, 1),
(1, 'properties/prop1_living.jpg', FALSE, 2),
(1, 'properties/prop1_bedroom.jpg', FALSE, 3),

-- Property 2 images
(2, 'properties/prop2_main.jpg', TRUE, 1),
(2, 'properties/prop2_room.jpg', FALSE, 2),

-- Property 3 images
(3, 'properties/prop3_main.jpg', TRUE, 1),
(3, 'properties/prop3_living.jpg', FALSE, 2),
(3, 'properties/prop3_pool.jpg', FALSE, 3),

-- Property 4 images
(4, 'properties/prop4_main.jpg', TRUE, 1),
(4, 'properties/prop4_room.jpg', FALSE, 2),

-- Property 5 images
(5, 'properties/prop5_main.jpg', TRUE, 1),
(5, 'properties/prop5_garden.jpg', FALSE, 2),
(5, 'properties/prop5_interior.jpg', FALSE, 3),

-- Property 6 images
(6, 'properties/prop6_main.jpg', TRUE, 1),
(6, 'properties/prop6_living.jpg', FALSE, 2),

-- Property 7 images
(7, 'properties/prop7_main.jpg', TRUE, 1),
(7, 'properties/prop7_terrace.jpg', FALSE, 2),
(7, 'properties/prop7_bedroom.jpg', FALSE, 3),

-- Property 8 images
(8, 'properties/prop8_main.jpg', TRUE, 1),
(8, 'properties/prop8_room.jpg', FALSE, 2),

-- Property 9 images
(9, 'properties/prop9_main.jpg', TRUE, 1),
(9, 'properties/prop9_living.jpg', FALSE, 2),

-- Property 10 images
(10, 'properties/prop10_main.jpg', TRUE, 1),
(10, 'properties/prop10_interior.jpg', FALSE, 2),

-- Property 11 images
(11, 'properties/prop11_main.jpg', TRUE, 1),
(11, 'properties/prop11_rooms.jpg', FALSE, 2),

-- Property 12 images
(12, 'properties/prop12_main.jpg', TRUE, 1),
(12, 'properties/prop12_garden.jpg', FALSE, 2),

-- Property 13 images
(13, 'properties/prop13_main.jpg', TRUE, 1),

-- Property 14 images
(14, 'properties/prop14_main.jpg', TRUE, 1),

-- Property 15 images
(15, 'properties/prop15_main.jpg', TRUE, 1);

-- =============================================
-- Insert Property Amenities
-- =============================================

INSERT INTO property_amenities (property_id, amenity_id) VALUES
-- Property 1 (Dhanmondi Apartment) - wifi, ac, parking, elevator, gas
(1, 1), (1, 2), (1, 3), (1, 5), (1, 7),

-- Property 2 (Studio) - wifi, ac, security, elevator
(2, 1), (2, 2), (2, 4), (2, 5),

-- Property 3 (Gulshan) - wifi, ac, parking, security, elevator, gym
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5), (3, 11),

-- Property 4 (Bachelor Mirpur) - wifi, gas
(4, 1), (4, 7),

-- Property 5 (Uttara House) - wifi, ac, parking, security, generator, gas
(5, 1), (5, 2), (5, 3), (5, 4), (5, 6), (5, 7),

-- Property 6 (Banani Sublet) - wifi, ac, elevator, furnished
(6, 1), (6, 2), (6, 5), (6, 10),

-- Property 7 (Baridhara Penthouse) - all amenities
(7, 1), (7, 2), (7, 3), (7, 4), (7, 5), (7, 6), (7, 7), (7, 8), (7, 9), (7, 10), (7, 11), (7, 12),

-- Property 8 (Bashundhara Bachelor) - wifi, ac, security, elevator
(8, 1), (8, 2), (8, 4), (8, 5),

-- Property 9 (Mohakhali Apartment) - wifi, gas
(9, 1), (9, 7),

-- Property 10 (Niketan Studio) - wifi, ac, elevator, furnished, gym
(10, 1), (10, 2), (10, 5), (10, 10), (10, 11),

-- Property 11 (Old Dhaka) - gas
(11, 7),

-- Property 12 (Lalmatia House) - wifi, ac, parking, gas, balcony
(12, 1), (12, 2), (12, 3), (12, 7), (12, 9),

-- Property 13 (Tejgaon Bachelor) - basic, no amenities

-- Property 14 (Cantonment Villa) - all amenities
(14, 1), (14, 2), (14, 3), (14, 4), (14, 5), (14, 6), (14, 7), (14, 8), (14, 9), (14, 10),

-- Property 15 (Kawran Bazar) - wifi, ac, elevator, furnished
(15, 1), (15, 2), (15, 5), (15, 10);

-- =============================================
-- Insert Sample Inquiries (10-12 inquiries)
-- =============================================

INSERT INTO inquiries (property_id, customer_id, name, email, phone, message, status, created_at) VALUES
(1, 7, 'Rafiq Ahmed', 'rafiq.ahmed@gmail.com', '+880-1721-111111', 'Hello, I am interested in this apartment. Is it still available? Can I schedule a visit this weekend?', 'new', '2024-03-15 10:30:00'),
(3, 8, 'Sultana Akter', 'sultana.akter@gmail.com', '+880-1722-222222', 'This looks perfect for me! What is the move-in date? Are pets allowed?', 'read', '2024-03-16 14:20:00'),
(5, 9, 'Tanvir Islam', 'tanvir.islam@yahoo.com', '+880-1723-333333', 'Interested in the house. Can we negotiate on the rent? Also, is long-term rental available?', 'replied', '2024-03-17 09:45:00'),
(7, 10, 'Nadia Rahman', 'nadia.rahman@gmail.com', '+880-1724-444444', 'The penthouse looks amazing! I would like to know more about the amenities and parking facilities.', 'new', '2024-03-18 16:15:00'),
(10, 11, 'Imran Hossain', 'imran.hossain@outlook.com', '+880-1725-555555', 'Is the studio still available for April? I work in Gulshan and this location is perfect for me.', 'read', '2024-03-19 11:00:00'),
(1, 12, 'Sabrina Chowdhury', 'sabrina.ch@gmail.com', '+880-1726-666666', 'Can I get more pictures of the apartment? Also, what utilities are included in the rent?', 'new', '2024-03-20 13:30:00'),
(9, 13, 'Jahangir Alam', 'jahangir.alam@yahoo.com', '+880-1727-777777', 'Perfect for students! My friend and I are looking to share. Can we visit tomorrow?', 'replied', '2024-03-21 10:20:00'),
(12, 14, 'Farzana Yasmin', 'farzana.yasmin@gmail.com', '+880-1728-888888', 'Very nice house! Is it available from April 1st? We are a family of 4.', 'new', '2024-03-22 15:45:00'),
(6, 15, 'Shakil Ahmed', 'shakil.ahmed@gmail.com', '+880-1729-999999', 'Interested in the sublet. Can you provide more details about the furnishings?', 'read', '2024-03-23 12:00:00'),
(3, 7, 'Rafiq Ahmed', 'rafiq.ahmed@gmail.com', '+880-1721-111111', 'I visited another property but this one seems better. When can I visit?', 'new', '2024-03-24 09:30:00'),
(8, NULL, 'Mahmud Khan', 'mahmud.k@gmail.com', '+880-1730-123456', 'Is this bachelor room still available? I need accommodation urgently.', 'new', '2024-03-25 14:15:00'),
(2, 11, 'Imran Hossain', 'imran.hossain@outlook.com', '+880-1725-555555', 'The studio looks good. What is included in the 12000 taka rent?', 'read', '2024-03-26 11:45:00');

-- =============================================
-- Insert Sample Favorites (10-12 favorites)
-- =============================================

INSERT INTO favorites (user_id, property_id, created_at) VALUES
(7, 1, '2024-03-10 10:00:00'),
(7, 3, '2024-03-11 14:30:00'),
(7, 7, '2024-03-12 09:15:00'),
(8, 1, '2024-03-13 16:45:00'),
(8, 5, '2024-03-14 11:20:00'),
(9, 9, '2024-03-15 13:00:00'),
(10, 7, '2024-03-16 10:30:00'),
(10, 10, '2024-03-17 15:45:00'),
(11, 2, '2024-03-18 09:00:00'),
(11, 10, '2024-03-19 12:30:00'),
(12, 1, '2024-03-20 14:15:00'),
(13, 9, '2024-03-21 16:00:00'),
(14, 12, '2024-03-22 11:45:00'),
(15, 6, '2024-03-23 13:30:00');

-- =============================================
-- Insert Recently Viewed Properties
-- =============================================

INSERT INTO recently_viewed (user_id, property_id, viewed_at) VALUES
(7, 1, '2024-03-26 10:30:00'),
(7, 2, '2024-03-26 10:35:00'),
(7, 3, '2024-03-26 10:40:00'),
(8, 1, '2024-03-26 11:00:00'),
(8, 5, '2024-03-26 11:15:00'),
(9, 9, '2024-03-26 12:00:00'),
(9, 4, '2024-03-26 12:10:00'),
(10, 7, '2024-03-26 13:30:00'),
(10, 10, '2024-03-26 13:45:00'),
(11, 2, '2024-03-26 14:20:00'),
(11, 8, '2024-03-26 14:30:00'),
(12, 1, '2024-03-26 15:00:00'),
(13, 9, '2024-03-26 15:30:00'),
(14, 12, '2024-03-26 16:00:00'),
(15, 6, '2024-03-26 16:30:00');

-- =============================================
-- Insert Sample Notifications (10-12 notifications)
-- =============================================

INSERT INTO notifications (user_id, title, message, type, link, is_read, created_at) VALUES
(2, 'Property Approved', 'Your property "Spacious 3 Bedroom Apartment in Dhanmondi" has been approved!', 'success', '/owner-dashboard.html', TRUE, '2024-03-01 09:00:00'),
(2, 'New Inquiry Received', 'You have a new inquiry for your property in Dhanmondi', 'info', '/owner-inquiries.html', FALSE, '2024-03-15 10:35:00'),
(2, 'Property Approved', 'Your property "Cozy Bachelor Studio in Mohammadpur" has been approved!', 'success', '/owner-dashboard.html', TRUE, '2024-03-02 10:00:00'),
(3, 'Property Approved', 'Your property "Family House in Uttara" has been approved!', 'success', '/owner-dashboard.html', TRUE, '2024-03-06 09:00:00'),
(3, 'New Inquiry Received', 'Someone is interested in your property in Banani', 'info', '/owner-inquiries.html', FALSE, '2024-03-23 12:05:00'),
(7, 'Inquiry Response', 'Property owner has responded to your inquiry', 'info', '/customer-inquiries.html', FALSE, '2024-03-17 14:00:00'),
(8, 'New Property Alert', 'A new property matching your preferences has been listed', 'info', '/properties.html', TRUE, '2024-03-20 10:00:00'),
(9, 'Inquiry Response', 'Your inquiry has been replied to', 'success', '/customer-inquiries.html', FALSE, '2024-03-21 15:00:00'),
(10, 'Price Drop Alert', 'Price reduced on a property in your favorites', 'warning', '/customer-dashboard.html', TRUE, '2024-03-22 11:00:00'),
(4, 'Property Approved', 'Your property "Luxury Penthouse in Baridhara" has been approved!', 'success', '/owner-dashboard.html', TRUE, '2024-03-11 09:30:00'),
(5, 'Property Approved', 'Your property "Premium Studio in Niketan" has been approved!', 'success', '/owner-dashboard.html', TRUE, '2024-03-19 10:00:00'),
(11, 'New Property Alert', 'Check out the latest properties in Gulshan area', 'info', '/properties.html', FALSE, '2024-03-25 14:00:00');

-- =============================================
-- Insert Sample Contact Form Submissions (10 entries)
-- =============================================

INSERT INTO contacts (name, email, phone, subject, message, status, created_at) VALUES
('Rahman Ali', 'rahman.ali@gmail.com', '+880-1731-111111', 'Question about listing property', 'Hello, I want to list my property on your platform. What are the requirements and fees?', 'new', '2024-03-10 09:30:00'),
('Priya Sharma', 'priya.sharma@yahoo.com', '+880-1732-222222', 'Payment issue', 'I am having trouble with the payment system. Can you please help?', 'in_progress', '2024-03-12 14:20:00'),
('Kamal Uddin', 'kamal.u@gmail.com', '+880-1733-333333', 'Feature request', 'Would be great if you could add a virtual tour feature for properties', 'resolved', '2024-03-14 10:45:00'),
('Nusrat Jahan', 'nusrat.j@outlook.com', '+880-1734-444444', 'Account verification', 'My account verification is pending for 3 days. Please check.', 'resolved', '2024-03-15 16:15:00'),
('Habib Khan', 'habib.khan@gmail.com', '+880-1735-555555', 'Partnership inquiry', 'I represent a real estate company. Interested in partnership opportunities.', 'in_progress', '2024-03-18 11:00:00'),
('Sadia Islam', 'sadia.islam@gmail.com', '+880-1736-666666', 'Technical issue', 'The website is not loading properly on my phone. Please fix.', 'new', '2024-03-20 13:30:00'),
('Farhan Ahmed', 'farhan.a@yahoo.com', '+880-1737-777777', 'General inquiry', 'Do you cover properties outside Dhaka city?', 'resolved', '2024-03-21 09:20:00'),
('Tasnim Chowdhury', 'tasnim.ch@gmail.com', '+880-1738-888888', 'Advertisement', 'I want to promote my property. What are the advertising options?', 'new', '2024-03-23 15:45:00'),
('Rashed Hasan', 'rashed.h@outlook.com', '+880-1739-999999', 'Complaint', 'I contacted a property owner but got no response. Can you help?', 'in_progress', '2024-03-24 12:00:00'),
('Mehnaz Sultana', 'mehnaz.s@gmail.com', '+880-1740-000000', 'Suggestion', 'Your platform is great! Just a suggestion to add more filter options.', 'new', '2024-03-25 14:30:00');

-- =============================================
-- Update property views for realism
-- =============================================

UPDATE properties SET views = FLOOR(50 + (RAND() * 500)) WHERE status = 'approved';

-- =============================================
-- Sample data insertion complete!
-- =============================================

