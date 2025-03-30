-- Backup of bus_management database
CREATE DATABASE IF NOT EXISTS bus_management;
USE bus_management;

-- Backup for Users Table
INSERT INTO users (id, name, email, password, role, created_at) VALUES
(1, 'Admin', 'admin@busmgmt.com', SHA2('admin123', 256), 'admin', NOW()),
(2, 'John Doe', 'john@example.com', SHA2('password123', 256), 'user', NOW()),
(3, 'Jane Smith', 'jane@example.com', SHA2('mypassword', 256), 'user', NOW());

-- Backup for Buses Table
INSERT INTO buses (id, bus_number, route, total_seats, available_seats, status) VALUES
(1, 'TN01A1234', 'Chennai - Coimbatore', 50, 20, 'Active'),
(2, 'TN02B5678', 'Madurai - Trichy', 40, 10, 'Active'),
(3, 'TN03C9101', 'Salem - Erode', 45, 25, 'Inactive');

-- Backup for Bookings Table
INSERT INTO bookings (id, user_id, bus_id, seat_number, price, booking_time, status) VALUES
(1, 2, 1, 5, 200.00, NOW(), 'Confirmed'),
(2, 3, 2, 10, 150.00, NOW(), 'Confirmed'),
(3, 2, 3, 7, 180.00, NOW(), 'Cancelled');

-- Backup for Bus Tracking Table
INSERT INTO bus_tracking (id, bus_id, latitude, longitude, updated_at) VALUES
(1, 1, 13.0827, 80.2707, NOW()),
(2, 2, 9.9252, 78.1198, NOW());

-- Backup for Feedback Table
INSERT INTO feedback (id, user_id, message, rating, submitted_at) VALUES
(1, 2, 'Great service, very punctual!', 5, NOW()),
(2, 3, 'The bus was a bit crowded.', 3, NOW());

-- Backup for Revenue Reports Table
INSERT INTO revenue_reports (id, route, total_earnings, total_tickets_sold, report_date) VALUES
(1, 'Chennai - Coimbatore', 5000.00, 25, CURDATE()),
(2, 'Madurai - Trichy', 3200.00, 18, CURDATE());

-- Backup for Crowd Monitoring Table
INSERT INTO crowd_monitoring (id, bus_id, passengers_count, updated_at) VALUES
(1, 1, 35, NOW()),
(2, 2, 25, NOW());

