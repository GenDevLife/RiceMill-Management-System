# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2025-12-09

### 🚀 Major Changes

- **Database Migration**: เปลี่ยนจาก MySQL เป็น SQLite เพื่อความสะดวกในการติดตั้ง
- **Project Restructure**: จัดโครงสร้างไฟล์ใหม่ทั้งหมดให้เป็นระเบียบ
- **Column Naming**: เปลี่ยน column names เป็น snake_case ตามมาตรฐาน

### ✨ Added

- `includes/Database.php` - Database helper class พร้อม prepared statements
- `includes/config.php` - Centralized configuration และ helper functions
- `includes/header.php` - Reusable header component
- `includes/footer.php` - Reusable footer component
- `database/setup.php` - Script สำหรับสร้าง database อัตโนมัติ
- `assets/css/login.css` - Login page styling
- `pages/api/search-members.php` - AJAX API สำหรับค้นหาสมาชิก
- Responsive CSS design สำหรับทุกขนาดหน้าจอ
- CSS Variables สำหรับ theming
- Print-friendly receipt styles

### 🔒 Security

- ใช้ PDO Prepared Statements ทุก query ป้องกัน SQL Injection
- Input sanitization ด้วย `htmlspecialchars()`
- Session validation สำหรับ admin pages

### 📁 Changed

- `index.html` → `index.php` (ใช้ PHP components)
- `member.php` → `pages/members/select-for-service.php`
- `member1.php` → `pages/members/select-for-product.php`
- `member3.php` → `pages/members/select-for-promotion.php`
- `OrderService.php` → `pages/orders/service.php`
- `OrderProduct.php` → `pages/orders/product.php`
- `OrderProduct2.php` → `pages/orders/product-only.php`
- `promotion.php` → `pages/orders/promotion.php`
- `summarize.php` → `pages/summary/all.php`
- `receiptall.php` → `pages/receipts/all.php`
- `point.php` → `pages/points.php`
- `search.php` → `pages/api/search-members.php`
- `owner/` → `admin/`
- `include/` → `includes/`

### 🗑️ Removed

- ลบ node_modules จาก owner/js/
- ลบไฟล์ซ้ำซ้อน (member2.php, OrderService2.php, etc.)
- ลบ Bootstrap และ libraries ที่ไม่จำเป็น
- ลบ DATABASE/ folder (ย้ายไป database/)

---

## [1.0.0] - 2024-01-01

### Initial Release

- ระบบจัดการสมาชิก
- ระบบสั่งซื้อสินค้า
- ระบบบริการสีข้าว
- ระบบคะแนนสะสม
- ระบบโปรโมชั่น
- ระบบใบเสร็จ
- Dashboard สำหรับเจ้าของ

---

[2.0.0]: https://github.com/GenDevLife/RiceMill-Management-System/compare/v1.0.0...v2.0.0
[1.0.0]: https://github.com/GenDevLife/RiceMill-Management-System/releases/tag/v1.0.0
