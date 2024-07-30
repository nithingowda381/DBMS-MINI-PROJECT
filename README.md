#Forensic Case Management System
#Overview
The Forensic Case Management System is a web-based application designed to streamline the process of managing forensic cases, logs, and evidence. It provides a secure and user-friendly interface for administrators, forensic lab technicians, and officers to efficiently handle forensic investigations.

#Features
User Authentication: Secure login and role-based access control.
Case Management: Create, update, and manage forensic cases.
Log Management: Record and view logs related to case activities.
Evidence Management: Handle various types of evidence with detailed attributes.
User and Role Management: Administer user accounts and roles.
Notifications and Alerts: Basic notification mechanisms for user actions.
Image Processing: Resize, crop, and compare forensic images.
Technologies Used
PHP: Server-side scripting for handling form submissions, user inputs, and database interactions.
MySQL: Database management system for storing user, case, log, and evidence data.
Apache: Web server for hosting PHP scripts and serving web pages.
CSS and Bootstrap: Styling and responsive design for the user interface.
JavaScript: Enhancing interactivity and user experience on web pages.
HTML: Structuring content on web pages.
MD5: Cryptographic hashing for secure password storage.
PHPMailer: Sending email notifications and alerts.
Installation
Prerequisites
A web server (e.g., Apache) with PHP 7.x or higher installed.
MySQL 5.x or higher.
A web browser (e.g., Google Chrome, Mozilla Firefox).
Steps
Clone the Repository

bash
Copy code
git clone https://github.com/nithingowda381/DBMS-MINI-PROJECT.git
Navigate to the Project Directory

bash
Copy code
cd forensic
Set Up the Database

Create a MySQL database.
Import the SQL schema from the sql directory.
bash
Copy code
mysql -u username -p database_name < sql/schema.sql
Configure the Database Connection

Edit the config.php file to add your database credentials.
Start the Web Server

Ensure Apache is running.
Place the project files in the Apache web directory (e.g., /var/www/html).
Access the Application

Open a web browser and navigate to http://localhost/forensic.
Usage
Login
Use your credentials to log in. Depending on your role, you will have access to different functionalities.
Case Management
Create, update, and manage forensic cases.
Log Management
Record and view logs related to forensic cases.
Evidence Management
Handle and manage various types of evidence linked to cases.
User Management
Admin users can manage other user accounts and roles.
Future Enhancements
Advanced search functionality for filtering cases and evidence.
Improved notification and alert systems.
Integration with external forensic tools and databases.
Enhanced user interface for better user experience.
Contributing
Fork the repository.
Create a new branch (git checkout -b feature-branch).
Contributing
Fork the repository.
Create a new branch (git checkout -b feature-branch).
Commit your changes (git commit -am 'Add new feature').
Push to the branch (git push origin feature-branch).
Create a new Pull Request.
License
This project is licensed under the MIT License - see the LICENSE file for details.

Contact
For any inquiries or issues, please contact:

Project Maintainer: [NITHIN GOWDA M S]
Email: [nithingowda381@gmail.com]
Acknowledgements: 
Online Resources: Various tutorials and documentation that provided valuable insights and assistance.
Libraries and Frameworks: Bootstrap, PHPMailer, and other open-source libraries that made development easier.
Friends and Family: For their encouragement and support during the development of this project.
