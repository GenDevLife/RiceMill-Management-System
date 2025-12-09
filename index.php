<?php
/**
 * Homepage - Rice Mill Management System
 * Tech City โรงสีข้าว
 */

$basePath = '';
$pageTitle = 'หน้าหลัก';
$currentPage = 'home';

// Include header
include 'includes/header.php';
?>

<div class="action-buttons">
    <button onclick="document.location='pages/members/select-for-service.php'">
        บริการและสินค้า
    </button>
    <button onclick="document.location='pages/members/select-for-product.php'">
        สินค้า
    </button>
    <button onclick="document.location='pages/points.php'">
        คะแนนสะสม
    </button>
    <button onclick="document.location='pages/members/select-for-promotion.php'">
        ใช้โปรโมชั่น
    </button>
    <button onclick="document.location='pages/auth/register.php'">
        สมัครสมาชิก
    </button>
</div>

<?php include 'includes/footer.php'; ?>
