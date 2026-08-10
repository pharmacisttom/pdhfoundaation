<div class="container-fluid py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <img src="<?php echo $_ENV['APP_URL']; ?>/public/assets/images/logo.jpg" alt="Logo" class="mb-4 rounded-circle shadow-sm" style="width: 120px; opacity: 0.5; filter: grayscale(100%);">
            <h2 class="fw-bold text-secondary mb-3">อยู่ระหว่างการพัฒนา</h2>
            <p class="text-muted mb-4">ฟีเจอร์นี้ (<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>) กำลังอยู่ในระหว่างการพัฒนาและจะเปิดให้บริการในเร็วๆ นี้</p>
            <a href="<?php echo $_ENV['APP_URL']; ?>/admin" class="btn btn-primary rounded-pill px-4">
                <i class="fa-solid fa-arrow-left me-2"></i> กลับสู่หน้าหลัก
            </a>
        </div>
    </div>
</div>
