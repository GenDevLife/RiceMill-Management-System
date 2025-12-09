<?php
/**
 * Member Selection - For Service + Product
 * เลือกสมาชิกสำหรับใช้บริการและซื้อสินค้า
 */

$basePath = '../../';
$pageTitle = 'เลือกสมาชิก - บริการและสินค้า';
$currentPage = 'service';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';
include $basePath . 'includes/header.php';

$db = new Database();
?>

<div class="container">
    <div class="single-contact-box">
        <h2>เลือกสมาชิก</h2>
        <p style="text-align: center; color: #666;">สำหรับใช้บริการสีข้าวและซื้อสินค้า</p>
        
        <!-- Search Box -->
        <div class="search-container" style="margin: 20px 0;">
            <input type="text" 
                   id="searchInput" 
                   class="search-box" 
                   placeholder="🔍 ค้นหาชื่อหรือเบอร์โทร..."
                   style="width: 100%;">
        </div>
        
        <!-- Member Table -->
        <form action="<?php echo $basePath; ?>pages/orders/service.php" method="POST" id="memberForm">
            <div id="memberList">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="50">เลือก</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>เบอร์โทร</th>
                            <th>คะแนน</th>
                        </tr>
                    </thead>
                    <tbody id="memberTableBody">
                        <tr>
                            <td colspan="4" class="no-data">กำลังโหลด...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">ถัดไป →</button>
                <a href="<?php echo $basePath; ?>index.php" class="btn btn-secondary">← กลับหน้าหลัก</a>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load all members initially
    loadMembers('');
    
    // Search on typing
    let searchTimeout;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimeout);
        const keyword = $(this).val();
        searchTimeout = setTimeout(() => {
            loadMembers(keyword);
        }, 300);
    });
    
    // Validate form
    $('#memberForm').on('submit', function(e) {
        if (!$('input[name="member_id"]:checked').length) {
            e.preventDefault();
            alert('กรุณาเลือกสมาชิก');
        }
    });
});

function loadMembers(keyword) {
    $.ajax({
        url: '<?php echo $basePath; ?>pages/api/search-members.php',
        method: 'GET',
        data: { q: keyword },
        dataType: 'json',
        success: function(data) {
            let html = '';
            if (data.length === 0) {
                html = '<tr><td colspan="4" class="no-data">ไม่พบสมาชิก</td></tr>';
            } else {
                data.forEach(function(member) {
                    html += `
                        <tr>
                            <td>
                                <input type="radio" name="member_id" value="${member.id}" required>
                            </td>
                            <td>${member.name}</td>
                            <td>${member.phone}</td>
                            <td><strong>${member.points}</strong></td>
                        </tr>
                    `;
                });
            }
            $('#memberTableBody').html(html);
        },
        error: function() {
            $('#memberTableBody').html('<tr><td colspan="4" class="no-data">เกิดข้อผิดพลาด</td></tr>');
        }
    });
}
</script>

<?php include $basePath . 'includes/footer.php'; ?>
