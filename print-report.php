<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$pdo = getPdo();
$patients = $pdo->query('SELECT * FROM patients ORDER BY full_name ASC')->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<section class="panel">
    <div class="panel-header">
        <h3>Select Patient for Report</h3>
    </div>

    <div class="patient-selection-form">
        <form method="GET" action="generate-report.php" class="grid-form">
            <div class="form-group full-width">
                <label>Select Patient</label>
                <select name="patient_id" required>
                    <option value="">-- Choose a patient --</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?php echo (int) $patient['id']; ?>">
                            #<?php echo (int) $patient['id']; ?> - <?php echo htmlspecialchars($patient['full_name']); ?>
                            <?php if ($patient['phone']): ?>(<?php echo htmlspecialchars($patient['phone']); ?>)<?php endif; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-actions full-width">
                <button type="submit" class="btn primary">View Report</button>
            </div>
        </form>
    </div>
</section>

<section class="panel">
    <div class="panel-header">
        <h3>Patient Reports</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>Patient ID</th>
                <th>Patient Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Doctor</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($patients): ?>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td>#<?php echo (int) $patient['id']; ?></td>
                        <td><?php echo htmlspecialchars($patient['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($patient['age'] !== null ? (string) $patient['age'] : '-'); ?></td>
                        <td><?php echo htmlspecialchars($patient['gender']); ?></td>
                        <td><?php echo htmlspecialchars($patient['doctor_name'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars($patient['phone'] ?: '-'); ?></td>
                        <td>
                            <a href="generate-report.php?patient_id=<?php echo (int) $patient['id']; ?>" class="btn-link">View Report</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="empty">No patients found. Please add patients first.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
