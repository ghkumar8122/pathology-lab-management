<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$patientId = filter_input(INPUT_GET, 'patient_id', FILTER_VALIDATE_INT);
if (!$patientId) {
    http_response_code(400);
    exit('A valid patient_id is required.');
}

$pdo = getPdo();

$stmt = $pdo->prepare('SELECT * FROM patients WHERE id = :id');
$stmt->execute(['id' => $patientId]);
$patient = $stmt->fetch();

if (!$patient) {
    http_response_code(404);
    exit('Patient not found.');
}

$stmt = $pdo->prepare('SELECT o.*, lt.name AS test_name, lt.category, lt.price, lt.normal_range FROM test_orders o INNER JOIN lab_tests lt ON lt.id = o.test_id WHERE o.patient_id = :patient_id ORDER BY o.created_at DESC');
$stmt->execute(['patient_id' => $patientId]);
$orders = $stmt->fetchAll();

$reportDate = date('d-m-Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Report - <?php echo htmlspecialchars($patient['full_name']); ?></title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f2f2f2; color: #111; font-family: Arial, sans-serif; }
        .report { max-width: 900px; margin: 24px auto; padding: 34px; background: #fff; min-height: 100vh; }
        .lab-header { text-align: center; border-bottom: 3px solid #6b4630; padding-bottom: 16px; }
        .lab-header h1 { margin: 0; color: #6b4630; font-family: Georgia, serif; font-size: 32px; }
        .lab-header p { margin: 7px 0 0; color: #555; }
        .report-title { margin: 24px 0 16px; text-align: center; text-transform: uppercase; font-family: Georgia, serif; font-size: 24px; }
        .patient-details { display: grid; grid-template-columns: 1fr 1fr; gap: 10px 32px; border: 1px solid #aaa; padding: 16px; margin-bottom: 24px; }
        .detail strong { display: inline-block; width: 130px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #999; padding: 12px; text-align: left; }
        th { background: #eee; }
        .status { font-weight: bold; color: #185c37; }
        .report-text { white-space: pre-wrap; min-height: 70px; }
        .signature { margin-top: 80px; display: flex; justify-content: flex-end; }
        .signature div { width: 220px; text-align: center; border-top: 1px solid #222; padding-top: 8px; }
        .print-actions { max-width: 900px; margin: 18px auto 0; display: flex; gap: 10px; }
        button, .back-link { border: 0; padding: 10px 18px; border-radius: 5px; background: #2563eb; color: white; cursor: pointer; text-decoration: none; font-size: 14px; }
        .back-link { background: #64748b; }
        .empty { text-align: center; color: #666; padding: 25px; }
        @media print {
            body { background: #fff; }
            .report { margin: 0; padding: 0; max-width: none; }
            .print-actions { display: none; }
            @page { size: A4; margin: 16mm; }
        }
        @media (max-width: 650px) {
            .report { margin: 0; padding: 18px; }
            .patient-details { grid-template-columns: 1fr; }
            .print-actions { padding: 0 18px; }
        }
    </style>
</head>
<body>
    <div class="print-actions">
        <button type="button" onclick="window.print()">Print Report</button>
        <a class="back-link" href="print-report.php">Choose Another Patient</a>
    </div>

    <main class="report">
        <header class="lab-header">
            <h1>PATHOLOGY LABORATORY</h1>
            <p>Laboratory Diagnostic Report</p>
        </header>

        <h2 class="report-title">Patient Test Report</h2>

        <section class="patient-details">
            <div class="detail"><strong>Report No:</strong> <?php echo (int) $patient['id']; ?></div>
            <div class="detail"><strong>Date:</strong> <?php echo htmlspecialchars($reportDate); ?></div>
            <div class="detail"><strong>Patient Name:</strong> <?php echo htmlspecialchars($patient['full_name']); ?></div>
            <div class="detail"><strong>Doctor:</strong> <?php echo htmlspecialchars($patient['doctor_name'] ?: '-'); ?></div>
            <div class="detail"><strong>Age:</strong> <?php echo htmlspecialchars($patient['age'] !== null ? (string) $patient['age'] : '-'); ?></div>
            <div class="detail"><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></div>
            <div class="detail"><strong>Mobile:</strong> <?php echo htmlspecialchars($patient['phone'] ?: '-'); ?></div>
        </section>

        <h3>Laboratory Results</h3>
        <?php if ($orders): ?>
            <table>
                <thead>
                    <tr>
                        <th>Test Name</th>
                        <th>Category</th>
                        <th>Result / Report</th>
                        <th>Reference Range</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['test_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['category']); ?></td>
                            <td class="report-text"><?php echo htmlspecialchars($order['report_text'] ?: 'Result pending'); ?></td>
                            <td><?php echo htmlspecialchars($order['normal_range'] ?: '-'); ?></td>
                            <td class="status"><?php echo htmlspecialchars($order['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">No test orders are available for this patient.</div>
        <?php endif; ?>

        <div class="signature"><div>Authorized Signatory</div></div>
    </main>
</body>
</html>
