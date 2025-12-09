<?php
/**
 * Receipt - Product Only
 * หน้าใบเสร็จ (เฉพาะสินค้า)
 */

$basePath = '../../';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';

$db = new Database();

// รับข้อมูลจากหน้าก่อน
$memberId = isset($_POST['member_id']) ? (int)$_POST['member_id'] : 0;
$riceBranKg = isset($_POST['rice_bran_kg']) ? (float)$_POST['rice_bran_kg'] : 0;
$huskKg = isset($_POST['husk_kg']) ? (float)$_POST['husk_kg'] : 0;
$riceChunksKg = isset($_POST['rice_chunks_kg']) ? (float)$_POST['rice_chunks_kg'] : 0;
$brokenRiceKg = isset($_POST['broken_rice_kg']) ? (float)$_POST['broken_rice_kg'] : 0;
$totalPrice = isset($_POST['total_price']) ? (float)$_POST['total_price'] : 0;
$earnedPoints = isset($_POST['earned_points']) ? (int)$_POST['earned_points'] : 0;

if ($memberId === 0) {
    header('Location: ' . $basePath . 'index.php');
    exit;
}

// ดึงข้อมูลสมาชิก
$member = $db->getMember($memberId);

if (!$member) {
    header('Location: ' . $basePath . 'index.php');
    exit;
}

// บันทึกข้อมูลลง database
try {
    // บันทึกสินค้า
    $db->insertOrderProduct($memberId, $riceBranKg, $huskKg, $riceChunksKg, $brokenRiceKg, $totalPrice);
    
    // เพิ่มคะแนน
    $db->addMemberPoints($memberId, $earnedPoints);
    
    // ดึงข้อมูลสมาชิกใหม่
    $member = $db->getMember($memberId);
    
} catch (Exception $e) {
    error_log("Receipt Error: " . $e->getMessage());
}

$pageTitle = 'ใบเสร็จ';
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
    <div class="receipt-container">
        <div class="receipt-header">
            <img src="<?php echo $basePath; ?>assets/images/TechTeam.png" alt="Logo" class="receipt-logo"
                 onclick="window.location='<?php echo $basePath; ?>index.php'">
            <p class="company-name">Tech City โรงสีข้าว</p>
            <p class="company-address">จังหวัดพิจิตร</p>
        </div>
        
        <div class="customer-info">
            <p class="customer-name"><?php echo htmlspecialchars($member['name']); ?></p>
            <p class="customer-phone">โทร: <?php echo htmlspecialchars($member['phone']); ?></p>
            <p class="receipt-date"><?php echo formatDateThai(date('Y-m-d')); ?></p>
        </div>
        
        <table class="receipt-table">
            <thead>
                <tr>
                    <th>รายการ</th>
                    <th>จำนวน</th>
                    <th>ราคา</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($riceBranKg > 0): ?>
                <tr>
                    <td>รำข้าว</td>
                    <td><?php echo number_format($riceBranKg, 1); ?> กก.</td>
                    <td><?php echo number_format($riceBranKg * PRICE_RICE_BRAN, 2); ?></td>
                </tr>
                <?php endif; ?>
                
                <?php if ($huskKg > 0): ?>
                <tr>
                    <td>แกลบ</td>
                    <td><?php echo number_format($huskKg, 1); ?> กก.</td>
                    <td><?php echo number_format($huskKg * PRICE_HUSK, 2); ?></td>
                </tr>
                <?php endif; ?>
                
                <?php if ($riceChunksKg > 0): ?>
                <tr>
                    <td>ข้าวท่อน</td>
                    <td><?php echo number_format($riceChunksKg, 1); ?> กก.</td>
                    <td><?php echo number_format($riceChunksKg * PRICE_RICE_CHUNKS, 2); ?></td>
                </tr>
                <?php endif; ?>
                
                <?php if ($brokenRiceKg > 0): ?>
                <tr>
                    <td>ข้าวปลาย</td>
                    <td><?php echo number_format($brokenRiceKg, 1); ?> กก.</td>
                    <td><?php echo number_format($brokenRiceKg * PRICE_BROKEN_RICE, 2); ?></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="grand-total">
            <p><strong>ยอดรวม: <?php echo number_format($totalPrice, 2); ?> บาท</strong></p>
        </div>
        
        <div class="points-info">
            <p>ได้รับคะแนน: <strong>+<?php echo $earnedPoints; ?></strong> คะแนน</p>
            <p class="points-remaining">คะแนนสะสมรวม: <strong><?php echo number_format($member['points']); ?></strong> คะแนน</p>
        </div>
        
        <div class="receipt-footer">
            <p>ขอบคุณที่ใช้บริการ ❤️</p>
        </div>
        
        <button class="print-button" onclick="window.print()">🖨️ พิมพ์ใบเสร็จ</button>
        <a href="<?php echo $basePath; ?>index.php" class="print-button" style="background: #666; margin-top: 10px; text-decoration: none; display: block; text-align: center;">← กลับหน้าหลัก</a>
    </div>
</body>
</html>
