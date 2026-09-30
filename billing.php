<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$pdo = getPdo();

$billing = $pdo->query('SELECT o.id, p.full_name AS patient_name, lt.name AS test_name, lt.price, o.status FROM test_orders o INNER JOIN patients p ON p.id = o.patient_id INNER JOIN lab_tests lt ON lt.id = o.test_id ORDER BY o.created_at DESC')->fetchAll();

$totalRevenue = 0;
foreach ($billing as $item) {
    $totalRevenue += (float) $item['price'];
}

include __DIR__ . '/includes/header.php';
?>

<section class="panel">
    <div class="panel-header">
        <h3>Billing Overview</h3>
    </div>

    <div class="cards-grid single-row">
        <div class="stat-card">
            <h3>Total Due</h3>
            <p>₹<?php echo number_format($totalRevenue, 2); ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Test</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($billing): ?>
                <?php foreach ($billing as $item): ?>
                    <tr>
                        <td>#<?php echo (int) $item['id']; ?></td>
                        <td><?php echo htmlspecialchars($item['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['test_name']); ?></td>
                        <td>₹<?php echo number_format((float) $item['price'], 2); ?></td>
                        <td><span class="status-badge"><?php echo htmlspecialchars($item['status']); ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty">No billing data found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
