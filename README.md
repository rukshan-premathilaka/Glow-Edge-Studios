# Glow Edge Studios

**Glow Edge Studios** is an online booking web application designed for a company that provides **graphic designing** and **photography services**. The main goal of this platform is to make it easy for clients to book a graphic designer or photographer online — fast, secure, and hassle-free.

---

## 🔥 Features

- 🖼️ Online booking for graphic designers & photographers  
- 📨 Email verification with PHPMailer  
- ✅ Form validation with Respect\Validation  
- 🔒 CSRF protection using middleware  
- 📁 MVC structure (Controllers, Services, Middleware)  
- ⚙️ Environment configuration with `vlucas/phpdotenv`  
- 🧪 Unit testing with PHPUnit  

---

## 🛠️ Tech Stack

- **PHP 8.2+**
- **MySQL** (via PDO)
- **Composer** for dependency management
- **Phroute** for routing
- **Respect/Validation** for input validation
- **PHPMailer** for email handling
- **Dotenv** for secure configuration

---

## 📁 Project Structure

```
vendor/              # Third-party libraries
src/                 # Source code
├── controller/      # Route handling and logic
├── core/            # Core application logic (DB, request handling, etc.)
├── middleware/      # Custom middlewares (CSRF, Auth, etc.)
├── service/         # Email services and other services
public/              # Static files like CSS, JS & assets
views/               # HTML page templates
test/                # Unit test
.env                 # Environment variables
composer.json        # Project dependencies
.htaccess            # Apache rewrite rules for routing
```

---
## ✅ Requirements

- PHP 8.2 or higher
- Composer
- MySQL
- Node.js

---

## 🚀 Getting Started

### 1. Create a new folder
We recommend creating a new folder for the project. For example, you can create a folder named `glow-edge-studios`
If you use server software like Apache or Nginx, use the htdocs folder to host the project.

### 2. Open that folder in your IDE and run the following commands in the terminal

### 3. Clone the repository

This will clone the repository to the current directory from GitHub. Make sure you have git installed and set path variable on your system.
```bash
git clone https://github.com/rukshan-premathilaka/Glow-Edge-Studios.git .
```

### 2. Install dependencies

This will install the required dependencies using Composer. Make sure you have Composer installed on your system. 
```bash
composer install
```

### 3. Create the database

This will create a new database called `glow_edge_studios`. Make sure you have MySQL installed on your system.
```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS glow_edge_studios"
```
### 4. Import the database
This will import the database from the `backup.sql` file. 
```bash
Get-Content src/core/backup.sql | mysql -u root -p glow_edge_studios
```
### 3. Setup environment

Update the `.env` file with your own values. In the root directory.
```ini
# Database Config
DB_HOST=localhost
DB_NAME=glow_edge_studios
DB_USER='your mysql username'
DB_PASS='your mysql password'
DB_PORT=3306
DB_CHARSET=utf8mb4

# Mail Config
MAIL_USERNAME='your name or email address'
MAIL_PASSWORD='your gmail app password (NOT your gmail password)'
MAIL_SENDER='your_email_address'
```

### 4. Start the server (for development)

```bash
php -S localhost:8000
```
Note: The server will run on `localhost:8000`
---

## 👨‍💻 Authors

**Rasintha Rukshan Premathilaka (Develop php backend)**  
📧 Email: rasintharukshanp@gmail.com

**Example User ()**  
📧 Email: example@gmail.com

**Example User ()**  
📧 Email: example@gmail.com

**Example User ()**  
📧 Email: example@gmail.com

**Example User ()**  
📧 Email: example@gmail.com

---


## 📄 License

Licensed under the [Apache-2.0 License](LICENSE).
