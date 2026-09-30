<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php
    require_once __DIR__ . '/../config/db.php';
    $currentUser = currentUser();
    ?>
    <div class="app-shell">
        <aside class="sidebar">
            <div class="brand">
                <h2>PathLab</h2>
            </div>
            <nav>
                <a href="dashboard.php" class="nav-link">Dashboard</a>
                <a href="patients.php" class="nav-link">Patients</a>
                <a href="tests.php" class="nav-link">Lab Tests</a>
                <a href="orders.php" class="nav-link">Orders</a>
                <a href="reports.php" class="nav-link">Reports</a>
                <a href="billing.php" class="nav-link">Billing</a>
                <a href="logout.php" class="nav-link danger">Logout</a>
            </nav>
        </aside>

        <main class="content">
            <header class="topbar">
                <div>
                    <h1><?php echo APP_NAME; ?></h1>
                </div>
                <div class="user-box">
                    <?php if ($currentUser): ?>
                        <span>Welcome, <?php echo htmlspecialchars($currentUser['full_name']); ?></span>
                    <?php endif; ?>
                </div>
            </header>

            <?php if (isset($_SESSION['flash_success'])): ?>
                <div class="alert success"><?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['flash_error'])): ?>
                <div class="alert danger"><?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['global_error'])): ?>
                <div class="alert danger"><?php echo htmlspecialchars($_SESSION['global_error']); unset($_SESSION['global_error']); ?></div>
            <?php endif; ?>
