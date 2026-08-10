<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - ระบบบริหารจัดการมูลนิธิเพื่อโรงพยาบาลปลวกแดง</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo $_ENV['APP_URL']; ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body class="login-page">

    <div class="login-card card">
        <div class="login-logo">
            <!-- Placeholder for Logo -->
            <img src="https://via.placeholder.com/80x80.png?text=Logo" alt="Foundation Logo" class="rounded-circle">
            <h4>มูลนิธิเพื่อโรงพยาบาลปลวกแดง</h4>
            <p class="text-muted">ระบบบริหารจัดการ (Admin System)</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/login" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
            
            <div class="mb-3">
                <label for="username" class="form-label">ชื่อผู้ใช้ (Username)</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">รหัสผ่าน (Password)</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">เข้าสู่ระบบ</button>
            </div>
            
            <div class="mt-4 text-center">
                <a href="#" class="text-decoration-none text-muted"><small>ลืมรหัสผ่าน?</small></a>
            </div>
        </form>
    </div>

</body>
</html>
