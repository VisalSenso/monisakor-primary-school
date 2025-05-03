# Monisakor Primary School Website

This is a modern school website developed for Monisakor Primary School. It provides information about the school, a student registration system, a multilingual interface, and an admin panel for managing content.

## ✨ Features

- Multilingual support (Khmer & English)
- Student registration form
- Admin panel to update website content
- Responsive design using Tailwind CSS
- Built with PHP, MySQL, JavaScript, and React

## 🚀 Technologies Used

- **Frontend**: HTML, Tailwind CSS, React.js
- **Backend**: PHP, MySQL
- **Multilingual**: i18next (React), PHP session-based language switching

## 🛠️ Installation

1. **Set up the backend with PHP and MySQL:**
   - Place the project folder in the `htdocs` directory of your XAMPP installation.
   - Start Apache and MySQL services using XAMPP.

2. **Import the database:**
   - Open `phpMyAdmin` in your browser.
   - Create a new database (e.g., `monisakor_school`).
   - Import the provided SQL file into the database.

3. **Run the frontend:**
   ```bash
   cd frontend
   npm install
   npm start
   ```