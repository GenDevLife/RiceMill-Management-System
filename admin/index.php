<?php
/**
 * Admin Dashboard
 * หน้าแดชบอร์ดผู้ดูแลระบบ
 */

session_start();

$basePath = '../';
$pageTitle = 'แดชบอร์ดผู้ดูแล';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';

$db = new Database();

// ดึงสถิติ
$totalMembers = $db->countMembers();
$todaySales = $db->getTodaySales();
$todayOrders = $db->getTodayOrderCount();

// ดึงสมาชิกล่าสุด 10 คน
$recentMembers = $db->getMembers(10, 0);

// ดึงยอดขายรายเดือน (เดือนปัจจุบัน)
$currentMonth = date('n');
$currentYear = date('Y');
$monthlySales = $db->getMonthlySales($currentYear, $currentMonth);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Tech City โรงสีข้าว</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .admin-header h1 {
            font-size: 1.8rem;
            color: var(--primary-color);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, var(--card-bg), #ffffff);
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--shadow);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card.primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }
        
        .stat-card.success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .stat-card.warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }
        
        .stat-card.info {
            background: linear-gradient(135deg, #17a2b8, #6f42c1);
            color: white;
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .section-title {
            font-size: 1.3rem;
            color: var(--text-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-color);
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card-bg);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        
        .data-table th,
        .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .data-table th {
            background: var(--primary-color);
            color: white;
            font-weight: 500;
        }
        
        .data-table tr:hover {
            background: rgba(0, 0, 0, 0.02);
        }
        
        .nav-buttons {
            display: flex;
            gap: 10px;
        }
        
        .nav-buttons a {
            padding: 10px 20px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s;
        }
        
        .nav-buttons a:hover {
            background: var(--secondary-color);
        }
        
        .nav-buttons a.secondary {
            background: #6c757d;
        }
        
        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                gap: 15px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>📊 แดชบอร์ดผู้ดูแลระบบ</h1>
            <div class="nav-buttons">
                <a href="<?php echo $basePath; ?>index.php">🏠 หน้าหลัก</a>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-icon">👥</div>
                <div class="stat-value"><?php echo number_format($totalMembers); ?></div>
                <div class="stat-label">สมาชิกทั้งหมด</div>
            </div>
            
            <div class="stat-card success">
                <div class="stat-icon">💰</div>
                <div class="stat-value"><?php echo number_format($todaySales, 0); ?></div>
                <div class="stat-label">ยอดขายวันนี้ (บาท)</div>
            </div>
            
            <div class="stat-card warning">
                <div class="stat-icon">📦</div>
                <div class="stat-value"><?php echo number_format($todayOrders); ?></div>
                <div class="stat-label">รายการวันนี้</div>
            </div>
            
            <div class="stat-card info">
                <div class="stat-icon">📅</div>
                <div class="stat-value"><?php echo number_format($monthlySales, 0); ?></div>
                <div class="stat-label">ยอดขายเดือนนี้ (บาท)</div>
            </div>
        </div>
        
        <!-- Recent Members -->
        <h3 class="section-title">👥 สมาชิกล่าสุด</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>เบอร์โทร</th>
                    <th>คะแนน</th>
                    <th>วันที่สมัคร</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentMembers as $member): ?>
                <tr>
                    <td><?php echo $member['id']; ?></td>
                    <td><?php echo htmlspecialchars($member['name']); ?></td>
                    <td><?php echo htmlspecialchars($member['phone']); ?></td>
                    <td><strong><?php echo number_format($member['points']); ?></strong></td>
                    <td><?php echo $member['created_at']; ?></td>
                </tr>
                <?php endforeach; ?>
                
                <?php if (empty($recentMembers)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #999;">ไม่พบข้อมูลสมาชิก</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
