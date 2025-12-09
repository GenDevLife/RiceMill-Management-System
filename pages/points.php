<?php
/**
 * Points Page
 * หน้าคะแนนสะสม
 */

$basePath = '../';
$pageTitle = 'คะแนนสะสม';
$currentPage = 'points';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';
include $basePath . 'includes/header.php';

$db = new Database();

// ดึงสมาชิกเรียงตามคะแนน
$members = $db->getMembersByPoints(50);
?>

<div class="container">
    <div class="single-contact-box">
        <h2>🏆 คะแนนสะสมสมาชิก</h2>
        
        <!-- Search Box -->
        <div class="search-container" style="margin: 20px 0;">
            <input type="text" 
                   id="searchInput" 
                   class="search-box" 
                   placeholder="🔍 ค้นหาชื่อสมาชิก..."
                   style="width: 100%;">
        </div>
        
        <table class="table" id="pointsTable">
            <thead>
                <tr>
                    <th width="60">อันดับ</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>คะแนนสะสม</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $rank = 1;
                foreach ($members as $member): 
                    $rankIcon = '';
                    if ($rank === 1) $rankIcon = '🥇';
                    elseif ($rank === 2) $rankIcon = '🥈';
                    elseif ($rank === 3) $rankIcon = '🥉';
                ?>
                <tr>
                    <td><?php echo $rankIcon ?: $rank; ?></td>
                    <td><?php echo htmlspecialchars($member['name']); ?></td>
                    <td><strong><?php echo number_format($member['points']); ?></strong> คะแนน</td>
                </tr>
                <?php 
                    $rank++;
                endforeach; 
                ?>
                
                <?php if (empty($members)): ?>
                <tr>
                    <td colspan="3" class="no-data">ไม่พบข้อมูลสมาชิก</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="button-group">
            <a href="<?php echo $basePath; ?>index.php" class="btn btn-secondary">← กลับหน้าหลัก</a>
        </div>
    </div>
</div>

<script>
// Simple search filter
$('#searchInput').on('input', function() {
    const keyword = $(this).val().toLowerCase();
    $('#pointsTable tbody tr').each(function() {
        const name = $(this).find('td:eq(1)').text().toLowerCase();
        $(this).toggle(name.includes(keyword));
    });
});
</script>

<?php include $basePath . 'includes/footer.php'; ?>
