<?php
/**
 * Summary Page - Service Only
 * สรุปรายการเฉพาะบริการ
 */
session_start();

$basePath = '../../';
$pageTitle = 'สรุปรายการบริการ';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';

$db = new Database($pdo);

// Get latest service order
$orderService = $db->getLatestOrderService();

include $basePath . 'includes/header.php';
?>

<section class="summary-section">
    <div class="container">
        <div class="summary-box">
            <h2>สรุปรายการ</h2>
            
            <?php if ($orderService): ?>
                <div class="summary-items">
                    <div class="summary-item">
                        <span class="item-name"><?php echo htmlspecialchars($orderService['ServiceProduct_Name']); ?></span>
                    </div>
                    <div class="summary-detail">
                        <p>จำนวน: <?php echo $orderService['Bucket_Service']; ?> ถัง</p>
                        <p>ราคารวม: <?php echo number_format($orderService['Total_Service']); ?> บาท</p>
                    </div>
                </div>
                
                <div class="summary-total">
                    <p><strong>ราคารวมทั้งหมด: <?php echo number_format($orderService['Total_Service']); ?> บาท</strong></p>
                    <p>คะแนนสะสมที่ได้: <?php echo calculatePoints($orderService['Total_Service']); ?> คะแนน</p>
                </div>
            <?php else: ?>
                <p class="no-data">ไม่พบข้อมูลบริการ</p>
            <?php endif; ?>
            
            <div class="button-group">
                <button class="btn-secondary" onclick="document.location='../orders/service.php'">
                    ย้อนกลับ
                </button>
                <button class="btn-primary" onclick="document.location='../receipts/service.php'">
                    ยืนยัน
                </button>
            </div>
        </div>
    </div>
</section>

<?php include $basePath . 'includes/footer.php'; ?>
