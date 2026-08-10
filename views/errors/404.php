<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 50px; background: #f8f9fa; }
        h1 { font-size: 50px; color: #dc3545; }
        a { color: #198754; text-decoration: none; }
    </style>
</head>
<body>
    <h1>404</h1>
    <h2>ไม่พบหน้าที่ท่านต้องการ (Not Found)</h2>
    <p><a href="<?php echo $_ENV['APP_URL'] ?? '/'; ?>">กลับสู่หน้าหลัก</a></p>
</body>
</html>
