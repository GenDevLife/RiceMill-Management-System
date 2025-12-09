<?php
/**
 * Receipt Page - Service Only
 * ใบเสร็จเฉพาะบริการ
 */

$basePath = '../../';

require_once $basePath . 'includes/config.php';
require_once $basePath . 'includes/Database.php';

$db = new Database($pdo);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบเสร็จ - Tech City โรงสีข้าว</title>
    <link href="<?php echo $basePath; ?>assets/images/TechTeam.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/receipt.css">
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <img src="<?php echo $basePath; ?>assets/images/TechTeam.png" alt="Logo" class="receipt-logo"
                 onclick="document.location='<?php echo $basePath; ?>index.php'">
            <h1 class="company-name">TECH TEAM</h1>
            <p class="company-address">25 ม.4 ต. ทะนง อ.โพทะเล จ.พิจิตร</p>
        </div>

        <?php
        // Get member info from latest service order
        $stmt = $pdo->prepare(
            "SELECT os.*, m.Member_Name, m.Member_Tel, m.Member_Id, m.Member_Point
             FROM orderservice os
             JOIN member m ON os.Member_Id = m.Member_Id
             ORDER BY os.OrderService_Id DESC LIMIT 1"
        );
        $stmt->execute();
        $order = $stmt->fetch();

        if ($order):
            $pricePerBucket = getServicePrice($order['ServiceProduct_Name']);
            $totalPrice = $pricePerBucket * $order['Bucket_Service'];
        ?>
            <div class="customer-info">
                <h2 class="customer-name"><?php echo htmlspecialchars($order['Member_Name']); ?></h2>
                <p class="customer-phone">เบอร์โทรศัพท์: <?php echo htmlspecialchars($order['Member_Tel']); ?></p>
                <p class="receipt-date" id="current-date"></p>
            </div>

            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>รายการ</th>
                        <th>จำนวน(ถัง)</th>
                        <th>ราคาต่อถัง</th>
                        <th>ราคา</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($order['ServiceProduct_Name']); ?></td>
                        <td><?php echo $order['Bucket_Service']; ?></td>
                        <td><?php echo number_format($pricePerBucket); ?></td>
                        <td><?php echo number_format($totalPrice); ?> บาท</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;"><strong>ราคารวมทั้งหมด:</strong></td>
                        <td><strong><?php echo number_format($totalPrice); ?> บาท</strong></td>
                    </tr>
                </tbody>
            </table>

            <?php
            $earnedPoints = calculatePoints($totalPrice);
            $newPoints = $order['Member_Point'] + $earnedPoints;
            
            // Update member points
            $db->updateMemberPoints($order['Member_Id'], $newPoints);
            ?>

            <div class="points-info">
                <p>คะแนนที่ได้รับ: +<?php echo number_format($earnedPoints); ?> คะแนน</p>
                <p>คะแนนสะสมทั้งหมด: <?php echo number_format($newPoints); ?> คะแนน</p>
            </div>

        <?php else: ?>
            <p class="no-data">ไม่พบข้อมูลการใช้บริการ</p>
        <?php endif; ?>

        <div class="receipt-footer">
            <p>ขอบคุณที่ใช้บริการ</p>
        </div>

        <button class="print-button" onclick="this.style.display='none'; window.print();">
            พิมพ์ใบเสร็จ
        </button>
    </div>

    <script>
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('th-TH', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    </script>
</body>
</html>
