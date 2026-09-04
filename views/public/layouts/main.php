<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'] ?? 'มูลนิธิเพื่อโรงพยาบาลปลวกแดง'; ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="ร่วมสร้างโอกาสทางสุขภาพ เพื่อประชาชนอำเภอปลวกแดง ทุกการให้ของคุณ คือพลังในการพัฒนาบริการสุขภาพ โรงพยาบาลปลวกแดง">
    
    <!-- Google Fonts: Prompt & Kanit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $_ENV['APP_URL']; ?>/assets/css/frontend.css">
</head>
<body>

    <!-- Topbar -->
    <div class="bg-primary text-white py-2 d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="small">
                <i class="fa-solid fa-phone me-2"></i> 038-123-4567 | 
                <i class="fa-solid fa-envelope me-2 ms-2"></i> info@pdhfoundation.org
            </div>
            <div class="small">
                <a href="#" class="text-white text-decoration-none me-3"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="text-white text-decoration-none"><i class="fa-brands fa-line"></i></a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo $_ENV['APP_URL']; ?>/">
                <img src="<?php echo $_ENV['APP_URL']; ?>/assets/images/logo.jpg" alt="PDH Foundation Logo" class="me-3 bg-white" style="width: 50px; height: 50px; object-fit: contain; border-radius: 8px;">
                <div>
                    <h5 class="mb-0 fw-bold text-primary" style="font-family: 'Prompt', sans-serif;">มูลนิธิเพื่อโรงพยาบาลปลวกแดง</h5>
                    <small class="text-muted d-block" style="font-size: 0.75rem;">PDH Foundation</small>
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium">
                    <li class="nav-item"><a class="nav-link px-3 active" href="<?php echo $_ENV['APP_URL']; ?>/">หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="<?php echo $_ENV['APP_URL']; ?>/about">เกี่ยวกับมูลนิธิ</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="<?php echo $_ENV['APP_URL']; ?>/projects">โครงการ</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="<?php echo $_ENV['APP_URL']; ?>/news">ข่าวและกิจกรรม</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="<?php echo $_ENV['APP_URL']; ?>/transparency">ความโปร่งใส</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <a href="<?php echo $_ENV['APP_URL']; ?>/admin/login" class="text-secondary text-decoration-none small fw-bold hover-accent">
                        <i class="fa-solid fa-user-lock me-1"></i> สำหรับเจ้าหน้าที่
                    </a>
                    <a href="<?php echo $_ENV['APP_URL']; ?>/donate" class="btn btn-accent rounded-pill px-4 fw-bold shadow-sm">
                        <i class="fa-solid fa-hand-holding-heart me-1"></i> ร่วมบริจาค
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php 
            if (isset($content_view)) {
                require_once ROOT_PATH . '/views/' . $content_view . '.php';
            }
        ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-accent fw-bold mb-4" style="font-family: 'Prompt', sans-serif;">มูลนิธิเพื่อโรงพยาบาลปลวกแดง</h5>
                    <p class="text-light opacity-75 small mb-4">
                        ร่วมสร้างโอกาสทางสุขภาพ เพื่อประชาชนอำเภอปลวกแดง ทุกการให้ของคุณ คือพลังในการพัฒนาบริการสุขภาพ
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width:35px;height:35px;"><i class="fa-brands fa-facebook-f mt-1"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width:35px;height:35px;"><i class="fa-brands fa-line mt-1"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold mb-4">เมนูหลัก</h6>
                    <ul class="list-unstyled small opacity-75">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-accent">หน้าแรก</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-accent">เกี่ยวกับมูลนิธิ</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-accent">โครงการ</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-accent">ข่าวและกิจกรรม</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-4">ลิงก์ด่วน</h6>
                    <ul class="list-unstyled small opacity-75">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-accent">ร่วมบริจาค</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-accent">ตรวจสอบใบเสร็จ</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-accent">ดาวน์โหลดเอกสาร</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none hover-accent">ความโปร่งใสทางการเงิน</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold mb-4">ติดต่อเรา</h6>
                    <ul class="list-unstyled small opacity-75">
                        <li class="mb-3 d-flex"><i class="fa-solid fa-location-dot mt-1 me-2 text-accent"></i> <span>โรงพยาบาลปลวกแดง อ.ปลวกแดง จ.ระยอง 21140</span></li>
                        <li class="mb-3 d-flex"><i class="fa-solid fa-phone mt-1 me-2 text-accent"></i> <span>038-123-4567</span></li>
                        <li class="mb-3 d-flex"><i class="fa-solid fa-envelope mt-1 me-2 text-accent"></i> <span>info@pdhfoundation.org</span></li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary mt-4 mb-3">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start small opacity-50">
                    &copy; <?php echo date('Y'); ?> มูลนิธิเพื่อโรงพยาบาลปลวกแดง. All Rights Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end small opacity-50 mt-2 mt-md-0">
                    <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-white text-decoration-none">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    </script>
</body>
</html>
