# RiceMill Management System

### An Internet Programming Project from Naresuan University

This repository showcases a web application for managing rice mill operations, including:

- **Member Registration** (storing customer information)
- **Product Purchase** (rice bran, husk, broken rice, etc.)
- **Rice Mill Services** (milling, drying, and cleaning)
- **Points Accumulation** (earning points from each purchase)
- **Promotions** (redeemable when specific point thresholds are reached)
- **Receipts** (detailed invoices that can be printed or exported)
- **Owner Dashboard** (statistics, charts, and overall system monitoring)

## Features

1. **User Registration and Login**  
   - Securely store user details, such as name, address, phone number, and registration date.  
   - Manage user sessions with basic authentication (owner login included).

2. **Product Purchase**  
   - Provide product options with prices per kilogram (e.g., rice bran, husk).  
   - Calculate the total cost based on user-selected quantities.

3. **Rice Mill Services**  
   - Offer services like milling, drying, and cleaning, charged per bucket.  
   - Permit multiple services to be selected in one order.

4. **Points System**  
   - Convert total purchase amounts into points (e.g., 1 point per 100 THB).  
   - Track and update points in the database, allowing users to earn and spend them.

5. **Promotional Offers**  
   - Let users redeem accumulated points for promotional packages, such as free drying or other services.

6. **Receipts and Summaries**  
   - Generate receipt pages for both products and services.  
   - Summaries show itemized costs, points gained, and points used before finalizing an order.

7. **Owner Dashboard**  
   - Exclusive login credentials for the mill owner or admin user (`owner` / `12345678` by default).  
   - Provides charts and statistics (e.g., sales distribution, frequent services).

## Project Structure

```plaintext
RiceMillProject
├── index.html
├── login.php
├── member.php
├── member1.php
├── member2.php
├── member3.php
├── OrderProduct.php
├── OrderProduct2.php
├── OrderService.php
├── OrderService2.php
├── point.php
├── promotion.php
├── README.md
├── receiptall.php
├── receiptproduct.php
├── receiptpromotion.php
├── register.php
├── search.php
├── summarize.php
├── sumproduct.php
├── sumservice.php
├── sumservicepromotion.php
│
├── assets
│   ├── css
│   │   ├── loginstyle.css
│   │   ├── receipt.css
│   │   └── style.css
│   │
│   └── js
│       ├── district.js
│       ├── receipt.js
│       ├── script.js
│       └── table.js
│
├── DATABASE
│   └── rice_mill_3.sql
│
├── img
│   └── TechTeam.png
│
├── include
│   └── config.php
│
├── owner
│   ├── chart.php
│   ├── index.php
│   ├── Member.php
│   ├── Product_Pie.php
│   ├── Service_Pie.php
│   ├── Sum_Service_and_Product.php
│   ├── Total_Service_and_Product.php
│   ├── css
│   │   ├── bootstrap.min.css
│   │   └── style.css
│   ├── img
│   │   └── TechTeam.png
│   └── js
│       ├── Chart.min.js
│       ├── jquery.min.js
│       ├── main.js
│       ├── package-lock.json
│       ├── package.json
│       ├── script.js
│       └── node_modules
│           └── ...
│
├── lib
│   ├── chart
│   ├── easing
│   ├── owlcarousel
│   ├── tempusdominus
│   └── waypoints
│
└── scss
    └── ...
```
## Installation & Usage
1. Clone or Download this repository
```
git clone https://github.com/GenDevLife/RiceMill-Management-System.git
```
2. Place it under your local server folder (e.g., htdocs for XAMPP)
3. Create a MySQL database (e.g., rice_mill_db).
4. Import the file rice_mill_3.sql from the DATABASE folder into the database.
5. Update include/config.php with the correct credentials (host, username, password, db name).
6. Access the project via your browser:
```
http://localhost/RiceMillProject/index.html
```
For Owner Login: username: owner, password: 12345678 (default).
