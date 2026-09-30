<?php
require_once __DIR__ . '/app.php';
session_start();

function getPdo(): ?PDO
{
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $db   = getenv('DB_NAME') ?: 'pathology_lab';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';

    try {
        $serverPdo = new PDO("mysql:host={$host};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        $serverPdo->exec("CREATE DATABASE IF NOT EXISTS `{$db}`");

        $pdo = new PDO("mysql:host={$host};dbname={$db};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return $pdo;
    } catch (PDOException $e) {
        $_SESSION['global_error'] = 'Database connection failed. Please verify MySQL is running and the credentials are correct.';
        return null;
    }
}

function ensureSchema(): void
{
    $pdo = getPdo();
    if (!$pdo) {
        return;
    }

    $tablesResult = $pdo->query("SHOW TABLES");
    $tables = $tablesResult ? $tablesResult->fetchAll(PDO::FETCH_COLUMN) : [];

    if (!in_array('users', $tables, true)) {
        $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
        if ($schema !== false) {
            $pdo->exec($schema);
        }
    }

    $userCount = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    if ($userCount === 0) {
        $stmt = $pdo->prepare('INSERT INTO users (username, password_hash, role, full_name) VALUES (:username, :password_hash, :role, :full_name)');
        $stmt->execute([
            'username' => DEFAULT_ADMIN_USERNAME,
            'password_hash' => password_hash(DEFAULT_ADMIN_PASSWORD, PASSWORD_DEFAULT),
            'role' => 'admin',
            'full_name' => 'System Administrator',
        ]);
    }

    $testsCount = (int) $pdo->query('SELECT COUNT(*) FROM lab_tests')->fetchColumn();
    if ($testsCount === 0) {
        $seedData = [
            ['CBC', 'Hematology', 450.00, 'WBC: 4-11 x10^3/uL', 'Complete blood count'],
            ['Lipid Profile', 'Biochemistry', 640.00, 'Total Cholesterol: <200 mg/dL', 'Lipid panel'],
            ['Thyroid Profile', 'Endocrinology', 1200.00, 'TSH: 0.5-4.5 uIU/mL', 'Thyroid hormone testing'],
            ['HbA1c', 'Diabetes', 750.00, '4.0-5.6%', 'Glycemic control profile'],
            ['Urine Routine', 'Urine Analysis', 320.00, 'No abnormal findings', 'Routine urine biomarkers'],
        ];

        $insertSql = 'INSERT INTO lab_tests (name, category, price, normal_range, description) VALUES (:name, :category, :price, :normal_range, :description)';
        $stmt = $pdo->prepare($insertSql);

        foreach ($seedData as $record) {
            $stmt->execute([
                'name' => $record[0],
                'category' => $record[1],
                'price' => $record[2],
                'normal_range' => $record[3],
                'description' => $record[4],
            ]);
        }
    }
}

ensureSchema();
