<?php
/**
 * Order Service
 * หน้าสั่งบริการสีข้าว
 */

$basePath = '../../';
$pageTitle = 'สั่งบริการ';
$currentPage = 'service';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';
include $basePath . 'includes/header.php';

$db = new Database();

// รับ member_id จากหน้าก่อน
$memberId = isset($_POST['member_id']) ? (int)$_POST['member_id'] : 0;

if ($memberId === 0) {
    header('Location: ' . $basePath . 'pages/members/select-for-service.php');
    exit;
}

// ดึงข้อมูลสมาชิก
$member = $db->getMember($memberId);

if (!$member) {
    header('Location: ' . $basePath . 'pages/members/select-for-service.php');
    exit;
}
?>

<div class="container">
    <div class="single-contact-box">
        <h2>สั่งบริการ</h2>
        
        <!-- ข้อมูลสมาชิก -->
        <div class="summary" style="margin-bottom: 20px;">
            <div><strong>สมาชิก:</strong> <?php echo htmlspecialchars($member['name']); ?></div>
            <div><strong>เบอร์โทร:</strong> <?php echo htmlspecialchars($member['phone']); ?></div>
            <div><strong>คะแนนสะสม:</strong> <?php echo number_format($member['points']); ?> คะแนน</div>
        </div>
        
        <form action="<?php echo $basePath; ?>pages/orders/product.php" method="POST">
            <input type="hidden" name="member_id" value="<?php echo $memberId; ?>">
            
            <div class="service_product-details">
                <h3>เลือกบริการ</h3>
                
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="service_type" value="mill" required>
                        <span class="promo-text">
                            <strong>สีข้าว</strong>
                            <small><?php echo PRICE_MILL; ?> บาท/กก.</small>
                        </span>
                    </label>
                    
                    <label class="radio-option">
                        <input type="radio" name="service_type" value="sort">
                        <span class="promo-text">
                            <strong>คัด/ฝัดเมล็ดข้าว</strong>
                            <small><?php echo PRICE_SORT; ?> บาท/กก.</small>
                        </span>
                    </label>
                    
                    <label class="radio-option">
                        <input type="radio" name="service_type" value="dry">
                        <span class="promo-text">
                            <strong>อบข้าว</strong>
                            <small><?php echo PRICE_DRY; ?> บาท/กก.</small>
                        </span>
                    </label>
                </div>
                
                <div class="form-group" style="margin-top: 20px;">
                    <label for="weight_kg">น้ำหนักข้าว (กก.)</label>
                    <input type="number" 
                           id="weight_kg" 
                           name="weight_kg" 
                           min="1" 
                           max="10000" 
                           required
                           placeholder="กรอกน้ำหนัก">
                </div>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">ถัดไป - สั่งสินค้า →</button>
                <a href="<?php echo $basePath; ?>pages/members/select-for-service.php" class="btn btn-secondary">← กลับ</a>
            </div>
        </form>
    </div>
</div>

<?php include $basePath . 'includes/footer.php'; ?>
