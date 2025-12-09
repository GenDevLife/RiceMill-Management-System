<?php
/**
 * Configuration File
 * Rice Mill Management System
 * 
 * SQLite Database Configuration
 */

// ===== Database Configuration =====
define('DB_PATH', __DIR__ . '/../database/ricemill.db');

// สร้าง PDO Connection
function getConnection() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $pdo = new PDO("sqlite:" . DB_PATH);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Enable foreign keys
            $pdo->exec("PRAGMA foreign_keys = ON");
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    return $pdo;
}

// ===== Price Constants =====
// ราคาสินค้า (บาท/กก.)
define('PRICE_RICE_BRAN', 8);       // รำข้าว
define('PRICE_HUSK', 8);            // แกลบ
define('PRICE_RICE_CHUNKS', 7);     // ข้าวท่อน
define('PRICE_BROKEN_RICE', 14);    // ข้าวปลาย

// ราคาบริการ (บาท/กก.)
define('PRICE_MILL', 8);            // สีข้าว
define('PRICE_SORT', 3);            // คัด/ฝัดเมล็ดข้าว
define('PRICE_DRY', 8);             // อบข้าว

// ===== Points Configuration =====
define('POINTS_PER_100_BAHT', 1);   // ได้ 1 คะแนน ต่อ 100 บาท

// คะแนนที่ใช้แลกโปรโมชั่น
define('POINTS_FREE_MILL', 500);    // แลกสีข้าวฟรี 50 กก.
define('POINTS_FREE_SORT', 200);    // แลกคัด/ฝัดฟรี 50 กก.
define('POINTS_FREE_DRY', 500);     // แลกอบข้าวฟรี 50 กก.

// ===== Helper Functions =====

/**
 * Sanitize input data
 */
function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Calculate service price
 */
function calculateServicePrice($serviceType, $weightKg) {
    $prices = [
        'mill' => PRICE_MILL,
        'sort' => PRICE_SORT,
        'dry'  => PRICE_DRY,
    ];
    
    return isset($prices[$serviceType]) ? $prices[$serviceType] * $weightKg : 0;
}

/**
 * Calculate product price
 */
function calculateProductPrice($riceBran, $husk, $riceChunks, $brokenRice) {
    return ($riceBran * PRICE_RICE_BRAN) +
           ($husk * PRICE_HUSK) +
           ($riceChunks * PRICE_RICE_CHUNKS) +
           ($brokenRice * PRICE_BROKEN_RICE);
}

/**
 * Calculate points from total amount
 */
function calculatePoints($totalAmount) {
    return floor($totalAmount / 100) * POINTS_PER_100_BAHT;
}

/**
 * Get points required for promotion
 */
function getPromotionPoints($promotionType) {
    $points = [
        'mill' => POINTS_FREE_MILL,
        'sort' => POINTS_FREE_SORT,
        'dry'  => POINTS_FREE_DRY,
    ];
    
    return isset($points[$promotionType]) ? $points[$promotionType] : 0;
}

/**
 * Get service name in Thai
 */
function getServiceName($serviceType) {
    $names = [
        'mill' => 'สีข้าว',
        'sort' => 'คัด/ฝัดเมล็ดข้าว',
        'dry'  => 'อบข้าว',
    ];
    
    return isset($names[$serviceType]) ? $names[$serviceType] : $serviceType;
}

/**
 * Format price with comma
 */
function formatPrice($price) {
    return number_format($price, 2);
}

/**
 * Format date to Thai format
 */
function formatDateThai($date) {
    $months = [
        1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.',
        5 => 'พ.ค.', 6 => 'มิ.ย.', 7 => 'ก.ค.', 8 => 'ส.ค.',
        9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
    ];
    
    $timestamp = strtotime($date);
    $day = date('j', $timestamp);
    $month = $months[(int)date('n', $timestamp)];
    $year = date('Y', $timestamp) + 543;
    
    return "$day $month $year";
}
