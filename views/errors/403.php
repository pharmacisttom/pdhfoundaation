<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>403 Forbidden</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 50px; background: #f8f9fa; }
        h1 { font-size: 50px; color: #dc3545; }
        a { color: #198754; text-decoration: none; }
    </style>
</head>
<body>
    <h1>403</h1>
    <h2>คุณไม่มีสิทธิ์เข้าถึงหน้านี้ (Forbidden)</h2>
    <p><a href="<?php echo $_ENV['APP_URL'] ?? '/'; ?>/admin/dashboard">กลับสู่แดชบอร์ด</a></p>
</body>
</html>
