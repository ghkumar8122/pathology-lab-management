<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$pdo = getPdo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $gender = $_POST['gender'] ?? 'Male';
    $doctorName = trim($_POST['doctor_name'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($fullName === '') {
        $_SESSION['flash_error'] = 'Patient name is required.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO patients (full_name, phone, email, age, gender, doctor_name, address) VALUES (:full_name, :phone, :email, :age, :gender, :doctor_name, :address)');
        $stmt->execute([
            'full_name' => $fullName,
            'phone' => $phone,
            'email' => $email,
            'age' => $age === '' ? null : (int) $age,
            'gender' => $gender,
            'doctor_name' => $doctorName,
            'address' => $address,
        ]);

        $_SESSION['flash_success'] = 'Patient added successfully.';
        header('Location: patients.php');
        exit;
    }
}

$patients = $pdo->query('SELECT * FROM patients ORDER BY created_at DESC')->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<section class="panel">
    <div class="panel-header">
        <h3>Register New Patient</h3>
    </div>

    <form method="POST" class="grid-form">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email">
        </div>
        <div class="form-group">
            <label>Age</label>
            <input type="number" name="age">
        </div>
        <div class="form-group">
            <label>Gender</label>
            <select name="gender">
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>Doctor Name</label>
            <input type="text" name="doctor_name">
        </div>
        <div class="form-group full-width">
            <label>Address</label>
            <textarea name="address" rows="3"></textarea>
        </div>
        <div class="form-actions full-width">
            <button type="submit" class="btn primary">Save Patient</button>
        </div>
    </form>
</section>

<section class="panel">
    <div class="panel-header">
        <h3>Patients List</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Doctor</th>
                <th>Gender</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($patients): ?>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td>#<?php echo (int) $patient['id']; ?></td>
                        <td><?php echo htmlspecialchars($patient['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($patient['phone'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars($patient['age'] !== null ? (string) $patient['age'] : '-'); ?></td>
                        <td><?php echo htmlspecialchars($patient['doctor_name'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars($patient['gender']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="empty">No patients found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
