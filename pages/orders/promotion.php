<?php
/**
 * Order Promotion
 * หน้าแลกโปรโมชั่น
 */

$basePath = '../../';
$pageTitle = 'แลกโปรโมชั่น';
$currentPage = 'promotion';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';
include $basePath . 'includes/header.php';

$db = new Database();

// รับ member_id จากหน้าก่อน
$memberId = isset($_POST['member_id']) ? (int)$_POST['member_id'] : 0;

if ($memberId === 0) {
    header('Location: ' . $basePath . 'pages/members/select-for-promotion.php');
    exit;
}

// ดึงข้อมูลสมาชิก
$member = $db->getMember($memberId);

if (!$member) {
    header('Location: ' . $basePath . 'pages/members/select-for-promotion.php');
    exit;
}

$currentPoints = $member['points'];
?>

<div class="container">
    <div class="single-contact-box">
        <h2>แลกโปรโมชั่น</h2>
        
        <!-- ข้อมูลสมาชิก -->
        <div class="summary" style="margin-bottom: 20px;">
            <div><strong>สมาชิก:</strong> <?php echo htmlspecialchars($member['name']); ?></div>
            <div><strong>เบอร์โทร:</strong> <?php echo htmlspecialchars($member['phone']); ?></div>
            <div><strong>คะแนนสะสม:</strong> <span style="color: green; font-size: 1.2em;"><?php echo number_format($currentPoints); ?></span> คะแนน</div>
        </div>
        
        <form action="<?php echo $basePath; ?>pages/receipts/promotion.php" method="POST" id="promotionForm">
            <input type="hidden" name="member_id" value="<?php echo $memberId; ?>">
            
            <div class="service_product-details">
                <h3>เลือกโปรโมชั่น</h3>
                
                <div class="radio-group promotion-options">
                    <!-- สีข้าวฟรี 50 กก. -->
                    <label class="radio-option <?php echo $currentPoints < POINTS_FREE_MILL ? 'disabled' : ''; ?>">
                        <input type="radio" name="promotion_type" value="mill" 
                               <?php echo $currentPoints < POINTS_FREE_MILL ? 'disabled' : ''; ?> required>
                        <span class="promo-text">
                            <strong>สีข้าวฟรี 50 กก.</strong>
                            <small>ใช้ <?php echo number_format(POINTS_FREE_MILL); ?> คะแนน 
                                <?php if ($currentPoints < POINTS_FREE_MILL): ?>
                                    <span style="color: red;">(คะแนนไม่พอ)</span>
                                <?php endif; ?>
                            </small>
                        </span>
                    </label>
                    
                    <!-- คัด/ฝัดฟรี 50 กก. -->
                    <label class="radio-option <?php echo $currentPoints < POINTS_FREE_SORT ? 'disabled' : ''; ?>">
                        <input type="radio" name="promotion_type" value="sort" 
                               <?php echo $currentPoints < POINTS_FREE_SORT ? 'disabled' : ''; ?>>
                        <span class="promo-text">
                            <strong>คัด/ฝัดเมล็ดข้าวฟรี 50 กก.</strong>
                            <small>ใช้ <?php echo number_format(POINTS_FREE_SORT); ?> คะแนน
                                <?php if ($currentPoints < POINTS_FREE_SORT): ?>
                                    <span style="color: red;">(คะแนนไม่พอ)</span>
                                <?php endif; ?>
                            </small>
                        </span>
                    </label>
                    
                    <!-- อบข้าวฟรี 50 กก. -->
                    <label class="radio-option <?php echo $currentPoints < POINTS_FREE_DRY ? 'disabled' : ''; ?>">
                        <input type="radio" name="promotion_type" value="dry" 
                               <?php echo $currentPoints < POINTS_FREE_DRY ? 'disabled' : ''; ?>>
                        <span class="promo-text">
                            <strong>อบข้าวฟรี 50 กก.</strong>
                            <small>ใช้ <?php echo number_format(POINTS_FREE_DRY); ?> คะแนน
                                <?php if ($currentPoints < POINTS_FREE_DRY): ?>
                                    <span style="color: red;">(คะแนนไม่พอ)</span>
                                <?php endif; ?>
                            </small>
                        </span>
                    </label>
                </div>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">ยืนยันการแลก →</button>
                <a href="<?php echo $basePath; ?>pages/members/select-for-promotion.php" class="btn btn-secondary">← กลับ</a>
            </div>
        </form>
    </div>
</div>

<style>
.radio-option.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>

<script>
$('#promotionForm').on('submit', function(e) {
    if (!$('input[name="promotion_type"]:checked').length) {
        e.preventDefault();
        alert('กรุณาเลือกโปรโมชั่น');
    }
});
</script>

<?php include $basePath . 'includes/footer.php'; ?>
