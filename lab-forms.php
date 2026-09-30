<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

include __DIR__ . '/includes/header.php';
?>

<div class="lab-form-wrapper">
    <section class="lab-panel hba1c-panel">
        <div class="form-title">HbA1C Entry Screen</div>

        <div class="meta-row">
            <div class="field-block narrow">
                <label>Report Number :</label>
                <input type="text" value="13" />
            </div>
            <div class="field-block wide">
                <label>Patient Name</label>
                <input type="text" />
            </div>
            <div class="field-block">
                <label>Date</label>
                <input type="text" value="30-09-2026" />
            </div>
        </div>

        <div class="meta-row second-row">
            <div class="field-block narrow">
                <label>Mobile Number</label>
                <input type="text" />
            </div>
            <div class="field-block wide">
                <label>Age</label>
                <input type="text" />
            </div>
            <div class="field-block">
                <label>Doctor</label>
                <input type="text" value="Dr. N. Mallikarjuna Reddy" />
            </div>
            <div class="field-block">
                <label>Gender</label>
                <select>
                    <option selected>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>
        </div>

        <div class="section-headline">Glycosylated Hemoglobin</div>
        <div class="mini-head">(Hb A1C%)</div>
        <div class="mini-head secondary">(ION EXCHANGE RESIN METHOD)</div>

        <div class="result-line">
            <div class="label-inline">RESULT :</div>
            <input type="text" value="0" class="small-box" />
            <span>%</span>
            <div class="label-inline inline-gap">2-3 MONTHS AVERAGE BLOOD SUGAR</div>
            <input type="text" value="0" class="small-box" />
            <span>mg/dl</span>
        </div>

        <div class="interpretation-heading">INTERPRETATION RESULTS :</div>

        <div class="interpretation-grid">
            <div class="interpret-row">
                <div class="label-inline">BELOW 5.6%</div>
                <input type="text" value="0" class="small-box" />
                <div class="result-label">NORMAL</div>
            </div>
            <div class="interpret-row">
                <div class="label-inline">5.6 - 7.0 %</div>
                <input type="text" value="0" class="small-box" />
                <div class="result-label">GOOD CONTROL</div>
            </div>
            <div class="interpret-row">
                <div class="label-inline">7.0 - 8.0 %</div>
                <input type="text" value="0" class="small-box" />
                <div class="result-label">FAIR CONTROL</div>
            </div>
            <div class="interpret-row">
                <div class="label-inline">8.0 - 10.0 %</div>
                <input type="text" value="0" class="small-box" />
                <div class="result-label">UNSATISFACTORY CONTROL</div>
            </div>
            <div class="interpret-row">
                <div class="label-inline">ABOVE 10.0%</div>
                <input type="text" value="0" class="small-box" />
                <div class="result-label">POOR CONTROL</div>
            </div>
        </div>
    </section>

    <section class="lab-panel lipid-panel">
        <div class="form-title">Lipid Profile Entry Screen</div>

        <div class="meta-row">
            <div class="field-block narrow">
                <label>Report No :</label>
                <input type="text" value="13" />
            </div>
            <div class="field-block wide">
                <label>Patient Name:</label>
                <input type="text" />
            </div>
            <div class="field-block">
                <label>Date</label>
                <input type="text" value="30-09-2026" />
            </div>
        </div>

        <div class="meta-row second-row">
            <div class="field-block narrow">
                <label>Mobile Number:</label>
                <input type="text" />
            </div>
            <div class="field-block wide">
                <label>Age :</label>
                <input type="text" />
            </div>
            <div class="field-block">
                <label>Doctor</label>
                <input type="text" value="Dr. N. Mallikarjuna Reddy" />
            </div>
            <div class="field-block">
                <label>Gender</label>
                <select>
                    <option selected>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>
        </div>

        <div class="section-headline large-area">LAB TEST REPORT (AUTO - ANALYZER)</div>

        <div class="lab-result-grid">
            <div class="result-item">
                <label>FASTING PLASMA GLUCOSE (god-pod Method) :</label>
                <input type="text" value="0" class="small-box" />
                <span>mg/dl (70 mg/dl - 100 mg/dl)</span>
            </div>
            <div class="result-item right-side">
                <label>POST PRANDIAL GLUCOSE :</label>
                <input type="text" value="0" class="small-box" />
                <span>mg/dl (100 mg/dl - 140 mg/dl)</span>
            </div>
            <div class="result-item right-side second-row-item">
                <label>RANDOM PLASMA GLUCOSE :</label>
                <input type="text" value="0" class="small-box" />
                <span>mg/dl (&lt; 160 mg/dl)</span>
            </div>
        </div>

        <div class="section-headline medium-area">RENAL FUNCTION TEST (SERUM)</div>

        <div class="lab-result-grid small-grid">
            <div class="result-item">
                <label>BLOOD UREA (gidh-urease method) :</label>
                <input type="text" value="0" class="small-box" />
                <span>mg/dl (13 mg/dl - 45 mg/dl)</span>
            </div>
            <div class="result-item right-side">
                <label>SERUM CREATININE (Jaffe's Method) :</label>
                <input type="text" value="0" class="small-box" />
                <span>mg/dl (0.5 mg/dl - 1.2 mg/dl)</span>
            </div>
        </div>

        <div class="section-headline medium-area">LIPID PROFILE</div>

        <div class="lipid-layout">
            <div class="lipid-form-left">
                <div class="result-item stacked-item">
                    <label>SERUM CHOLESTEROL (chod-pap method):</label>
                    <div class="inline-inputs">
                        <input type="text" value="0" class="small-box" />
                        <span>mg/dl (120 mg/dl - 200 mg/dl)</span>
                    </div>
                </div>
                <div class="result-item stacked-item">
                    <label>SERUM TRIGLYCERIDES (gpo-pap method):</label>
                    <div class="inline-inputs">
                        <input type="text" value="0" class="small-box" />
                        <span>mg/dl (50 mg/dl - 150 mg/dl)</span>
                    </div>
                </div>
                <div class="result-item stacked-item">
                    <label>HDL CHOLESTEROL (pta-method):</label>
                    <div class="inline-inputs">
                        <input type="text" value="0" class="small-box" />
                        <span>mg/dl (&lt; 45 mg/dl)</span>
                    </div>
                </div>
                <div class="result-item stacked-item">
                    <label>LDL CHOLESTEROL (by calculation)</label>
                    <div class="inline-inputs">
                        <input type="text" value="0" class="small-box" />
                        <span>mg/dl (&lt;100 mg/dl)</span>
                    </div>
                </div>
                <div class="result-item stacked-item">
                    <label>VLDL CHOLESTEROL (by calculation)</label>
                    <div class="inline-inputs">
                        <input type="text" value="0" class="small-box" />
                        <span>mg/dl (&lt;40 mg/dl)</span>
                    </div>
                </div>
            </div>

            <div class="urine-graph-box">
                <div class="graph-label">GLUCOSE</div>
                <div class="arrow-line left-arrow"></div>
                <div class="graph-label urine-label">URINE</div>
                <div class="arrow-line right-arrow"></div>
                <div class="graph-label protein-label">PROTEIN</div>
            </div>
        </div>
    </section>

    <section class="lab-panel sugar-panel">
        <div class="form-title">Sugar Tests Entry Screen</div>

        <div class="meta-row">
            <div class="field-block narrow">
                <label>Report No :</label>
                <input type="text" value="15" />
            </div>
            <div class="field-block wide">
                <label>Patient Name</label>
                <input type="text" />
            </div>
            <div class="field-block">
                <label>Date</label>
                <input type="text" value="30-09-2026" />
            </div>
        </div>

        <div class="meta-row second-row">
            <div class="field-block narrow">
                <label>Mobile Number</label>
                <input type="text" />
            </div>
            <div class="field-block wide">
                <label>Age</label>
                <input type="text" />
            </div>
            <div class="field-block">
                <label>Doctor</label>
                <input type="text" value="Dr. N. Mallikarjuna Reddy" />
            </div>
            <div class="field-block">
                <label>Gender</label>
                <select>
                    <option selected>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>
        </div>

        <div class="section-headline large-area">LAB TEST REPORT (AUTO - ANALYZER)</div>

        <div class="lab-result-grid two-column-grid">
            <div class="result-item">
                <label>Fasting Plasma Glucose (god-pod Method) :</label>
                <input type="text" value="0" class="small-box" />
                <span>mg/dl (70 mg/dl - 100 mg/dl)</span>
            </div>
            <div class="result-item right-side">
                <label>Post Prandial Plasma :</label>
                <input type="text" value="0" class="small-box" />
                <span>mg/dl (100 mg/dl - 140 mg/dl)</span>
            </div>
            <div class="result-item">
                <label>Random Plasma Glucose :</label>
                <input type="text" value="0" class="small-box" />
                <span>mg/dl (&lt; 160 mg/dl)</span>
            </div>
        </div>

        <div class="section-headline medium-area">RENAL FUNCTION TEST (SERUM)</div>

        <div class="lab-result-grid two-column-grid small-grid">
            <div class="result-item">
                <label>Blood Urea (gidh-urease method) :</label>
                <input type="text" value="0" class="small-box" />
                <span>mg/dl (13 mg/dl - 45 mg/dl)</span>
            </div>
            <div class="result-item right-side">
                <label>Serum Creatinine (Jaffe's Method) :</label>
                <input type="text" value="0" class="small-box" />
                <span>mg/dl (0.5 mg/dl - 1.2 mg/dl)</span>
            </div>
        </div>

        <div class="section-headline medium-area">URINE EXAMINATION</div>

        <div class="three-value-row">
            <div class="value-box">
                <label>Urine Sugar:</label>
                <input type="text" />
            </div>
            <div class="value-box">
                <label>Urine Protein:</label>
                <input type="text" />
            </div>
            <div class="value-box">
                <label>Urine Ketone:</label>
                <input type="text" />
            </div>
        </div>

        <div class="section-headline medium-area">GENERAL BLOOD TEST</div>

        <div class="general-blood-row">
            <div class="value-box small-box-wrap">
                <label>Hemoglobin</label>
                <input type="text" value="0" class="small-box" />
                <span>gm/dl</span>
                <small>Male (12-14 gm/dl)</small>
                <small>Female (10-12 gm/dl)</small>
            </div>
            <div class="value-box select-box">
                <label>Blood Group</label>
                <input type="text" />
            </div>
            <div class="value-box select-box">
                <label>Malaria Test</label>
                <select>
                    <option>--</option>
                    <option>Positive</option>
                    <option>Negative</option>
                </select>
            </div>
            <div class="value-box select-box">
                <label>Widal Test</label>
                <select>
                    <option>--</option>
                    <option>Positive</option>
                    <option>Negative</option>
                </select>
            </div>
        </div>

        <div class="section-headline medium-area">DENGUE TEST</div>
        <div class="dengue-row">
            <div class="value-box select-box">
                <label>IgG</label>
                <select>
                    <option>--</option>
                    <option>Positive</option>
                    <option>Negative</option>
                </select>
            </div>
            <div class="value-box select-box">
                <label>IgM</label>
                <select>
                    <option>--</option>
                    <option>Positive</option>
                    <option>Negative</option>
                </select>
            </div>
        </div>
    </section>

    <section class="lab-panel urinalysis-panel">
        <div class="form-title">Urinalysis Entry Form</div>

        <div class="meta-row">
            <div class="field-block narrow">
                <label>Report Number</label>
                <input type="text" value="13" />
            </div>
            <div class="field-block wide">
                <label>Patient Name</label>
                <input type="text" />
            </div>
            <div class="field-block">
                <label>Date</label>
                <input type="text" value="30-09-2026" />
            </div>
        </div>

        <div class="meta-row second-row">
            <div class="field-block narrow">
                <label>Mobile Number</label>
                <input type="text" />
            </div>
            <div class="field-block wide">
                <label>Age</label>
                <input type="text" />
            </div>
            <div class="field-block">
                <label>Doctor</label>
                <input type="text" value="Dr. N. Mallikarjuna Reddy" />
            </div>
            <div class="field-block">
                <label>Gender</label>
                <select>
                    <option selected>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>
        </div>

        <div class="urinalysis-table">
            <div class="urine-header-row">
                <div>COMPONENT</div>
                <div>RESULT</div>
                <div>REFERENCE RANGE</div>
                <div>COMPONENT</div>
                <div>RESULT</div>
                <div>REFERENCE RANGE</div>
            </div>

            <div class="urine-body-row">
                <div class="component">COLOR</div>
                <div class="result-box"><input type="text" /></div>
                <div class="ref-range">-----</div>
                <div class="component">BILIRUBIN</div>
                <div class="result-box"><select><option>--</option></select></div>
                <div class="ref-range">Negative</div>
            </div>

            <div class="urine-body-row">
                <div class="component">CLARITY</div>
                <div class="result-box"><input type="text" /></div>
                <div class="ref-range">-----</div>
                <div class="component">LEUKOCYTE ESTERASE</div>
                <div class="result-box"><select><option>--</option></select></div>
                <div class="ref-range">Negative</div>
            </div>

            <div class="urine-body-row">
                <div class="component">pH</div>
                <div class="result-box"><input type="text" value="0" /></div>
                <div class="ref-range">-----</div>
                <div class="component">NITRITE</div>
                <div class="result-box"><select><option>--</option></select></div>
                <div class="ref-range">Negative</div>
            </div>

            <div class="urine-body-row">
                <div class="component">SPECIFIC GRAVITY</div>
                <div class="result-box"><input type="text" value="0" /></div>
                <div class="ref-range">-----</div>
                <div class="component urine-micro">URINE MICROSCOPY</div>
                <div class="result-box"></div>
                <div class="ref-range"></div>
            </div>

            <div class="urine-body-row">
                <div class="component">GLUCOSE</div>
                <div class="result-box"><select><option>--</option></select></div>
                <div class="ref-range">Negative</div>
                <div class="component">WHITE BLOOD CELLS</div>
                <div class="result-box"><input type="text" value="0" /></div>
                <div class="ref-range">per high-power field</div>
            </div>

            <div class="urine-body-row">
                <div class="component">BLOOD</div>
                <div class="result-box"><select><option>--</option></select></div>
                <div class="ref-range">Negative</div>
                <div class="component">RED BLOOD CELLS</div>
                <div class="result-box"><input type="text" value="0" /></div>
                <div class="ref-range">per high-power field</div>
            </div>

            <div class="urine-body-row">
                <div class="component">KETONES</div>
                <div class="result-box"><select><option>--</option></select></div>
                <div class="ref-range">Negative</div>
                <div class="component">SQUAMOUS EPITHELIAL CELLS</div>
                <div class="result-box"><input type="text" /></div>
                <div class="ref-range">None</div>
            </div>

            <div class="urine-body-row">
                <div class="component">PROTEIN</div>
                <div class="result-box"><select><option>--</option></select></div>
                <div class="ref-range">Negative</div>
                <div class="component">BACTERIA</div>
                <div class="result-box"><input type="text" /></div>
                <div class="ref-range">-----</div>
            </div>

            <div class="urine-body-row">
                <div class="component">UROBILINOGEN</div>
                <div class="result-box"><select><option>--</option></select></div>
                <div class="ref-range">Negative</div>
                <div class="component"></div>
                <div class="result-box"></div>
                <div class="ref-range"></div>
            </div>
        </div>
    </section>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
