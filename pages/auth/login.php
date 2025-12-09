<?php
/**
 * Login Page
 * Owner/Admin authentication
 */
session_start();

$basePath = '../../';
$pageTitle = 'เข้าสู่ระบบ';
$additionalCss = ['login.css'];
$error_message = '';

// Process login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correct_username = "owner";
    $correct_password = "12345678";
    
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = true;
        header("Location: ../../admin/index.php");
        exit;
    } else {
        $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Tech City โรงสีข้าว</title>
    <link href="<?php echo $basePath; ?>assets/images/TechTeam.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <img src="<?php echo $basePath; ?>assets/images/TechTeam.png" alt="Tech Team Logo" class="login-logo">
        <h2>เข้าสู่ระบบ</h2>
        
        <form method="post" class="login-form">
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้:</label>
                <input type="text" id="username" name="username" required 
                       placeholder="กรอกชื่อผู้ใช้">
            </div>
            
            <div class="form-group">
                <label for="password">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required 
                       placeholder="กรอกรหัสผ่าน">
            </div>
            
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            
            <div class="button-group">
                <button type="button" class="btn-secondary" 
                        onclick="document.location='<?php echo $basePath; ?>index.php'">
                    ย้อนกลับ
                </button>
                <button type="submit" class="btn-primary">
                    เข้าสู่ระบบ
                </button>
            </div>
        </form>
    </div>
</body>
</html>
