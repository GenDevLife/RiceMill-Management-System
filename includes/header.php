<?php
/**
 * Header Component
 * Reusable header/navigation for all pages
 */

// Determine active page for navigation highlighting
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Tech City โรงสีข้าว</title>
    
    <!-- Favicon -->
    <link href="<?php echo $basePath ?? ''; ?>assets/images/TechTeam.png" rel="icon">
    
    <!-- Google Fonts - Kanit -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?php echo $basePath ?? ''; ?>assets/css/style.css">
    
    <?php if (isset($additionalCss)): ?>
        <?php foreach ($additionalCss as $css): ?>
            <link rel="stylesheet" href="<?php echo $basePath ?? ''; ?>assets/css/<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="header">
        <div class="menu">
            <div class="logo">
                <img onclick="document.location='<?php echo $basePath ?? ''; ?>index.php'" 
                     class="img-fluid h-100" 
                     src="<?php echo $basePath ?? ''; ?>assets/images/TechTeam.png" 
                     alt="Tech City Logo">
            </div>
            <nav class="main-nav">
                <a href="<?php echo $basePath ?? ''; ?>pages/members/select-for-service.php" 
                   class="<?php echo $currentPage === 'select-for-service.php' ? 'active' : ''; ?>">
                    บริการและสินค้า
                </a>
                <a href="<?php echo $basePath ?? ''; ?>pages/members/select-for-product.php"
                   class="<?php echo $currentPage === 'select-for-product.php' ? 'active' : ''; ?>">
                    สินค้า
                </a>
                <a href="<?php echo $basePath ?? ''; ?>pages/points.php"
                   class="<?php echo $currentPage === 'points.php' ? 'active' : ''; ?>">
                    คะแนนสะสม
                </a>
                <a href="<?php echo $basePath ?? ''; ?>pages/auth/register.php"
                   class="<?php echo $currentPage === 'register.php' ? 'active' : ''; ?>">
                    สมัครสมาชิก
                </a>
                <a href="<?php echo $basePath ?? ''; ?>pages/auth/login.php"
                   class="<?php echo $currentPage === 'login.php' ? 'active' : ''; ?>">
                    เข้าสู่ระบบ
                </a>
            </nav>
        </div>
    </div>
    <main class="main-content">
