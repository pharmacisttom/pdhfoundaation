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
    
    <!-- Premium UI Plugins (Phase 8) -->
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo $_ENV['APP_URL']; ?>/public/assets/css/admin.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div id="wrapper" class="d-flex">
        <!-- Sidebar -->
        <?php require_once APP_PATH . '/../views/admin/partials/sidebar.php'; ?>

        <!-- Page Content -->
        <div id="content" class="flex-grow-1 d-flex flex-column" style="min-height: 100vh; overflow-x: hidden;">
            <!-- Topbar -->
            <?php require_once APP_PATH . '/../views/admin/partials/topbar.php'; ?>

            <!-- Breadcrumb (Auto-generated based on URI) -->
            <div class="bg-white px-4 py-2 border-bottom shadow-sm">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="<?php echo $_ENV['APP_URL']; ?>/admin" class="text-decoration-none text-success"><i class="fa-solid fa-house"></i> หน้าหลัก</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $data['page_title'] ?? 'แดชบอร์ด'; ?></li>
                    </ol>
                </nav>
            </div>

            <!-- Main Content Area -->
            <div class="page-content p-4 flex-grow-1">
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

    <!-- Core JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Premium UI Plugins JS -->
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/th.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- AutoNumeric -->
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.8.1/dist/autoNumeric.min.js"></script>

    <!-- Global Initialization Script -->
    <script>
        $(document).ready(function() {
            // Initialize DataTables globally
            if ($('.datatable').length > 0) {
                $('.datatable').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json',
                    },
                    dom: "<'row mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>" +
                         "<'row'<'col-md-12'tr>>" +
                         "<'row mt-3'<'col-md-5'i><'col-md-7'p>>",
                    buttons: [
                        { extend: 'excel', className: 'btn btn-sm btn-success', text: '<i class="fa-solid fa-file-excel"></i> Excel' },
                        { extend: 'print', className: 'btn btn-sm btn-info', text: '<i class="fa-solid fa-print"></i> Print' },
                        { extend: 'colvis', className: 'btn btn-sm btn-secondary', text: '<i class="fa-solid fa-eye"></i> คอลัมน์' }
                    ]
                });
            }

            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5'
            });

            // Initialize Flatpickr
            $('.datepicker').flatpickr({
                locale: "th",
                dateFormat: "Y-m-d"
            });

            // Initialize AutoNumeric for currency inputs
            AutoNumeric.multiple('.currency-input', {
                digitGroupSeparator: ',',
                decimalCharacter: '.',
                decimalPlaces: 2,
                unformatOnSubmit: true
            });

            // Confirm Delete Interceptor
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'ยืนยันการลบ?',
                    text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert-dismissible').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
