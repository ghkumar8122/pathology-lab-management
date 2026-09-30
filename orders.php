<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$pdo = getPdo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientId = (int) ($_POST['patient_id'] ?? 0);
    $testId = (int) ($_POST['test_id'] ?? 0);
    $requestedBy = trim($_POST['requested_by'] ?? '');

    if ($patientId <= 0 || $testId <= 0) {
        $_SESSION['flash_error'] = 'Please select a patient and a test.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO test_orders (patient_id, test_id, requested_by, status, sample_collected_at) VALUES (:patient_id, :test_id, :requested_by, :status, NOW())');
        $stmt->execute([
            'patient_id' => $patientId,
            'test_id' => $testId,
            'requested_by' => $requestedBy,
            'status' => 'Pending',
        ]);

        $_SESSION['flash_success'] = 'Test order created successfully.';
        header('Location: orders.php');
        exit;
    }
}

$patients = $pdo->query('SELECT * FROM patients ORDER BY full_name ASC')->fetchAll();
$tests = $pdo->query('SELECT * FROM lab_tests ORDER BY name ASC')->fetchAll();
$orders = $pdo->query('SELECT o.id, p.full_name AS patient_name, lt.name AS test_name, o.status, o.created_at FROM test_orders o INNER JOIN patients p ON p.id = o.patient_id INNER JOIN lab_tests lt ON lt.id = o.test_id ORDER BY o.created_at DESC')->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<section class="panel">
    <div class="panel-header">
        <h3>Create Test Order</h3>
    </div>

    <form method="POST" class="grid-form">
        <div class="form-group">
            <label>Patient</label>
            <select name="patient_id" required>
                <option value="">Select patient</option>
                <?php foreach ($patients as $patient): ?>
                    <option value="<?php echo (int) $patient['id']; ?>"><?php echo htmlspecialchars($patient['full_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Test</label>
            <select name="test_id" required>
                <option value="">Select test</option>
                <?php foreach ($tests as $test): ?>
                    <option value="<?php echo (int) $test['id']; ?>"><?php echo htmlspecialchars($test['name']); ?> - ₹<?php echo number_format((float) $test['price'], 2); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Requested By</label>
            <input type="text" name="requested_by">
        </div>

        <div class="form-actions full-width">
            <button type="submit" class="btn primary">Place Order</button>
        </div>
    </form>
</section>

<section class="panel">
    <div class="panel-header">
        <h3>Orders List</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Test</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($orders): ?>
                <?php foreach ($orders as $order): ?>
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
                    <td colspan="5" class="empty">No orders found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
