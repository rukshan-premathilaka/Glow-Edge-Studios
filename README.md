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
- Node.js
- npm
- MySQL

---

## 🚀 Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/rukshan-premathilaka/Glow-Edge-Studios.git
cd glow-edge-studios
```

### 2. Install dependencies

```bash
composer install
```

### 3. Create the database

```bash
mysql -u root -p -e "CREATE DATABASE glow_edge_studios"
```
### 4. Import the database
```bash
Get-Content src/core/backup.sql | mysql -u root -p glow_edge_studios
```
### 3. Setup environment

Create a `.env` file in the root directory:

```ini
# Database Config
DB_HOST=localhost
DB_NAME=glow_edge_studios
DB_USER=your_mysql_username
DB_PASS=your_mysql_password
DB_PORT=3306
DB_CHARSET=utf8mb4

# Mail Config
MAIL_USERNAME='your_name'
MAIL_PASSWORD='your_gmail_app_password'
MAIL_SENDER='your_email_address'
```

### 4. Run the server (for development)

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
