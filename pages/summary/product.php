<?php
/**
 * Summary - Product Only
 * หน้าสรุปรายการ (เฉพาะสินค้า)
 */

$basePath = '../../';
$pageTitle = 'สรุปรายการ';
$currentPage = 'product';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';
include $basePath . 'includes/header.php';

$db = new Database();

// รับข้อมูลจากหน้าก่อน
$memberId = isset($_POST['member_id']) ? (int)$_POST['member_id'] : 0;
$riceBranKg = isset($_POST['rice_bran_kg']) ? (float)$_POST['rice_bran_kg'] : 0;
$huskKg = isset($_POST['husk_kg']) ? (float)$_POST['husk_kg'] : 0;
$riceChunksKg = isset($_POST['rice_chunks_kg']) ? (float)$_POST['rice_chunks_kg'] : 0;
$brokenRiceKg = isset($_POST['broken_rice_kg']) ? (float)$_POST['broken_rice_kg'] : 0;

if ($memberId === 0) {
    header('Location: ' . $basePath . 'pages/members/select-for-product.php');
    exit;
}

// ดึงข้อมูลสมาชิก
$member = $db->getMember($memberId);

if (!$member) {
    header('Location: ' . $basePath . 'pages/members/select-for-product.php');
    exit;
}

// คำนวณราคาสินค้า
$totalPrice = calculateProductPrice($riceBranKg, $huskKg, $riceChunksKg, $brokenRiceKg);
$earnedPoints = calculatePoints($totalPrice);

if ($totalPrice <= 0) {
    header('Location: ' . $basePath . 'pages/orders/product-only.php');
    exit;
}
?>

<div class="container">
    <div class="single-contact-box">
        <h2>สรุปรายการ</h2>
        
        <!-- ข้อมูลสมาชิก -->
        <div class="summary" style="margin-bottom: 20px;">
            <div><strong>สมาชิก:</strong> <?php echo htmlspecialchars($member['name']); ?></div>
            <div><strong>เบอร์โทร:</strong> <?php echo htmlspecialchars($member['phone']); ?></div>
        </div>
        
        <div class="summary-section">
            <div class="summary-category">
                <h3>📦 รายการสินค้า</h3>
                <div class="summary-items">
                    <?php if ($riceBranKg > 0): ?>
                    <div class="summary-item">
                        <span>รำข้าว (<?php echo number_format($riceBranKg, 1); ?> กก.)</span>
                        <span><?php echo number_format($riceBranKg * PRICE_RICE_BRAN, 2); ?> บาท</span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($huskKg > 0): ?>
                    <div class="summary-item">
                        <span>แกลบ (<?php echo number_format($huskKg, 1); ?> กก.)</span>
                        <span><?php echo number_format($huskKg * PRICE_HUSK, 2); ?> บาท</span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($riceChunksKg > 0): ?>
                    <div class="summary-item">
                        <span>ข้าวท่อน (<?php echo number_format($riceChunksKg, 1); ?> กก.)</span>
                        <span><?php echo number_format($riceChunksKg * PRICE_RICE_CHUNKS, 2); ?> บาท</span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($brokenRiceKg > 0): ?>
                    <div class="summary-item">
                        <span>ข้าวปลาย (<?php echo number_format($brokenRiceKg, 1); ?> กก.)</span>
                        <span><?php echo number_format($brokenRiceKg * PRICE_BROKEN_RICE, 2); ?> บาท</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- ยอดรวม -->
            <div class="summary-total">
                <p><strong>ยอดรวมทั้งหมด: <?php echo number_format($totalPrice, 2); ?> บาท</strong></p>
                <p style="color: green;">ได้รับ <?php echo $earnedPoints; ?> คะแนน</p>
            </div>
        </div>
        
        <form action="<?php echo $basePath; ?>pages/receipts/product.php" method="POST">
            <input type="hidden" name="member_id" value="<?php echo $memberId; ?>">
            <input type="hidden" name="rice_bran_kg" value="<?php echo $riceBranKg; ?>">
            <input type="hidden" name="husk_kg" value="<?php echo $huskKg; ?>">
            <input type="hidden" name="rice_chunks_kg" value="<?php echo $riceChunksKg; ?>">
            <input type="hidden" name="broken_rice_kg" value="<?php echo $brokenRiceKg; ?>">
            <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
            <input type="hidden" name="earned_points" value="<?php echo $earnedPoints; ?>">
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">ยืนยัน - ออกใบเสร็จ →</button>
                <a href="<?php echo $basePath; ?>pages/members/select-for-product.php" class="btn btn-secondary">← เริ่มใหม่</a>
            </div>
        </form>
    </div>
</div>

<?php include $basePath . 'includes/footer.php'; ?>
