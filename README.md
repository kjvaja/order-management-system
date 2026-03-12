# Laravel Order Management System

## Overview

This project is a Laravel-based **Order Management System** developed as part of the SolGuruz Laravel Practical Assessment.

The application demonstrates practical knowledge of Laravel including:

* Authentication
* REST API design
* Database relationships
* AJAX-based UI interactions
* Queue jobs
* Email notifications
* Clean MVC architecture

Users can browse products, place orders, view their order history, and receive an order confirmation email.

---

# Tech Stack

* PHP 8+
* Laravel
* MySQL
* Bootstrap 5
* jQuery
* SweetAlert2
* Laravel Queue
* Laravel Mail

---

# Features

## Authentication

* User registration
* User login
* Logout functionality
* Authenticated users can place orders and view order history

## Product Listing

* Products are seeded via database seeders
* Only **active products with available stock** are displayed
* Users can select quantities for each product

## Order Placement

* Users can place orders with **multiple products**
* Quantity validation is enforced
* Stock validation ensures product availability
* Database transactions maintain data integrity

## Order History

* Users can view **only their own orders**
* Orders are loaded via **AJAX**
* Order details popup shows:

  * Product name
  * Quantity
  * Price
  * Total

## Order Confirmation Email

* Email sent after successful order placement
* Implemented using **Laravel Queue Jobs**
* Controller dispatches a job which sends the email

---

# Project Setup

## 1. Clone Repository

```bash
git clone <repository-url>
cd order-management-system
```

## 2. Install Dependencies

```bash
composer install
npm install
```

## 3. Environment Setup

Copy environment file:

```bash
cp .env.example .env
```

Update database credentials in `.env`.

---

## 4. Generate Application Key

```bash
php artisan key:generate
```

---

## 5. Run Database Migrations

```bash
php artisan migrate
```

---

## 6. Seed Products

```bash
php artisan db:seed
```

Products will be automatically inserted into the database.

---

## 7. Configure Mail

Update `.env` with your mail configuration.

Example:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="Order System"
```

---

## 8. Configure Queue

Set queue connection:

```
QUEUE_CONNECTION=database
```

Create queue table:

```bash
php artisan queue:table
php artisan migrate
```

Run queue worker:

```bash
php artisan queue:work
```

---

## 9. Run Application

```bash
php artisan serve
```

Visit:

```
http://localhost:8000
```

---

# Database Relationships

User → hasMany → Orders

Order → belongsTo → User

Order → hasMany → OrderItems

OrderItem → belongsTo → Order

OrderItem → belongsTo → Product

Product → hasMany → OrderItems

---

# API Endpoints

## Get Products

GET /products

Returns active products with available stock.

---

## Place Order

POST /orders

Payload example:

```
{
  "products":[
    {
      "product_id":1,
      "qty":2
    },
    {
      "product_id":3,
      "qty":1
    }
  ]
}
```

---

## Get Order History

GET /my-orders

Returns authenticated user's orders.

---

## Get Order Details

GET /orders/{id}

Returns order items with product details.

---

# UI Pages

| Page          | Description                               |
| ------------- | ----------------------------------------- |
| Home          | Product listing with quantity selection   |
| Login         | User authentication                       |
| Register      | User registration                         |
| My Orders     | User order history                        |
| Order Details | SweetAlert modal showing ordered products |

---

# Validation Rules

* Quantity must be greater than 0
* Quantity cannot exceed product stock
* Inactive or out-of-stock products cannot be ordered
* If any product fails validation, the entire order fails

---

# Queue Job

Email notifications are sent via:

```
SendOrderConfirmationEmail Job
```

The job sends:

```
OrderConfirmationMail Mailable
```

---

# Assumptions

* Product data is seeded for testing purposes
* Orders cannot be modified after placement
* Only authenticated users can place orders
* Product listing is publicly accessible

---

# Improvements (Future Scope)

* Pagination for products
* Admin panel for product management
* Order status updates
* Product images
* API authentication using Sanctum

---

# Git Commit Strategy

Frequent commits were used to demonstrate development progress including:

* Authentication setup
* Product module
* Order management
* Email job implementation
* UI integration
* Validation and error handling

---

# Author

Kishan Vaja