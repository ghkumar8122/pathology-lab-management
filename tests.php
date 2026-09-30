<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$pdo = getPdo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = trim($_POST['price'] ?? '0');
    $normalRange = trim($_POST['normal_range'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name === '' || $category === '') {
        $_SESSION['flash_error'] = 'Test name and category are required.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO lab_tests (name, category, price, normal_range, description) VALUES (:name, :category, :price, :normal_range, :description)');
        $stmt->execute([
            'name' => $name,
            'category' => $category,
            'price' => (float) $price,
            'normal_range' => $normalRange,
            'description' => $description,
        ]);

        $_SESSION['flash_success'] = 'Lab test added successfully.';
        header('Location: tests.php');
        exit;
    }
}

$tests = $pdo->query('SELECT * FROM lab_tests ORDER BY created_at DESC')->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<section class="panel">
    <div class="panel-header">
        <h3>Add New Test</h3>
    </div>

    <form method="POST" class="grid-form">
        <div class="form-group">
            <label>Test Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category" required>
        </div>
        <div class="form-group">
            <label>Price (₹)</label>
            <input type="number" step="0.01" name="price" value="0">
        </div>
        <div class="form-group">
            <label>Normal Range</label>
            <input type="text" name="normal_range">
        </div>
        <div class="form-group full-width">
            <label>Description</label>
            <textarea name="description" rows="3"></textarea>
        </div>
        <div class="form-actions full-width">
            <button type="submit" class="btn primary">Save Test</button>
        </div>
    </form>
</section>

<section class="panel">
    <div class="panel-header">
        <h3>Test Catalog</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Normal Range</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($tests): ?>
                <?php foreach ($tests as $test): ?>
                    <tr>
                        <td>#<?php echo (int) $test['id']; ?></td>
                        <td><?php echo htmlspecialchars($test['name']); ?></td>
                        <td><?php echo htmlspecialchars($test['category']); ?></td>
                        <td>₹<?php echo number_format((float) $test['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($test['normal_range'] ?: '-'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty">No tests found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
