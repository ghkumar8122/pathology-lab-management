<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$pdo = getPdo();
$stats = [
    'patients' => (int) $pdo->query('SELECT COUNT(*) FROM patients')->fetchColumn(),
    'tests' => (int) $pdo->query('SELECT COUNT(*) FROM lab_tests')->fetchColumn(),
    'orders' => (int) $pdo->query('SELECT COUNT(*) FROM test_orders')->fetchColumn(),
    'pending' => (int) $pdo->query("SELECT COUNT(*) FROM test_orders WHERE status != 'Completed' AND status != 'Reported'")->fetchColumn(),
    'revenue' => (float) $pdo->query('SELECT COALESCE(SUM(lt.price), 0) FROM test_orders o INNER JOIN lab_tests lt ON lt.id = o.test_id WHERE o.status IN ("Completed", "Reported")')->fetchColumn(),
];

$recentOrders = $pdo->query('SELECT o.id, p.full_name AS patient_name, lt.name AS test_name, o.status, o.created_at FROM test_orders o INNER JOIN patients p ON p.id = o.patient_id INNER JOIN lab_tests lt ON lt.id = o.test_id ORDER BY o.created_at DESC LIMIT 5')->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<section class="cards-grid">
    <div class="stat-card">
        <h3>Total Patients</h3>
        <p><?php echo number_format($stats['patients']); ?></p>
    </div>
    <div class="stat-card">
        <h3>Lab Tests</h3>
        <p><?php echo number_format($stats['tests']); ?></p>
    </div>
    <div class="stat-card">
        <h3>Orders</h3>
        <p><?php echo number_format($stats['orders']); ?></p>
    </div>
    <div class="stat-card accent">
        <h3>Revenue</h3>
        <p>₹<?php echo number_format($stats['revenue'], 2); ?></p>
    </div>
</section>

<section class="panel">
    <div class="panel-header">
        <h3>Recent Orders</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Test</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($recentOrders): ?>
                <?php foreach ($recentOrders as $order): ?>
                    <tr>
                        <td>#<?php echo (int) $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['test_name']); ?></td>
                        <td><span class="status-badge"><?php echo htmlspecialchars($order['status']); ?></span></td>
                        <td><?php echo htmlspecialchars(date('d M Y', strtotime($order['created_at']))); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty">No recent orders found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
