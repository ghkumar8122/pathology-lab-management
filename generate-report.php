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
$reportNo = $patientId;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Report - <?php echo htmlspecialchars($patient['full_name']); ?></title>
    <style>
        * { box-sizing: border-box; }
        body { 
            margin: 0; 
            background: #f2f2f2; 
            color: #333; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        .report { 
            max-width: 950px; 
            margin: 20px auto; 
            padding: 40px 50px; 
            background: #fff; 
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .print-actions { 
            max-width: 950px; 
            margin: 18px auto 0; 
            display: flex; 
            gap: 10px;
            padding: 0 20px;
        }
        button, .back-link { 
            border: 0; 
            padding: 12px 24px; 
            border-radius: 5px; 
            background: #2563eb; 
            color: white; 
            cursor: pointer; 
            text-decoration: none; 
            font-size: 14px;
            font-weight: 600;
        }
        .back-link { background: #64748b; }
        button:hover { background: #1d4ed8; }
        .back-link:hover { background: #475569; }

        /* Header Section */
        .header-section {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #999;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 10px;
        }

        .header-label {
            font-weight: bold;
            color: #555;
            width: 100px;
            min-width: fit-content;
        }

        .header-value {
            font-weight: 600;
            color: #111;
            margin-left: 10px;
        }

        /* Report Title */
        .report-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-decoration: underline;
            margin: 28px 0 24px;
            color: #222;
        }

        /* Section Heading */
        .section-heading {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 24px;
            margin-bottom: 14px;
            font-size: 13px;
            color: #222;
        }

        /* Test Row */
        .test-row {
            display: grid;
            grid-template-columns: 2fr 1fr 2fr;
            gap: 30px;
            margin-bottom: 12px;
            align-items: baseline;
        }

        .test-label {
            color: #555;
        }

        .test-value {
            font-weight: 600;
            color: #111;
        }

        .test-range {
            color: #666;
            font-size: 13px;
        }

        /* Two Column Layout */
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .column {
            display: flex;
            flex-direction: column;
        }

        /* Footer */
        .footer-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .signature-box {
            text-align: center;
            min-width: 200px;
        }

        .signature-line {
            border-top: 2px solid #111;
            margin-top: 50px;
            padding-top: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .empty {
            text-align: center;
            color: #999;
            padding: 30px;
            font-style: italic;
        }

        /* Print Styles */
        @media print {
            body { background: #fff; }
            .report { 
                margin: 0; 
                padding: 25mm;
                max-width: none;
                box-shadow: none;
            }
            .print-actions { display: none; }
            @page { 
                size: A4; 
                margin: 15mm; 
            }
        }

        @media (max-width: 768px) {
            .report { 
                margin: 10px; 
                padding: 20px; 
            }
            .header-section {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .test-row {
                grid-template-columns: 1fr;
                gap: 5px;
            }
            .two-column {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="print-actions">
        <button type="button" onclick="window.print()">🖨️ Print Report</button>
        <a class="back-link" href="print-report.php">← Back</a>
    </div>

    <main class="report">
        <!-- Header Section with Patient Details -->
        <div class="header-section">
            <div>
                <div class="header-row">
                    <span class="header-label">Report No :</span>
                    <span class="header-value"><?php echo htmlspecialchars($reportNo); ?></span>
                </div>
            </div>
            <div>
                <div class="header-row">
                    <span class="header-label">Date :</span>
                    <span class="header-value"><?php echo htmlspecialchars($reportDate); ?></span>
                </div>
            </div>
            <div></div>

            <div>
                <div class="header-row">
                    <span class="header-label">Name :</span>
                    <span class="header-value"><?php echo htmlspecialchars($patient['full_name']); ?></span>
                </div>
            </div>
            <div>
                <div class="header-row">
                    <span class="header-label">Doctor :</span>
                    <span class="header-value"><?php echo htmlspecialchars($patient['doctor_name'] ?: '-'); ?></span>
                </div>
            </div>
            <div></div>

            <div>
                <div class="header-row">
                    <span class="header-label">M.No :</span>
                    <span class="header-value"><?php echo htmlspecialchars($patient['phone'] ?: '-'); ?></span>
                </div>
            </div>
            <div>
                <div class="header-row">
                    <span class="header-label">Sex :</span>
                    <span class="header-value"><?php echo htmlspecialchars($patient['gender']); ?></span>
                </div>
            </div>
            <div></div>

            <div>
                <div class="header-row">
                    <span class="header-label">Age :</span>
                    <span class="header-value"><?php echo htmlspecialchars($patient['age'] ?: '-'); ?></span>
                </div>
            </div>
            <div></div>
            <div></div>
        </div>

        <!-- Report Title -->
        <div class="report-title">LAB TEST REPORT (AUTO-ANALYZER)</div>

        <!-- Test Results -->
        <?php if ($orders): ?>
            <?php foreach ($orders as $order): ?>
                <div class="section-heading"><?php echo htmlspecialchars($order['category']); ?></div>
                
                <?php if ($order['category'] === 'Diabetes'): ?>
                    <!-- Diabetes/Sugar Tests -->
                    <div class="test-row">
                        <div>
                            <span class="test-label">Fasting Plasma Glucose (good-pod Method) :</span>
                        </div>
                        <div class="test-value">-</div>
                        <div class="test-range">Mg/dl (70 mg/dl - 100 mg/dl)</div>
                    </div>
                    <div class="test-row">
                        <div>
                            <span class="test-label">Post Prandial Plasma Glucose</span>
                        </div>
                        <div class="test-value">-</div>
                        <div class="test-range">Mg/dl (100 mg/dl - 140 mg/dl)</div>
                    </div>
                    <div class="test-row">
                        <div>
                            <span class="test-label">Random Plasma Glucose</span>
                        </div>
                        <div class="test-value">-</div>
                        <div class="test-range">Mg/dl (<160 mg/dl)</div>
                    </div>

                    <!-- Renal Function Test -->
                    <div class="section-heading">RENAL FUNCTION TEST (SERUM)</div>
                    <div class="test-row">
                        <div>
                            <span class="test-label">Blood Urea (gldh-urease method) :</span>
                        </div>
                        <div class="test-value">-</div>
                        <div class="test-range">Mg/dl (13mg/dl - 45 mg/dl)</div>
                    </div>
                    <div class="test-row">
                        <div>
                            <span class="test-label">Serum Creatinine (jaffe's Method) :</span>
                        </div>
                        <div class="test-value">-</div>
                        <div class="test-range">Mg/dl (0.5 mg/dl - 1.2 mg/dl)</div>
                    </div>

                    <!-- Urine Examination -->
                    <div class="section-heading">URINE EXAMINATION</div>
                    <div class="test-row">
                        <div><span class="test-label">Urine Sugar :</span></div>
                        <div class="test-value">NIL</div>
                        <div></div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Urine Protein :</span></div>
                        <div class="test-value">NIL</div>
                        <div></div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Urine Ketone :</span></div>
                        <div class="test-value">NIL</div>
                        <div></div>
                    </div>

                    <!-- General Blood Test -->
                    <div class="section-heading">GENERAL BLOOD TEST</div>
                    <div class="test-row">
                        <div><span class="test-label">Hemoglobin :</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">gm/dl &nbsp; Male (12-14 gm/dl) &nbsp; Female (10-12 gm/dl)</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Blood Group :</span></div>
                        <div class="test-value">A</div>
                        <div></div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Malaria Test :</span></div>
                        <div class="test-value">Negative</div>
                        <div></div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Widal Test :</span></div>
                        <div class="test-value">-</div>
                        <div></div>
                    </div>

                    <!-- Dengue Test -->
                    <div class="section-heading">DENGUE TEST</div>
                    <div class="test-row">
                        <div><span class="test-label">IgG :</span></div>
                        <div class="test-value">Negative</div>
                        <div></div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">IgM :</span></div>
                        <div class="test-value">Negative</div>
                        <div></div>
                    </div>

                <?php elseif ($order['category'] === 'Biochemistry'): ?>
                    <!-- Lipid Profile -->
                    <div class="test-row">
                        <div><span class="test-label">SERUM CHOLESTEROL (chod-pap method):</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">mg/dl (120 mg/dl - 200 mg/dl)</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">SERUM TRIGLYCERIDES (gpo-pap method):</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">mg/dl (50 mg/dl - 150 mg/dl)</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">HDL CHOLESTEROL (pta-method):</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">mg/dl (>45 mg/dl)</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">LDL CHOLESTEROL (by calculation)</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">mg/dl (<100 mg/dl)</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">VLDL CHOLESTEROL (by calculation)</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">mg/dl (<40 mg/dl)</div>
                    </div>

                <?php elseif ($order['category'] === 'Hematology'): ?>
                    <!-- CBC Test -->
                    <div class="section-heading">COMPLETE BLOOD COUNT</div>
                    <div class="test-row">
                        <div><span class="test-label">WBC Count:</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">x10^3/uL (4-11)</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">RBC Count:</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">x10^6/uL</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Hemoglobin:</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">gm/dl</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Platelets:</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">x10^3/uL (150-450)</div>
                    </div>

                <?php elseif ($order['category'] === 'Urine Analysis'): ?>
                    <!-- Urinalysis -->
                    <div class="section-heading">URINE ROUTINE</div>
                    <div class="test-row">
                        <div><span class="test-label">Color:</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">Pale yellow</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Clarity:</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">Clear</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">pH:</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">4.5-8.0</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Specific Gravity:</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range">1.005-1.030</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Glucose:</span></div>
                        <div class="test-value">NIL</div>
                        <div class="test-range">Negative</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Protein:</span></div>
                        <div class="test-value">NIL</div>
                        <div class="test-range">Negative</div>
                    </div>
                    <div class="test-row">
                        <div><span class="test-label">Ketones:</span></div>
                        <div class="test-value">NIL</div>
                        <div class="test-range">Negative</div>
                    </div>

                <?php else: ?>
                    <div class="test-row">
                        <div><span class="test-label"><?php echo htmlspecialchars($order['test_name']); ?>:</span></div>
                        <div class="test-value">-</div>
                        <div class="test-range"><?php echo htmlspecialchars($order['normal_range'] ?: ''); ?></div>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty">No test orders are available for this patient.</div>
        <?php endif; ?>

        <!-- Footer Section -->
        <div class="footer-section">
            <div></div>
            <div class="signature-box">
                <div class="signature-line">Lab Technician</div>
            </div>
        </div>
    </main>
</body>
</html>
