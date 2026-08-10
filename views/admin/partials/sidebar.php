<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar" style="width: 280px; min-height: 100vh; position: sticky; top: 0;">
    <a href="<?php echo $_ENV['APP_URL']; ?>/admin" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none border-bottom border-secondary pb-3 w-100">
        <img src="<?php echo $_ENV['APP_URL']; ?>/public/assets/images/logo.jpg" alt="Logo" class="me-2 bg-white" style="width: 40px; height: 40px; object-fit: contain; border-radius: 8px;">
        <span class="fs-5 fw-bold">PDH Foundation</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto" style="overflow-y: auto; max-height: calc(100vh - 150px);">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="<?php echo $_ENV['APP_URL']; ?>/admin" class="nav-link text-white <?php echo $_SERVER['REQUEST_URI'] == '/pdhfoundation/public/admin' ? 'active bg-success' : ''; ?>">
                <i class="fa-solid fa-gauge-high fa-fw"></i> ภาพรวม (Dashboard)
            </a>
        </li>
        
        <li class="nav-header small text-muted text-uppercase mt-3 mb-1 fw-bold">Management</li>
        
        <!-- Foundation Info -->
        <li>
            <a href="#foundationSubmenu" data-bs-toggle="collapse" class="nav-link text-white d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-building-flag fa-fw"></i> ข้อมูลมูลนิธิ</span>
                <i class="fa-solid fa-chevron-down fa-xs"></i>
            </a>
            <ul class="collapse list-unstyled ps-4" id="foundationSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/profile" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ข้อมูลทั่วไป</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/history" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ประวัติ/เจตนารมณ์</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/patrons" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> องค์อุปถัมภ์/ผู้ก่อตั้ง</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/board" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> คณะกรรมการ</a></li>
            </ul>
        </li>

        <!-- Donation System -->
        <li>
            <a href="#donationSubmenu" data-bs-toggle="collapse" class="nav-link text-white d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-hand-holding-dollar fa-fw"></i> ระบบรับบริจาค</span>
                <i class="fa-solid fa-chevron-down fa-xs"></i>
            </a>
            <ul class="collapse list-unstyled ps-4" id="donationSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/donors" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ฐานข้อมูลผู้บริจาค</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/donations" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> รายการรับบริจาค</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/receipts" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ใบเสร็จรับเงิน</a></li>
            </ul>
        </li>

        <!-- Finance System -->
        <li>
            <a href="#financeSubmenu" data-bs-toggle="collapse" class="nav-link text-white d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-coins fa-fw"></i> ระบบการเงิน</span>
                <i class="fa-solid fa-chevron-down fa-xs"></i>
            </a>
            <ul class="collapse list-unstyled ps-4" id="financeSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/funds" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> จัดการกองทุน</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/projects" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> จัดการโครงการ</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/ledger" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> สมุดบัญชี</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/expenses" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ขออนุมัติเบิกจ่าย</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/banks" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> บัญชีธนาคาร</a></li>
            </ul>
        </li>

        <!-- Assets & E-Doc -->
        <li>
            <a href="#enterpriseSubmenu" data-bs-toggle="collapse" class="nav-link text-white d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-briefcase fa-fw"></i> บริหารงานทั่วไป</span>
                <i class="fa-solid fa-chevron-down fa-xs"></i>
            </a>
            <ul class="collapse list-unstyled ps-4" id="enterpriseSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/assets" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ทะเบียนครุภัณฑ์</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/documents" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ระบบสารบรรณ</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/meetings" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> จัดการประชุม</a></li>
            </ul>
        </li>

        <li class="nav-header small text-muted text-uppercase mt-3 mb-1 fw-bold">Public & Reports</li>

        <!-- Website CMS (Phase 6) -->
        <li>
            <a href="#cmsSubmenu" data-bs-toggle="collapse" class="nav-link text-white d-flex justify-content-between align-items-center text-warning">
                <span><i class="fa-solid fa-globe fa-fw"></i> จัดการเว็บไซต์</span>
                <i class="fa-solid fa-chevron-down fa-xs"></i>
            </a>
            <ul class="collapse list-unstyled ps-4" id="cmsSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/cms/banners" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> Banners</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/cms/news" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ข่าวสาร</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/cms/activities" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> กิจกรรม & แกลเลอรี่</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/cms/pages" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> หน้าเว็บเพจ</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/cms/downloads" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> เอกสารดาวน์โหลด</a></li>
            </ul>
        </li>

        <!-- Reports (Phase 7) -->
        <li class="nav-item">
            <a href="<?php echo $_ENV['APP_URL']; ?>/admin/reports" class="nav-link text-white">
                <i class="fa-solid fa-chart-pie fa-fw"></i> ศูนย์รายงาน (Reports)
            </a>
        </li>

        <li class="nav-header small text-muted text-uppercase mt-3 mb-1 fw-bold">System</li>
        
        <li>
            <a href="<?php echo $_ENV['APP_URL']; ?>/admin/settings" class="nav-link text-white">
                <i class="fa-solid fa-gear fa-fw"></i> ตั้งค่าระบบ
            </a>
        </li>
    </ul>
</div>
