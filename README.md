# IMBS-LMS

## Web Engineering Assignment to Create a LMS

This project is a Learning Management System (LMS) developed for the IMBS Campus. It was created as a Web Engineering assignment and demonstrates the use of PHP, MySQL, and Tailwind CSS to build a functional web application.

## Features

 1. User Authentication: Secure user login and logout functionality.

 2. Student Registration: Register new students with their personal and course information.

 3. Student Search: Search and filter existing student records by NIC or name.

 4. Student Management: Edit and delete student records.

 5. Student Reports: Generate reports of active and deleted students, with sortable columns and search functionality.

## Technologies Used

 - PHP: Server-side scripting language for handling user requests, database interactions, and business logic.

 - MySQL: Relational database management system for storing user and student data.

 - Tailwind CSS: Utility-first CSS framework for rapid UI development and responsive design.

 - HTML: Markup language for structuring the web pages.

 - JavaScript: Client-side scripting language for enhancing user interactivity and dynamic content updates.

 - jQuery: JavaScript library for simplifying DOM manipulation and AJAX requests (used in reports.php and search.php).

## Project Structure

### IMBS-LMS:

 - auth.php: Handles user authentication.

 - components: Contains reusable components like header, footer, and navigation.

 - config: Contains database configuration files.

 - delete.php: Handles student deletion.

 - edit.php: Allows editing of student information.

 - get_students.php: Fetches student data for reports.

 - index.php: Dashboard page.

 - login.php: User login page.

 - logout.php: Handles user logout.

 - process_registration.php: Processes student registration.

 - register.php: Student registration form.

 - reports.php: Displays student reports.

 - search.php: Allows searching for students.

 - search_students.php: Handles student search queries.

 - update_student.php: Handles student information updates.

### Database

The database schema is defined in the database.sql file. It includes two tables:

 - users: Stores user information for authentication.

 - students: Stores student records.

### Installation

 1. Set up a web server with PHP and MySQL support.

 2. Import the database.sql file to create the database schema.

 3. Configure the database connection in the database.php file.

 4. Deploy the project files to the web server's document root.

### Usage

 1. Access the application through a web browser.

 2. Log in with valid user credentials.

 3. Use the navigation menu to access different features:

 4. Dashboard: Overview of the application.

 5. Register Student: Add new student records.

 6. Search Students: Search and manage existing students.

 7. Reports: View and generate student reports.
