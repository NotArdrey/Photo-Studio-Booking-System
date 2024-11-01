# Photo Studio Booking System

Welcome to the **Photo Studio Booking System** repository! This project is designed to streamline the booking and reservation process for photography sessions, providing a user-friendly interface for clients and an efficient management system for administrators.

## Features

- **Client-Side Booking**: Users can easily browse available dates and book their desired photography sessions.
- **Admin Dashboard**: Administrators can manage bookings, view transaction history, and ensure smooth operation through a FIFO (First In, First Out) system.
- **Payment Integration**: The system integrates with the **PayMongo API** to handle payments securely, allowing users to pay for their bookings online.
- **User Authentication**: Admins can log in to the dashboard to manage bookings and view payment status.

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Payment Processing**: PayMongo API
- **Frameworks**: Bootstrap for responsive design

## Getting Started

All necessary files for the project have been uploaded. To set up the project locally, follow these steps:

1. **Download or Clone the Repository**:
   - If you prefer to clone it, use the following command:
     ```bash
     git clone https://github.com/NotArdrey/Photo-Studio-Booking-System.git
     ```
     
2. **Import the Database**:
   - Open your MySQL management tool (like phpMyAdmin) and import the `database.sql` file provided in the repository to your localhost.

3. **Configure the PayMongo API**:
   - Ensure you configure the PayMongo API settings in the relevant PHP files to enable payment processing. **Remember to add your API keys to the configuration files**.

4. **Start the Server**:
   - Use XAMPP or any other local server setup to run the PHP application.

5. **Access the Application**:
   - Open your web browser and go to `http://localhost/PhotoStudio/page/bookings.html` for the user side and `http://localhost/PhotoStudio/page/admin.php` for the admin side.

## Usage

- Clients can navigate to the booking page, select a date and time, and complete their reservation.
- Admins can log in to the admin dashboard to view and manage bookings, ensuring they are processed in FIFO order.

## Contribution

Feel free to fork the repository and submit pull requests for any improvements or bug fixes.

