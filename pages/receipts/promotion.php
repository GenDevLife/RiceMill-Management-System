<?php
/**
 * Receipt - Promotion
 * หน้าใบเสร็จโปรโมชั่น
 */

$basePath = '../../';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';

$db = new Database();

// รับข้อมูลจากหน้าก่อน
$memberId = isset($_POST['member_id']) ? (int)$_POST['member_id'] : 0;
$promotionType = isset($_POST['promotion_type']) ? sanitize($_POST['promotion_type']) : '';

if ($memberId === 0 || empty($promotionType)) {
    header('Location: ' . $basePath . 'pages/members/select-for-promotion.php');
    exit;
}

// ดึงข้อมูลสมาชิก
$member = $db->getMember($memberId);

if (!$member) {
    header('Location: ' . $basePath . 'pages/members/select-for-promotion.php');
    exit;
}

// คะแนนที่ต้องใช้
$pointsRequired = getPromotionPoints($promotionType);

// ตรวจสอบคะแนนพอหรือไม่
if ($member['points'] < $pointsRequired) {
    header('Location: ' . $basePath . 'pages/orders/promotion.php?error=insufficient_points');
    exit;
}

// บันทึกข้อมูลลง database
try {
    // บันทึกโปรโมชั่น
    $db->insertPromotion($memberId, $promotionType, $pointsRequired);
    
    // หักคะแนน
    $db->deductMemberPoints($memberId, $pointsRequired);
    
    // ดึงข้อมูลสมาชิกใหม่
    $member = $db->getMember($memberId);
    
} catch (Exception $e) {
    error_log("Promotion Error: " . $e->getMessage());
}

$pageTitle = 'ใบเสร็จโปรโมชั่น';
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Tech City โรงสีข้าว</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/receipt.css">
</head>
<body>
    <div class="receipt-container promotion-receipt">
        <div class="receipt-header">
            <img src="<?php echo $basePath; ?>assets/images/TechTeam.png" alt="Logo" class="receipt-logo"
                 onclick="window.location='<?php echo $basePath; ?>index.php'">
            <p class="company-name">Tech City โรงสีข้าว</p>
            <p class="company-address">จังหวัดพิจิตร</p>
        </div>
        
        <div class="promotion-badge">
            <span>🎁 คูปองโปรโมชั่น</span>
        </div>
        
        <div class="customer-info">
            <p class="customer-name"><?php echo htmlspecialchars($member['name']); ?></p>
            <p class="customer-phone">โทร: <?php echo htmlspecialchars($member['phone']); ?></p>
            <p class="receipt-date"><?php echo formatDateThai(date('Y-m-d')); ?></p>
        </div>
        
        <div class="promotion-details">
            <h3><?php echo getServiceName($promotionType); ?> ฟรี!</h3>
            <p class="promo-amount">50 กก.</p>
            <p class="promo-note">* ใช้ได้ภายใน 30 วัน</p>
        </div>
        
        <div class="points-info">
            <p>ใช้คะแนน: <strong>-<?php echo number_format($pointsRequired); ?></strong> คะแนน</p>
            <p class="points-remaining">คะแนนคงเหลือ: <strong><?php echo number_format($member['points']); ?></strong> คะแนน</p>
        </div>
        
        <div class="receipt-footer">
            <p>ขอบคุณที่ใช้บริการ ❤️</p>
        </div>
        
        <button class="print-button" onclick="window.print()">🖨️ พิมพ์ใบเสร็จ</button>
        <a href="<?php echo $basePath; ?>index.php" class="print-button" style="background: #666; margin-top: 10px; text-decoration: none; display: block; text-align: center;">← กลับหน้าหลัก</a>
    </div>
</body>
</html>
