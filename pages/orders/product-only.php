<?php
/**
 * Order Product Only
 * หน้าสั่งเฉพาะสินค้า
 */

$basePath = '../../';
$pageTitle = 'สั่งสินค้า';
$currentPage = 'product';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';
include $basePath . 'includes/header.php';

$db = new Database();

// รับ member_id จากหน้าก่อน
$memberId = isset($_POST['member_id']) ? (int)$_POST['member_id'] : 0;

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
?>

<div class="container">
    <div class="single-contact-box">
        <h2>สั่งสินค้า</h2>
        
        <!-- ข้อมูลสมาชิก -->
        <div class="summary" style="margin-bottom: 20px;">
            <div><strong>สมาชิก:</strong> <?php echo htmlspecialchars($member['name']); ?></div>
            <div><strong>เบอร์โทร:</strong> <?php echo htmlspecialchars($member['phone']); ?></div>
            <div><strong>คะแนนสะสม:</strong> <?php echo number_format($member['points']); ?> คะแนน</div>
        </div>
        
        <form action="<?php echo $basePath; ?>pages/summary/product.php" method="POST">
            <input type="hidden" name="member_id" value="<?php echo $memberId; ?>">
            
            <div class="service_product-details">
                <h3>เลือกสินค้า</h3>
                <p style="color: #666; font-size: 0.9rem;">กรอกจำนวน กก. ที่ต้องการซื้อ</p>
                
                <div class="product-list">
                    <div class="product-item">
                        <label>รำข้าว (<?php echo PRICE_RICE_BRAN; ?> บาท/กก.)</label>
                        <input type="number" name="rice_bran_kg" min="0" max="1000" value="0" step="0.1">
                        <span class="unit">กก.</span>
                    </div>
                    
                    <div class="product-item">
                        <label>แกลบ (<?php echo PRICE_HUSK; ?> บาท/กก.)</label>
                        <input type="number" name="husk_kg" min="0" max="1000" value="0" step="0.1">
                        <span class="unit">กก.</span>
                    </div>
                    
                    <div class="product-item">
                        <label>ข้าวท่อน (<?php echo PRICE_RICE_CHUNKS; ?> บาท/กก.)</label>
                        <input type="number" name="rice_chunks_kg" min="0" max="1000" value="0" step="0.1">
                        <span class="unit">กก.</span>
                    </div>
                    
                    <div class="product-item">
                        <label>ข้าวปลาย (<?php echo PRICE_BROKEN_RICE; ?> บาท/กก.)</label>
                        <input type="number" name="broken_rice_kg" min="0" max="1000" value="0" step="0.1">
                        <span class="unit">กก.</span>
                    </div>
                </div>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">ดูสรุปรายการ →</button>
                <a href="<?php echo $basePath; ?>pages/members/select-for-product.php" class="btn btn-secondary">← กลับ</a>
            </div>
        </form>
    </div>
</div>

<?php include $basePath . 'includes/footer.php'; ?>
