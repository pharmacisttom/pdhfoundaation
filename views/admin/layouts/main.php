<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['page_title'] ?? 'แดชบอร์ด'; ?> - PDH Foundation Admin</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="<?php echo $_ENV['APP_URL']; ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <?php require_once APP_PATH . '/../views/admin/partials/sidebar.php'; ?>

        <!-- Page Content -->
        <div id="content">
            <!-- Topbar -->
            <?php require_once APP_PATH . '/../views/admin/partials/topbar.php'; ?>

            <!-- Main Content Area -->
            <div class="page-content">
                <?php 
                    if (isset($content_view)) {
                        require_once APP_PATH . '/../views/' . $content_view . '.php'; 
                    }
                ?>
            </div>
            
            <!-- Footer -->
            <footer class="bg-white p-3 text-center text-muted border-top mt-auto">
                <small>&copy; <?php echo date('Y'); ?> มูลนิธิเพื่อโรงพยาบาลปลวกแดง. All rights reserved.</small>
            </footer>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom JS -->
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>
</html>
