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

# ระบบบริหารจัดการโรงสีข้าว
โครงงานวิชา Internet Programming จากมหาวิทยาลัยนเรศวร
โปรเจกต์นี้เป็นเว็บแอปพลิเคชันสำหรับจัดการงานโรงสีข้าว ที่ครอบคลุมตั้งแต่การสมัครสมาชิก สั่งซื้อสินค้า ไปจนถึงบริการต่าง ๆ เช่น สีข้าว อบข้าว คัด/ฝัดเมล็ดข้าว รวมถึงการสะสมคะแนน โปรโมชั่น และการออกใบเสร็จ

## ฟีเจอร์หลัก
1. การสมัครสมาชิก (Register) และ การเข้าสู่ระบบ (Login)
- จัดเก็บข้อมูลสมาชิกอย่างปลอดภัย เช่น ชื่อ ที่อยู่ เบอร์โทร วันสมัคร
- มีการจัดการเซสชันผู้ใช้ และรองรับการเข้าสู่ระบบของเจ้าของโรงสี (Owner)

2. การซื้อสินค้า
- เลือกสินค้าที่ต้องการ (รำข้าว แกลบ ข้าวท่อน ข้าวปลาย) คิดราคาเป็นกิโลกรัม
- ระบบจะคำนวณราคารวมโดยอัตโนมัติ และบันทึกข้อมูลคำสั่งซื้อ

3. การใช้บริการโรงสี
- เลือกบริการ สีข้าว อบข้าว คัด/ฝัดเมล็ดข้าว คิดราคาต่อถัง
- สามารถเลือกใช้บริการหลายประเภทพร้อมกันได้

4. ระบบสะสมแต้ม (Points System)
- แปลงยอดซื้อ/บริการเป็นแต้มสะสม (เช่น 1 แต้ม ต่อ 100 บาท)
- บันทึกแต้มลงในฐานข้อมูล เพื่อให้สมาชิกสะสมเพิ่มขึ้นเรื่อย ๆ

5. แลกโปรโมชั่น
- สมาชิกที่มีแต้มถึงเงื่อนไข สามารถแลกโปรได้ (เช่น อบข้าวฟรี 1 ครั้ง)
- ระบบจะหักแต้มจากฐานข้อมูลทันทีเมื่อแลก

6. การออกใบเสร็จ
- สามารถเรียกดูใบเสร็จได้หลายรูปแบบ (สินค้า บริการ โปรโมชั่น หรือใบเสร็จรวม)
- มีปุ่ม “พิมพ์” เพื่อสั่งพิมพ์หรือบันทึกเป็นไฟล์ PDF

7. ระบบสรุปรายการ
- มีหน้าสรุปรายการก่อนออกใบเสร็จ แสดงยอดรวม ทั้งสินค้าและบริการในแต่ละคำสั่งซื้อ

8. Dashboard เจ้าของโรงสี
- ล็อกอินพิเศษด้วย (owner / 12345678) เพื่อดูยอดสถิติ กราฟ Chart และข้อมูลรวมต่าง ๆ

## โครงสร้างไฟล์ (Project Structure - ภาษาไทย)
(ดูในส่วนภาษาอังกฤษด้านบน เพื่อรายละเอียดโฟลเดอร์และไฟล์ทั้งหมด)

## ขั้นตอนการติดตั้งและการใช้งาน
1. ดาวน์โหลดหรือโคลน โปรเจกต์จาก GitHub
2. วางไฟล์โครงการ ไว้ในโฟลเดอร์ที่ Web Server เข้าถึงได้ (เช่น htdocs ใน XAMPP)
3. สร้างฐานข้อมูล (Database) ใน MySQL เช่น rice_mill_db
4. Import ไฟล์ rice_mill_3.sql ในโฟลเดอร์ DATABASE เข้าสู่ฐานข้อมูล
5. ปรับค่า include/config.php ให้ตรงกับข้อมูลการเชื่อมต่อ (Host, User, Password, DBname)
6. เปิด ผ่านเบราว์เซอร์:
```
http://localhost/RiceMillProject/index.html
```
