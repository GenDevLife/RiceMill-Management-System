# RiceMill Management System

### ระบบจัดการโรงสีข้าว - Tech City

โปรเจคนี้พัฒนาขึ้นสำหรับจัดการงานด้านต่างๆ ของโรงสีข้าว ประกอบด้วย:

- **ระบบสมาชิก** - จัดเก็บข้อมูลลูกค้า
- **ระบบสั่งซื้อสินค้า** - รำข้าว, แกลบ, ข้าวท่อน, ข้าวปลาย
- **ระบบบริการสีข้าว** - สีข้าว, คัด/ฝัดเมล็ดข้าว, อบข้าว
- **ระบบคะแนนสะสม** - สะสมแต้มจากการซื้อสินค้า/ใช้บริการ
- **ระบบโปรโมชั่น** - แลกคะแนนเป็นบริการฟรี
- **ระบบใบเสร็จ** - พิมพ์/ส่งออกใบเสร็จ
- **Dashboard สำหรับเจ้าของ** - ดูสถิติและรายงานต่างๆ

## 📁 โครงสร้างโปรเจค (หลัง Refactor)

```
RiceMill-Management-System/
├── index.php                    # หน้าแรก
│
├── includes/                    # Core files
│   ├── config.php               # Database configuration + constants
│   ├── Database.php             # Database helper class (Prepared statements)
│   ├── header.php               # Reusable header component
│   └── footer.php               # Reusable footer component
│
├── pages/                       # All public pages
│   ├── auth/                    # Authentication
│   │   ├── login.php            # Owner login
│   │   └── register.php         # Member registration
│   │
│   ├── members/                 # Member selection pages
│   │   ├── select-for-service.php    # เลือกสมาชิก → บริการ+สินค้า
│   │   ├── select-for-product.php    # เลือกสมาชิก → เฉพาะสินค้า
│   │   └── select-for-promotion.php  # เลือกสมาชิก → แลกโปรโมชั่น
│   │
│   ├── orders/                  # Order processing
│   │   ├── service.php          # สั่งบริการ (สำหรับ flow บริการ+สินค้า)
│   │   ├── product.php          # สั่งสินค้า (หลังบริการ)
│   │   ├── product-only.php     # สั่งเฉพาะสินค้า
│   │   └── promotion.php        # แลกโปรโมชั่น
│   │
│   ├── summary/                 # Order summaries
│   │   ├── all.php              # สรุปบริการ+สินค้า
│   │   ├── product.php          # สรุปเฉพาะสินค้า
│   │   └── service.php          # สรุปเฉพาะบริการ
│   │
│   ├── receipts/                # Receipt generation
│   │   ├── all.php              # ใบเสร็จรวม
│   │   ├── product.php          # ใบเสร็จสินค้า
│   │   ├── service.php          # ใบเสร็จบริการ
│   │   └── promotion.php        # ใบเสร็จโปรโมชั่น
│   │
│   ├── api/                     # API endpoints
│   │   └── search-members.php   # AJAX member search
│   │
│   └── points.php               # คะแนนสะสม
│
├── admin/                       # Admin dashboard
│   └── index.php                # Main dashboard
│
├── assets/                      # Static files
│   ├── css/
│   │   ├── style.css            # Main stylesheet
│   │   ├── login.css            # Login page styles
│   │   └── receipt.css          # Receipt styles
│   ├── js/
│   │   ├── script.js            # Main JavaScript
│   │   ├── district.js          # District/Subdistrict selection
│   │   ├── table.js             # Table search functionality
│   │   └── receipt.js           # Receipt functions
│   └── images/
│       └── TechTeam.png         # Logo
│
├── database/                    # Database files
│   └── rice_mill.sql            # Database schema
│
└── README.md
```

## 🔄 Mapping: ไฟล์เดิม → ไฟล์ใหม่

| ไฟล์เดิม               | ไฟล์ใหม่                                 | หน้าที่                 |
| ---------------------- | ---------------------------------------- | ----------------------- |
| `index.html`           | `index.php`                              | หน้าหลัก                |
| `login.php`            | `pages/auth/login.php`                   | เข้าสู่ระบบ             |
| `register.php`         | `pages/auth/register.php`                | สมัครสมาชิก             |
| `member.php`           | `pages/members/select-for-service.php`   | เลือกสมาชิก (บริการ)    |
| `member1.php`          | `pages/members/select-for-product.php`   | เลือกสมาชิก (สินค้า)    |
| `member3.php`          | `pages/members/select-for-promotion.php` | เลือกสมาชิก (โปรโมชั่น) |
| `OrderService.php`     | `pages/orders/service.php`               | สั่งบริการ              |
| `OrderProduct.php`     | `pages/orders/product.php`               | สั่งสินค้า (หลังบริการ) |
| `OrderProduct2.php`    | `pages/orders/product-only.php`          | สั่งเฉพาะสินค้า         |
| `promotion.php`        | `pages/orders/promotion.php`             | แลกโปรโมชั่น            |
| `summarize.php`        | `pages/summary/all.php`                  | สรุปรวม                 |
| `sumproduct.php`       | `pages/summary/product.php`              | สรุปสินค้า              |
| `sumservice.php`       | `pages/summary/service.php`              | สรุปบริการ              |
| `receiptall.php`       | `pages/receipts/all.php`                 | ใบเสร็จรวม              |
| `receiptproduct.php`   | `pages/receipts/product.php`             | ใบเสร็จสินค้า           |
| `receiptservice.php`   | `pages/receipts/service.php`             | ใบเสร็จบริการ           |
| `receiptpromotion.php` | `pages/receipts/promotion.php`           | ใบเสร็จโปรโมชั่น        |
| `point.php`            | `pages/points.php`                       | คะแนนสะสม               |
| `search.php`           | `pages/api/search-members.php`           | API ค้นหาสมาชิก         |
| `owner/`               | `admin/`                                 | Admin dashboard         |
| `include/config.php`   | `includes/config.php`                    | Database config         |

## ✨ การปรับปรุงที่ทำ

### 1. โครงสร้างที่ดีขึ้น

- จัดกลุ่มไฟล์ตามหน้าที่ (auth, members, orders, receipts, etc.)
- ตั้งชื่อไฟล์ให้บ่งบอกหน้าที่ชัดเจน
- สร้าง reusable components (header, footer)

### 2. Security Improvements

- ใช้ **Prepared Statements** ป้องกัน SQL Injection
- Sanitize inputs ทุกครั้งก่อนใช้งาน
- Session validation สำหรับ admin pages

### 3. Code Quality

- สร้าง Database helper class
- กำหนด constants สำหรับราคาและ configuration
- แยก helper functions ออกมาใช้ร่วมกัน

### 4. Maintainability

- ลด code duplication ด้วย reusable components
- โครงสร้างที่ชัดเจนทำให้หาไฟล์ง่าย
- Comments ภาษาไทยอธิบายการทำงาน

## 🚀 วิธีติดตั้ง

1. Clone หรือ Download repository

```bash
git clone https://github.com/GenDevLife/RiceMill-Management-System.git
```

2. วางไว้ใน local server folder (เช่น htdocs สำหรับ XAMPP)

3. สร้าง MySQL database และ import `database/rice_mill.sql`

4. แก้ไข `includes/config.php` ตั้งค่าการเชื่อมต่อ database

5. เข้าใช้งานผ่าน browser:

```
http://localhost/RiceMill-Management-System/
```

## 👤 การเข้าสู่ระบบ Admin

- **Username:** owner
- **Password:** 12345678

## 📝 License

MIT License - สามารถนำไปใช้งานและพัฒนาต่อได้อย่างอิสระ
