# Cosmetics Shop - E-Commerce Website

## Overview
This is a simple PHP-based e-commerce website for a cosmetics shop. It includes a frontend for users to browse products, manage cart, checkout, and account, as well as an admin panel for managing products, categories, brands, orders, users, and contacts. The site uses a MySQL database and is designed to run on XAMPP (Apache + MySQL).

## Tech Stack
- **Backend**: PHP
- **Database**: MySQL (via `cosmatic_shop.sql`)
- **Frontend**: HTML, CSS, JavaScript (embedded)
- **Server**: XAMPP (Windows)

## Project Structure
```
c:/xampp/htdocs/TP/
├── aboutus.php          # About us page
├── account.php          # User account management
├── add_card.php         # Add payment card (checkout related)
├── cart.php             # Shopping cart
├── checkout.php         # Checkout page
├── contactus.php        # Contact us page
├── home.php             # Homepage
├── login.php            # User login
├── logout.php           # User logout
├── registration.php     # User registration
├── shoppage.php         # Shop/products page
├── cosmatic_shop.sql    # Database schema & data
├── admin/               # Admin panel
│   ├── admin_dashboard.php  # Admin dashboard (currently open)
│   ├── admin_login.php      # Admin login
│   ├── db.php               # Database connection
│   ├── index.php            # Admin index
│   ├── show_brands.php      # View brands
│   ├── show_cate.php        # View categories
│   ├── show_contact.php     # View contacts
│   ├── show_orders.php      # View orders
│   ├── show_product.php     # View products
│   ├── show_user.php        # View users
│   └── css/                 # Admin CSS styles
│       ├── bra.css, cat.css, etc.
└── images/             # Product/homepage images
    ├── 1.jpg, 2.jpg, etc.
    ├── homep_bg.jpg
    └── login_bg.jpg
```

## Prerequisites
- XAMPP installed and running (Apache & MySQL services)
- Web browser (e.g., Chrome, Firefox)

## Setup Instructions
1. **Start XAMPP**:
   - Open XAMPP Control Panel.
   - Start **Apache** and **MySQL** services.

2. **Import Database**:
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create a new database named `cosmatic_shop` (or update `admin/db.php` if different).
   - Import `cosmatic_shop.sql` into the database.

3. **Access the Site**:
   - Open `http://localhost/TP/home.php` (or `http://localhost/TP/` if index redirects).

## Usage

### Frontend (User)
- Browse products: `shoppage.php`
- View cart: `cart.php`
- Checkout: `checkout.php`
- Account: `account.php`, `login.php`, `registration.php`

### Admin Panel
- Login: `http://localhost/TP/admin/admin_login.php`
- Dashboard: `admin/admin_dashboard.php`
- Manage: Products (`show_product.php`), Categories (`show_cate.php`), Brands (`show_brands.php`), Orders (`show_orders.php`), Users (`show_user.php`), Contacts (`show_contact.php`)

## Screenshots
*(Add screenshots of homepage, shop, admin dashboard here if desired)*

## Notes
- Update database credentials in `admin/db.php` if needed.
- Customize images in `images/` folder.
- For production, secure the site (e.g., HTTPS, input validation, prepared statements).
- Currently open in VSCode: `admin/admin_dashboard.php`

## Troubleshooting
- **Database errors**: Check `admin/db.php` credentials and ensure DB imported.
- **404 errors**: Confirm XAMPP Apache is running and paths match.
- **Styles missing**: Check `admin/css/` files.

Happy shopping & admin-ing! 🚀

