<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$pdo = getPdo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = (int) ($_POST['order_id'] ?? 0);
    $status = $_POST['status'] ?? 'Pending';
    $reportText = trim($_POST['report_text'] ?? '');

    if ($orderId <= 0) {
        $_SESSION['flash_error'] = 'Invalid order selected.';
    } else {
        $stmt = $pdo->prepare('UPDATE test_orders SET status = :status, report_text = :report_text WHERE id = :id');
        $stmt->execute([
            'status' => $status,
            'report_text' => $reportText,
            'id' => $orderId,
        ]);

        $_SESSION['flash_success'] = 'Report updated successfully.';
        header('Location: reports.php');
        exit;
    }
}

$orders = $pdo->query('SELECT o.id, p.full_name AS patient_name, lt.name AS test_name, o.status, o.report_text, o.created_at FROM test_orders o INNER JOIN patients p ON p.id = o.patient_id INNER JOIN lab_tests lt ON lt.id = o.test_id ORDER BY o.created_at DESC')->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<section class="panel">
    <div class="panel-header">
        <h3>Report Management</h3>
    </div>

    <?php if ($orders): ?>
        <?php foreach ($orders as $order): ?>
            <form method="POST" class="report-form">
                <input type="hidden" name="order_id" value="<?php echo (int) $order['id']; ?>">
                <div class="report-row">
                    <div>
                        <strong>#<?php echo (int) $order['id']; ?> - <?php echo htmlspecialchars($order['patient_name']); ?></strong><br>
                        <span><?php echo htmlspecialchars($order['test_name']); ?></span>
                    </div>
                    <div class="report-controls">
                        <select name="status">
                            <option value="Pending" <?php echo $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="In Progress" <?php echo $order['status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="Completed" <?php echo $order['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="Reported" <?php echo $order['status'] === 'Reported' ? 'selected' : ''; ?>>Reported</option>
                        </select>
                        <button type="submit" class="btn primary">Update</button>
                    </div>
                </div>
                <textarea name="report_text" rows="4" placeholder="Enter final pathology report..."><?php echo htmlspecialchars($order['report_text'] ?? ''); ?></textarea>
            </form>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="empty">No orders available for reporting.</p>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
