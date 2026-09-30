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
        <h3>Enter Test Values for Patient Report</h3>
    </div>

    <form method="POST" action="view-patient-report.php" class="test-entry-form">
        <!-- Patient Selection -->
        <div class="form-section">
            <div class="form-group full-width">
                <label><strong>Select Patient *</strong></label>
                <select name="patient_id" required onchange="updatePatientInfo()">
                    <option value="">-- Choose a patient --</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?php echo (int) $patient['id']; ?>" data-name="<?php echo htmlspecialchars($patient['full_name']); ?>" data-phone="<?php echo htmlspecialchars($patient['phone'] ?: ''); ?>" data-age="<?php echo htmlspecialchars($patient['age'] ?: ''); ?>" data-gender="<?php echo htmlspecialchars($patient['gender']); ?>" data-doctor="<?php echo htmlspecialchars($patient['doctor_name'] ?: ''); ?>">
                            #<?php echo (int) $patient['id']; ?> - <?php echo htmlspecialchars($patient['full_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Patient Auto-Filled Details -->
        <div class="form-section">
            <h4>Patient Information (Auto-filled)</h4>
            <div class="grid-form">
                <div class="form-group">
                    <label>Patient Name</label>
                    <input type="text" id="patientName" readonly>
                </div>
                <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="text" id="patientPhone" readonly>
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <input type="text" id="patientAge" readonly>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <input type="text" id="patientGender" readonly>
                </div>
                <div class="form-group">
                    <label>Doctor Name</label>
                    <input type="text" id="patientDoctor" readonly>
                </div>
            </div>
        </div>

        <!-- Test Values Section -->
        <div class="form-section">
            <h4>LAB TEST REPORT (AUTO-ANALYZER)</h4>

            <!-- Fasting Plasma Glucose -->
            <div class="sub-section">
                <h5>Glucose Tests</h5>
                <div class="grid-form">
                    <div class="form-group">
                        <label>Fasting Plasma Glucose (good-pod Method)</label>
                        <input type="text" name="fasting_plasma_glucose" placeholder="Mg/dl">
                    </div>
                    <div class="form-group">
                        <label>Post Prandial Plasma Glucose</label>
                        <input type="text" name="post_prandial_plasma" placeholder="Mg/dl">
                    </div>
                    <div class="form-group">
                        <label>Random Plasma Glucose</label>
                        <input type="text" name="random_plasma_glucose" placeholder="Mg/dl">
                    </div>
                </div>
            </div>

            <!-- Renal Function Test -->
            <div class="sub-section">
                <h5>RENAL FUNCTION TEST (SERUM)</h5>
                <div class="grid-form">
                    <div class="form-group">
                        <label>Blood Urea (gldh-urease method)</label>
                        <input type="text" name="blood_urea" placeholder="Mg/dl">
                    </div>
                    <div class="form-group">
                        <label>Serum Creatinine (jaffe's Method)</label>
                        <input type="text" name="serum_creatinine" placeholder="Mg/dl">
                    </div>
                </div>
            </div>

            <!-- Urine Examination -->
            <div class="sub-section">
                <h5>URINE EXAMINATION</h5>
                <div class="grid-form">
                    <div class="form-group">
                        <label>Urine Sugar</label>
                        <select name="urine_sugar">
                            <option value="">--</option>
                            <option>NIL</option>
                            <option>Trace</option>
                            <option>1+</option>
                            <option>2+</option>
                            <option>3+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Urine Protein</label>
                        <select name="urine_protein">
                            <option value="">--</option>
                            <option>NIL</option>
                            <option>Trace</option>
                            <option>1+</option>
                            <option>2+</option>
                            <option>3+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Urine Ketone</label>
                        <select name="urine_ketone">
                            <option value="">--</option>
                            <option>NIL</option>
                            <option>Trace</option>
                            <option>1+</option>
                            <option>2+</option>
                            <option>3+</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- General Blood Test -->
            <div class="sub-section">
                <h5>GENERAL BLOOD TEST</h5>
                <div class="grid-form">
                    <div class="form-group">
                        <label>Hemoglobin</label>
                        <input type="text" name="hemoglobin" placeholder="gm/dl">
                    </div>
                    <div class="form-group">
                        <label>Blood Group</label>
                        <select name="blood_group">
                            <option value="">--</option>
                            <option>A</option>
                            <option>B</option>
                            <option>AB</option>
                            <option>O</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Malaria Test</label>
                        <select name="malaria_test">
                            <option value="">--</option>
                            <option>Negative</option>
                            <option>Positive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Widal Test</label>
                        <select name="widal_test">
                            <option value="">--</option>
                            <option>Negative</option>
                            <option>Positive</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Dengue Test -->
            <div class="sub-section">
                <h5>DENGUE TEST</h5>
                <div class="grid-form">
                    <div class="form-group">
                        <label>IgG</label>
                        <select name="dengue_igg">
                            <option value="">--</option>
                            <option>Negative</option>
                            <option>Positive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>IgM</label>
                        <select name="dengue_igm">
                            <option value="">--</option>
                            <option>Negative</option>
                            <option>Positive</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Lipid Profile -->
            <div class="sub-section">
                <h5>LIPID PROFILE</h5>
                <div class="grid-form">
                    <div class="form-group">
                        <label>SERUM CHOLESTEROL (chod-pap method)</label>
                        <input type="text" name="serum_cholesterol" placeholder="mg/dl">
                    </div>
                    <div class="form-group">
                        <label>SERUM TRIGLYCERIDES (gpo-pap method)</label>
                        <input type="text" name="serum_triglycerides" placeholder="mg/dl">
                    </div>
                    <div class="form-group">
                        <label>HDL CHOLESTEROL (pta-method)</label>
                        <input type="text" name="hdl_cholesterol" placeholder="mg/dl">
                    </div>
                    <div class="form-group">
                        <label>LDL CHOLESTEROL (by calculation)</label>
                        <input type="text" name="ldl_cholesterol" placeholder="mg/dl">
                    </div>
                    <div class="form-group">
                        <label>VLDL CHOLESTEROL (by calculation)</label>
                        <input type="text" name="vldl_cholesterol" placeholder="mg/dl">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-actions full-width">
            <button type="submit" class="btn primary">Generate Report</button>
        </div>
    </form>
</section>

<style>
    .test-entry-form {
        display: block;
    }

    .form-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e0e0e0;
    }

    .form-section h4 {
        margin-top: 0;
        color: #2c3e50;
        font-size: 16px;
        border-bottom: 2px solid #2563eb;
        padding-bottom: 10px;
    }

    .sub-section {
        margin-bottom: 20px;
        padding: 15px;
        background: #f9fafb;
        border-radius: 6px;
    }

    .sub-section h5 {
        margin-top: 0;
        color: #555;
        font-size: 13px;
        text-transform: uppercase;
        border-bottom: 1px dashed #ccc;
        padding-bottom: 8px;
    }

    .grid-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }

    @media (max-width: 768px) {
        .grid-form {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    function updatePatientInfo() {
        const select = document.querySelector('select[name="patient_id"]');
        const selectedOption = select.options[select.selectedIndex];
        
        document.getElementById('patientName').value = selectedOption.getAttribute('data-name') || '';
        document.getElementById('patientPhone').value = selectedOption.getAttribute('data-phone') || '';
        document.getElementById('patientAge').value = selectedOption.getAttribute('data-age') || '';
        document.getElementById('patientGender').value = selectedOption.getAttribute('data-gender') || '';
        document.getElementById('patientDoctor').value = selectedOption.getAttribute('data-doctor') || '';
    }
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
