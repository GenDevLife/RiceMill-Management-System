<?php
/**
 * Register Page
 * หน้าสมัครสมาชิก
 */

$basePath = '../../';
$pageTitle = 'สมัครสมาชิก';
$currentPage = 'register';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';
include $basePath . 'includes/header.php';

$db = new Database();

$message = '';
$messageType = '';

// ถ้า submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $subdistrict = sanitize($_POST['subdistrict'] ?? '');
    $district = sanitize($_POST['district'] ?? '');
    $province = sanitize($_POST['province'] ?? 'พิจิตร');
    
    // Validate
    if (empty($name) || empty($phone)) {
        $message = 'กรุณากรอกชื่อและเบอร์โทร';
        $messageType = 'error';
    } else {
        try {
            $memberId = $db->registerMember($name, $phone, $address, $subdistrict, $district, $province);
            $message = "สมัครสมาชิกสำเร็จ! รหัสสมาชิก: $memberId";
            $messageType = 'success';
        } catch (Exception $e) {
            $message = 'เกิดข้อผิดพลาด: ' . $e->getMessage();
            $messageType = 'error';
        }
    }
}
?>

<div class="container">
    <div class="single-contact-box">
        <h2>สมัครสมาชิกใหม่</h2>
        
        <?php if ($message): ?>
        <div class="alert alert-<?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>
        
        <form method="POST" class="register-form">
            <div class="form-group">
                <label for="name">ชื่อ-นามสกุล *</label>
                <input type="text" id="name" name="name" required placeholder="กรอกชื่อ-นามสกุล">
            </div>
            
            <div class="form-group">
                <label for="phone">เบอร์โทรศัพท์ *</label>
                <input type="tel" id="phone" name="phone" required placeholder="เช่น 0812345678" 
                       pattern="[0-9]{10}" maxlength="10">
            </div>
            
            <div class="form-group">
                <label for="address">ที่อยู่</label>
                <input type="text" id="address" name="address" placeholder="เช่น 123 ม.5">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="subdistrict">ตำบล</label>
                    <input type="text" id="subdistrict" name="subdistrict" placeholder="ตำบล">
                </div>
                
                <div class="form-group">
                    <label for="district">อำเภอ</label>
                    <input type="text" id="district" name="district" placeholder="อำเภอ">
                </div>
            </div>
            
            <div class="form-group">
                <label for="province">จังหวัด</label>
                <input type="text" id="province" name="province" value="พิจิตร" placeholder="จังหวัด">
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
                <a href="<?php echo $basePath; ?>index.php" class="btn btn-secondary">← กลับหน้าหลัก</a>
            </div>
        </form>
    </div>
</div>

<style>
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@media (max-width: 600px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include $basePath . 'includes/footer.php'; ?>
