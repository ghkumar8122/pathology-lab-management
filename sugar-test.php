<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$pdo = getPdo();

// Create test_results table if it doesn't exist
$tableCheck = $pdo->query("SHOW TABLES LIKE 'test_results'")->fetch();
if (!$tableCheck) {
    $createTableSQL = "
    CREATE TABLE IF NOT EXISTS test_results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        report_number VARCHAR(50) UNIQUE NOT NULL,
        patient_name VARCHAR(150) NOT NULL,
        test_date DATE NOT NULL,
        mobile_number VARCHAR(20),
        doctor_name VARCHAR(150),
        age INT,
        gender ENUM('Male', 'Female', 'Other'),
        test_type VARCHAR(50),
        fasting_plasma_glucose VARCHAR(50),
        post_prandial_plasma VARCHAR(50),
        random_plasma_glucose VARCHAR(50),
        blood_urea VARCHAR(50),
        serum_creatinine VARCHAR(50),
        urine_sugar VARCHAR(50),
        urine_protein VARCHAR(50),
        urine_ketone VARCHAR(50),
        hemoglobin VARCHAR(50),
        blood_group VARCHAR(10),
        malaria_test VARCHAR(50),
        igg_test VARCHAR(50),
        igm_test VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
    ";
    $pdo->exec($createTableSQL);
}

include __DIR__ . '/includes/header.php';
?>

<section class="panel">
    <div class="panel-header">
        <h3>Sugar Test Report Entry</h3>
    </div>

    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="alert success"><?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="alert danger"><?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>

    <form method="POST" action="process-sugar-test.php" class="grid-form">
        <!-- Report Number (Auto-generated) -->
        <div class="form-group">
            <label>Report Number (Auto-generated) *</label>
            <input type="text" name="report_number" value="<?php echo 'SR-' . date('YmdHis'); ?>" readonly>
        </div>

        <!-- Patient Name -->
        <div class="form-group">
            <label>Patient Name *</label>
            <input type="text" name="patient_name" required>
        </div>

        <!-- Date -->
        <div class="form-group">
            <label>Date *</label>
            <input type="date" name="test_date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <!-- Mobile Number -->
        <div class="form-group">
            <label>Mobile Number</label>
            <input type="text" name="mobile_number" placeholder="10 digit mobile number">
        </div>

        <!-- Doctor Name -->
        <div class="form-group">
            <label>Doctor Name</label>
            <input type="text" name="doctor_name">
        </div>

        <!-- Age -->
        <div class="form-group">
            <label>Age</label>
            <input type="number" name="age" min="0" max="150">
        </div>

        <!-- Gender -->
        <div class="form-group">
            <label>Gender</label>
            <select name="gender">
                <option value="">-- Select --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <!-- Fasting Plasma Glucose -->
        <div class="form-group full-width">
            <h4>Glucose Tests</h4>
        </div>

        <div class="form-group">
            <label>Fasting Plasma Glucose (god-pod Method)</label>
            <input type="text" name="fasting_plasma_glucose" placeholder="mg/dl (70-100)">
        </div>

        <div class="form-group">
            <label>Post Prandial Plasma</label>
            <input type="text" name="post_prandial_plasma" placeholder="mg/dl (100-140)">
        </div>

        <div class="form-group">
            <label>Random Plasma Glucose</label>
            <input type="text" name="random_plasma_glucose" placeholder="mg/dl (<160)">
        </div>

        <!-- Renal Function Tests -->
        <div class="form-group full-width">
            <h4>Renal Function Test (SERUM)</h4>
        </div>

        <div class="form-group">
            <label>Blood Urea (gldh-urease method)</label>
            <input type="text" name="blood_urea" placeholder="mg/dl (13-45)">
        </div>

        <div class="form-group">
            <label>Serum Creatinine (jaffe's Method)</label>
            <input type="text" name="serum_creatinine" placeholder="mg/dl (0.5-1.2)">
        </div>

        <!-- Urine Examination -->
        <div class="form-group full-width">
            <h4>Urine Examination</h4>
        </div>

        <div class="form-group">
            <label>Urine Sugar</label>
            <select name="urine_sugar">
                <option value="">-- Select --</option>
                <option value="NIL">NIL</option>
                <option value="Trace">Trace</option>
                <option value="1+">1+</option>
                <option value="2+">2+</option>
                <option value="3+">3+</option>
            </select>
        </div>

        <div class="form-group">
            <label>Urine Protein</label>
            <select name="urine_protein">
                <option value="">-- Select --</option>
                <option value="NIL">NIL</option>
                <option value="Trace">Trace</option>
                <option value="1+">1+</option>
                <option value="2+">2+</option>
                <option value="3+">3+</option>
            </select>
        </div>

        <div class="form-group">
            <label>Urine Ketone</label>
            <select name="urine_ketone">
                <option value="">-- Select --</option>
                <option value="NIL">NIL</option>
                <option value="Trace">Trace</option>
                <option value="1+">1+</option>
                <option value="2+">2+</option>
                <option value="3+">3+</option>
            </select>
        </div>

        <!-- General Blood Test -->
        <div class="form-group full-width">
            <h4>General Blood Test</h4>
        </div>

        <div class="form-group">
            <label>Hemoglobin</label>
            <input type="text" name="hemoglobin" placeholder="gm/dl (12-14 Male, 10-12 Female)">
        </div>

        <div class="form-group">
            <label>Blood Group</label>
            <select name="blood_group">
                <option value="">-- Select --</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="AB">AB</option>
                <option value="O">O</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>

        <div class="form-group">
            <label>Malaria Test</label>
            <select name="malaria_test">
                <option value="">-- Select --</option>
                <option value="Negative">Negative</option>
                <option value="Positive">Positive</option>
            </select>
        </div>

        <!-- Dengue Test -->
        <div class="form-group full-width">
            <h4>Dengue Test</h4>
        </div>

        <div class="form-group">
            <label>IgG</label>
            <select name="igg_test">
                <option value="">-- Select --</option>
                <option value="Negative">Negative</option>
                <option value="Positive">Positive</option>
            </select>
        </div>

        <div class="form-group">
            <label>IgM</label>
            <select name="igm_test">
                <option value="">-- Select --</option>
                <option value="Negative">Negative</option>
                <option value="Positive">Positive</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="form-actions full-width">
            <button type="submit" class="btn primary">Save Test Report</button>
        </div>
    </form>
</section>

<!-- List of Saved Reports -->
<section class="panel">
    <div class="panel-header">
        <h3>Sugar Test Reports</h3>
    </div>

    <?php
    $stmt = $pdo->prepare("SELECT * FROM test_results WHERE test_type = 'Sugar Test' ORDER BY created_at DESC");
    $stmt->execute();
    $results = $stmt->fetchAll();
    ?>

    <table>
        <thead>
            <tr>
                <th>Report No</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Doctor</th>
                <th>Mobile</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($results): ?>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['report_number']); ?></td>
                        <td><?php echo htmlspecialchars($result['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($result['test_date']))); ?></td>
                        <td><?php echo htmlspecialchars($result['age'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars($result['gender'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars($result['doctor_name'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars($result['mobile_number'] ?: '-'); ?></td>
                        <td>
                            <a href="edit-sugar-test.php?id=<?php echo (int) $result['id']; ?>" class="action-btn edit">Edit</a>
                            <a href="print-sugar-test.php?id=<?php echo (int) $result['id']; ?>" class="action-btn print">Print</a>
                            <a href="delete-sugar-test.php?id=<?php echo (int) $result['id']; ?>" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this report?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="empty">No sugar test reports found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<style>
    .form-group h4 {
        margin: 20px 0 10px;
        color: #2c3e50;
        font-size: 14px;
        border-bottom: 2px solid #2563eb;
        padding-bottom: 8px;
    }

    .form-group.full-width h4 {
        grid-column: 1 / -1;
    }

    .action-btn {
        display: inline-block;
        padding: 6px 12px;
        margin-right: 5px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
    }

    .action-btn.edit {
        background: #3b82f6;
        color: white;
    }

    .action-btn.edit:hover {
        background: #2563eb;
    }

    .action-btn.print {
        background: #10b981;
        color: white;
    }

    .action-btn.print:hover {
        background: #059669;
    }

    .action-btn.delete {
        background: #ef4444;
        color: white;
    }

    .action-btn.delete:hover {
        background: #dc2626;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 12px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background: #f3f4f6;
        font-weight: 600;
    }

    tr:hover {
        background: #f9fafb;
    }

    .empty {
        text-align: center;
        color: #999;
        padding: 30px;
    }
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
