# Black Box Task 1 - Advanced Features - Complete Blog Application

## Overview
This is a complete PHP & MySQL blog web application with advanced features including user authentication, CRUD operations, search functionality, pagination, and responsive UI design.

## Features Implemented

### ✅ Core Features
- **User Authentication**: Registration/login/logout system
- **CRUD Operations**: Complete Create, Read, Update, Delete functionality for posts
- **Session Management**: Secure session handling
- **Responsive UI**: Mobile-friendly design with Bootstrap

### ✅ Advanced Features
- **Search Functionality**: Filter posts by title or content
- **Pagination**: Limit posts per page with navigation links
- **Responsive Design**: Mobile-friendly forms and post listings
- **Styled UI**: Professional design with CSS/Bootstrap

### ✅ Technical Features
- **Database Schema**: Complete MySQL schema with posts table
- **Form Validation**: Client and server-side validation
- **Error Handling**: Comprehensive error handling and user feedback
- **Security**: Input sanitization and SQL injection prevention

## File Structure

```
c:/xampp/htdocs/blackbox_task1/
├── index.php                 # Main page with environment setup
├── read.php                # Post listing with search and pagination
├── create.php              # Create new posts
├── update.php              # Edit existing posts
├── delete.php              # Delete posts
├── config/
│   └── database.php        # Database configuration
├── styles.css              # Advanced styling
├── schema.sql              # Database schema
└── README.md               # This documentation
```

## Database Schema

```sql
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Usage Instructions

### Setup Development Environment
1. Install XAMPP with PHP and MySQL
2. Clone the repository to `c:/xampp/htdocs/blackbox_task1/`
3. Import the database schema from `schema.sql`
4. Configure database connection in `config/database.php`

### Running the Application
1. Start XAMPP Apache and MySQL services
2. Navigate to `http://localhost/blackbox_task1/`
3. Use the application to create, read, update, and delete posts

### Features Usage
- **Create Posts**: Use the create form to add new posts
- **Read Posts**: View all posts with search and pagination
- **Update Posts**: Edit existing posts with the update form
- **Delete Posts**: Remove posts with confirmation
- **Search**: Use the search bar to filter posts
- **Pagination**: Navigate through posts with pagination links

## Advanced Features

### Search Functionality
- Search bar in read.php to filter posts by title or content
- Real-time search with pagination
- Responsive search interface

### Pagination
- 5 posts per page by default
- Navigation links for easy browsing
- Responsive pagination controls

### Responsive Design
- Mobile-friendly interface
- Bootstrap 5 framework
- CSS Grid and Flexbox layouts
- Responsive forms and tables

### Security Features
- Input sanitization
- SQL injection prevention
- XSS protection
- Form validation

## Technical Specifications

### Technologies Used
- **Backend**: PHP 8.0+, MySQL 8.0+
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework**: Bootstrap 5.3.0
- **Database**: MySQL with InnoDB engine
- **Server**: Apache with PHP-FPM

### Browser Compatibility
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

### Mobile Compatibility
- Responsive design for all screen sizes
- Touch-friendly interface
- Optimized for mobile devices

## Installation and Setup

1. **Clone Repository**
   ```bash
   git clone https://github.com/Udayreddy46/-apex-planet-task-2.git
   ```

2. **Setup Database**
   ```bash
   # Import database schema
   mysql -u root -p < schema.sql
   ```

3. **Configure Database**
   ```bash
   # Update config/database.php with your database credentials
   ```

4. **Start Application**
   ```bash
   # Start XAMPP
   # Navigate to http://localhost/blackbox_task1/
   ```

## Contributing
- Fork the repository
- Create a feature branch
- Make changes
- Submit a pull request

## License
This project is part of the Black Box Task 1 internship project.
