<?php
/**
 * SQLite Database Setup Script
 * รันไฟล์นี้ครั้งเดียวเพื่อสร้าง database
 * 
 * Usage: php database/setup.php
 */

echo "=== Rice Mill Database Setup ===\n\n";

// Database path
$dbPath = __DIR__ . '/ricemill.db';

// ลบ database เก่า (ถ้ามี)
if (file_exists($dbPath)) {
    unlink($dbPath);
    echo "✓ Removed old database\n";
}

try {
    // สร้าง SQLite connection
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Created new database: ricemill.db\n";

    // สร้าง tables
    $pdo->exec("
        -- ตาราง สมาชิก
        CREATE TABLE members (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            points INTEGER DEFAULT 0,
            address VARCHAR(200),
            subdistrict VARCHAR(100),
            district VARCHAR(100),
            province VARCHAR(100) DEFAULT 'พิจิตร',
            created_at DATE DEFAULT CURRENT_DATE
        );

        -- ตาราง สั่งซื้อสินค้า
        CREATE TABLE order_products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            member_id INTEGER NOT NULL,
            order_date DATE DEFAULT CURRENT_DATE,
            rice_bran_kg DECIMAL(10,2) DEFAULT 0,
            husk_kg DECIMAL(10,2) DEFAULT 0,
            rice_chunks_kg DECIMAL(10,2) DEFAULT 0,
            broken_rice_kg DECIMAL(10,2) DEFAULT 0,
            total_price DECIMAL(10,2) NOT NULL,
            FOREIGN KEY (member_id) REFERENCES members(id)
        );

        -- ตาราง สั่งบริการ
        CREATE TABLE order_services (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            member_id INTEGER NOT NULL,
            order_date DATE DEFAULT CURRENT_DATE,
            service_type VARCHAR(20) NOT NULL,
            weight_kg DECIMAL(10,2) NOT NULL,
            total_price DECIMAL(10,2) NOT NULL,
            FOREIGN KEY (member_id) REFERENCES members(id)
        );

        -- ตาราง โปรโมชั่น
        CREATE TABLE promotions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            member_id INTEGER NOT NULL,
            redeem_date DATE DEFAULT CURRENT_DATE,
            promotion_type VARCHAR(20) NOT NULL,
            points_used INTEGER NOT NULL,
            FOREIGN KEY (member_id) REFERENCES members(id)
        );

        -- สร้าง indexes
        CREATE INDEX idx_members_phone ON members(phone);
        CREATE INDEX idx_members_name ON members(name);
        CREATE INDEX idx_order_products_member ON order_products(member_id);
        CREATE INDEX idx_order_products_date ON order_products(order_date);
        CREATE INDEX idx_order_services_member ON order_services(member_id);
        CREATE INDEX idx_order_services_date ON order_services(order_date);
        CREATE INDEX idx_promotions_member ON promotions(member_id);
    ");
    echo "✓ Created all tables\n";

    // เพิ่มข้อมูลตัวอย่าง (Sample members)
    $sampleMembers = [
        ['สมชาย กรวิชญ์พงศา', '0689214735', 1102, '53 ม.5', 'ทะนง', 'โพทะเล', 'พิจิตร', '2022-01-02'],
        ['รุจิรา คณพัฒน์พงศา', '0983145726', 1918, '80 ม.3', 'ลำประดา', 'บางมูลนาก', 'พิจิตร', '2022-01-03'],
        ['สุรชัย ก่อกุลสุทธิเลิศ', '0696543127', 1827, '44 ม.5', 'หนองหญ้าไทร', 'สากเหล็ก', 'พิจิตร', '2022-01-04'],
        ['วิไล ตั้งธีระนพคุณ', '0987315246', 430, '21 ม.4', 'ท่าเสา', 'โพทะเล', 'พิจิตร', '2022-01-05'],
        ['ประสิทธิ์ ก่อเกียรติเกริก', '0682159437', 277, '68 ม.1', 'ทับคล้อ', 'ทับคล้อ', 'พิจิตร', '2022-01-06'],
        ['สมชาย กรวิชญ์พงศา', '0984756123', 876, '4 ม.3', 'บ้านนา', 'วชิรบารมี', 'พิจิตร', '2022-01-07'],
        ['ประทีป ก้องเกียรติเกริก', '0693482157', 295, '46 ม.2', 'ทุ่งโพธิ์', 'ตะพานหิน', 'พิจิตร', '2022-01-08'],
        ['นันทนา ชุติเบญญากุล', '0986523147', 1338, '58 ม.2', 'ห้วยร่วม', 'ดงเจริญ', 'พิจิตร', '2022-01-09'],
        ['ณัฐพงษ์ กานต์รีราพงศ์', '0681975243', 1451, '38 ม2', 'ตะพานหิน', 'ตะพานหิน', 'พิจิตร', '2022-01-10'],
        ['ชัชชา ตรัยพิทยนาถ', '0983462157', 1060, '72 ม.8', 'ทะนง', 'โพทะเล', 'พิจิตร', '2022-01-11'],
    ];

    $stmt = $pdo->prepare("
        INSERT INTO members (name, phone, points, address, subdistrict, district, province, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($sampleMembers as $member) {
        $stmt->execute($member);
    }
    echo "✓ Added " . count($sampleMembers) . " sample members\n";

    // เพิ่มข้อมูลตัวอย่าง order_products
    $sampleOrders = [
        [1, '2024-01-15', 10, 5, 8, 12, 280],
        [2, '2024-01-16', 15, 0, 10, 20, 360],
        [3, '2024-01-17', 20, 10, 5, 0, 280],
        [1, '2024-01-18', 0, 20, 15, 10, 330],
        [4, '2024-01-19', 25, 15, 0, 8, 378],
    ];

    $stmt = $pdo->prepare("
        INSERT INTO order_products (member_id, order_date, rice_bran_kg, husk_kg, rice_chunks_kg, broken_rice_kg, total_price)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($sampleOrders as $order) {
        $stmt->execute($order);
    }
    echo "✓ Added " . count($sampleOrders) . " sample product orders\n";

    // เพิ่มข้อมูลตัวอย่าง order_services
    $sampleServices = [
        [1, '2024-01-15', 'mill', 100, 800],
        [2, '2024-01-16', 'sort', 50, 150],
        [3, '2024-01-17', 'dry', 80, 640],
        [1, '2024-01-20', 'mill', 150, 1200],
    ];

    $stmt = $pdo->prepare("
        INSERT INTO order_services (member_id, order_date, service_type, weight_kg, total_price)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($sampleServices as $service) {
        $stmt->execute($service);
    }
    echo "✓ Added " . count($sampleServices) . " sample service orders\n";

    echo "\n=== Setup Complete! ===\n";
    echo "Database location: $dbPath\n";
    echo "Total members: " . $pdo->query("SELECT COUNT(*) FROM members")->fetchColumn() . "\n";

} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
