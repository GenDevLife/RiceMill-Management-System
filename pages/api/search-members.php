<?php
/**
 * API: Search Members
 * ค้นหาสมาชิกด้วย AJAX
 */

header('Content-Type: application/json; charset=utf-8');

require_once '../../includes/config.php';
require_once '../../includes/Database.php';

$db = new Database();

// รับ keyword จาก query string
$keyword = isset($_GET['q']) ? sanitize($_GET['q']) : '';

try {
    if (empty($keyword)) {
        // ถ้าไม่มี keyword ให้แสดงสมาชิกทั้งหมด (จำกัด 50)
        $members = $db->getMembers(50, 0);
    } else {
        // ค้นหาด้วย keyword
        $members = $db->searchMembers($keyword);
    }
    
    echo json_encode($members, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error'], JSON_UNESCAPED_UNICODE);
}
