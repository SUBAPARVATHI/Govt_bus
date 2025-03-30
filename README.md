# Govt_bus
# 🚌 Government Bus Management System

## 📌 Project Overview
The **Government Bus Management System** is a web-based application designed to manage bus operations efficiently. It includes real-time tracking, seat booking, revenue analysis, and crowd monitoring features.

## 📂 Project Structure
/bus_management_system
│── /admin
│ │── admin_dashboard.php # Admin dashboard
│ │── admin_login.php # Admin login page
│ │── manage_buses.php # Add/Edit/Delete buses
│ │── view_bookings.php # View seat bookings
│ │── live_tracking.php # Live bus tracking
│ │── view_feedback.php # View user feedback
│ │── revenue_reports.php # Revenue and ticket reports
│ │── route_analysis.php # Efficient route analysis
│ │── admin_config.php # Database connection for admin
│ └── /css
│ └── admin_styles.css # Admin panel styles
│
│── /user
│ │── index.php # User homepage
│ │── book_seat.php # Seat booking page
│ │── seat_availability.php # Seat availability check
│ │── track_bus.php # Real-time bus tracking
│ │── crowd_monitoring.php # Bus crowd monitoring
│ │── feedback.php # User feedback form
│ │── login.php # User login page
│ │── register.php # User registration page
│ │── user_config.php # Database connection for users
│ └── /css
│ └── user_styles.css # User interface styles
│
│── /database
│ │── db_init.sql # SQL file to initialize database
│ │── db_backup.sql # Backup of database
│
│── /api
│ │── get_bus_location.php # API for fetching live bus locations
│ │── get_seat_availability.php # API for checking seat availability
│ │── post_feedback.php # API for submitting feedback
│ │── get_crowd_status.php # API for crowd monitoring
│ │── route_efficiency.php # API for route analysis
│
│── /assets
│ │── /images # Images used in the project
│ │── /js # JavaScript files
│ │── /css # Global styles
│
│── config.php # Main database configuration
│── .htaccess # URL rewriting rules
│── README.md # Project documentation


## 🚀 Features
### 🎫 User Features:
- **Bus Seat Booking**: Users can check seat availability and book seats.
- **Real-Time Bus Tracking**: Live GPS tracking of buses using Google Maps API.
- **Crowd Monitoring**: Estimates crowd levels in buses.
- **User Feedback System**: Users can submit feedback on buses and services.
- **Secure Authentication**: Login & Registration system.

### 📊 Admin Features:
- **Bus Management**: Add/Edit/Delete bus details.
- **Live Bus Tracking**: View buses on a map in real time.
- **View Bookings**: Manage seat bookings.
- **Revenue Reports**: Detailed analytics on revenue and routes.
- **Route Efficiency Analysis**: Optimize routes based on user bookings.
- **Feedback Management**: View and manage user feedback.

### 🔌 API Integrations:
- **Live Bus Location**: Fetch real-time bus locations.
- **Seat Availability**: Check and update seat bookings dynamically.
- **Crowd Status**: Monitor bus crowd conditions.
- **Route Optimization**: Analyze and improve travel routes.

## 🛠️ Technologies Used
- **Frontend**: HTML, CSS, JavaScript (Bootstrap, TailwindCSS)
- **Backend**: PHP (Core PHP, PDO)
- **Database**: MySQL
- **API Integration**: Google Maps API, WebSockets (for live updates)

## 📌 Installation & Setup
1. Clone the repository:
   ```sh
   git clone https://github.com/your-repo/government-bus-management.git
Import the database:

Open phpMyAdmin and create a database named bus_management.

Import the file database/db_init.sql.

Configure the database:

Edit config.php and set database credentials.

Start the project:

Place the project in your web server directory (htdocs for XAMPP).

Start Apache & MySQL from XAMPP Control Panel.

Open http://localhost/bus_management_system in your browser.

🔐 Admin Credentials
Admin Login:

Username: admin

Password: admin123

📜 License
This project is open-source under the MIT License.
