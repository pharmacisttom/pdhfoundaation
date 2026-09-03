<?php
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
    $appBasePath = parse_url($_ENV['APP_URL'] ?? '', PHP_URL_PATH) ?: '';
    $normalizedPath = $requestPath;
    if ($appBasePath !== '' && $appBasePath !== '/' && str_starts_with($requestPath, $appBasePath)) {
        $normalizedPath = substr($requestPath, strlen($appBasePath)) ?: '/';
    }
    $dashboardPath = rtrim($normalizedPath, '/');
    $isDashboard = in_array($dashboardPath, ['', '/admin', '/admin/dashboard'], true);
    $isFoundationSection = str_starts_with($dashboardPath, '/admin/foundation');
    $isDonationSection = str_starts_with($dashboardPath, '/admin/donor') || str_starts_with($dashboardPath, '/admin/donation') || str_starts_with($dashboardPath, '/admin/receipt');
    $isFinanceSection = str_starts_with($dashboardPath, '/admin/finance') || str_starts_with($dashboardPath, '/admin/banks');
    $isEnterpriseSection = str_starts_with($dashboardPath, '/admin/assets') || str_starts_with($dashboardPath, '/admin/documents') || str_starts_with($dashboardPath, '/admin/meetings');
    $isCmsSection = str_starts_with($dashboardPath, '/admin/cms');
?>
<aside id="sidebar" class="sidebar d-flex flex-column flex-shrink-0 text-white">
    <a href="<?php echo $_ENV['APP_URL']; ?>/admin" class="sidebar-brand d-flex align-items-center text-white text-decoration-none">
        <img src="<?php echo $_ENV['APP_URL']; ?>/public/assets/images/logo.jpg" alt="Logo" class="me-2 bg-white" style="width: 40px; height: 40px; object-fit: contain; border-radius: 8px;">
        <span class="fw-bold">PDH Foundation</span>
    </a>
    <nav class="sidebar-nav" aria-label="เมนูผู้ดูแลระบบ">
    <ul class="nav nav-pills flex-column mb-0">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="<?php echo $_ENV['APP_URL']; ?>/admin" class="nav-link <?php echo $isDashboard ? 'active' : ''; ?>">
                <i class="fa-solid fa-gauge-high fa-fw"></i> ภาพรวม (Dashboard)
            </a>
        </li>
        
        <li class="nav-header">งานมูลนิธิ</li>
        
        <!-- Foundation Info -->
        <li>
            <a href="#foundationSubmenu" data-bs-toggle="collapse" class="nav-link sidebar-group-link d-flex justify-content-between align-items-center <?php echo $isFoundationSection ? 'section-active' : ''; ?>" aria-expanded="<?php echo $isFoundationSection ? 'true' : 'false'; ?>">
                <span><i class="fa-solid fa-building-flag fa-fw"></i> ข้อมูลมูลนิธิ</span>
                <i class="fa-solid fa-chevron-down fa-xs"></i>
            </a>
            <ul class="collapse sidebar-submenu list-unstyled <?php echo $isFoundationSection ? 'show' : ''; ?>" id="foundationSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/profile" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ข้อมูลทั่วไป</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/history" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ประวัติ/เจตนารมณ์</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/patrons" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> องค์อุปถัมภ์/ผู้ก่อตั้ง</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/board" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> คณะกรรมการ</a></li>
            </ul>
        </li>

        <!-- Donation System -->
        <li>
            <a href="#donationSubmenu" data-bs-toggle="collapse" class="nav-link sidebar-group-link d-flex justify-content-between align-items-center <?php echo $isDonationSection ? 'section-active' : ''; ?>" aria-expanded="<?php echo $isDonationSection ? 'true' : 'false'; ?>">
                <span><i class="fa-solid fa-hand-holding-dollar fa-fw"></i> ระบบรับบริจาค</span>
                <i class="fa-solid fa-chevron-down fa-xs"></i>
            </a>
            <ul class="collapse sidebar-submenu list-unstyled <?php echo $isDonationSection ? 'show' : ''; ?>" id="donationSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/donors" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ฐานข้อมูลผู้บริจาค</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/donations" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> รายการรับบริจาค</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/receipts" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ใบเสร็จรับเงิน</a></li>
            </ul>
        </li>

        <!-- Finance System -->
        <li>
            <a href="#financeSubmenu" data-bs-toggle="collapse" class="nav-link sidebar-group-link d-flex justify-content-between align-items-center <?php echo $isFinanceSection ? 'section-active' : ''; ?>" aria-expanded="<?php echo $isFinanceSection ? 'true' : 'false'; ?>">
                <span><i class="fa-solid fa-coins fa-fw"></i> ระบบการเงิน</span>
                <i class="fa-solid fa-chevron-down fa-xs"></i>
            </a>
            <ul class="collapse sidebar-submenu list-unstyled <?php echo $isFinanceSection ? 'show' : ''; ?>" id="financeSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/funds" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> จัดการกองทุน</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/projects" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> จัดการโครงการ</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/ledger" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> สมุดบัญชี</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/expenses" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ขออนุมัติเบิกจ่าย</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/banks" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> บัญชีธนาคาร</a></li>
            </ul>
        </li>

        <!-- Assets & E-Doc -->
        <li>
            <a href="#enterpriseSubmenu" data-bs-toggle="collapse" class="nav-link sidebar-group-link d-flex justify-content-between align-items-center <?php echo $isEnterpriseSection ? 'section-active' : ''; ?>" aria-expanded="<?php echo $isEnterpriseSection ? 'true' : 'false'; ?>">
                <span><i class="fa-solid fa-briefcase fa-fw"></i> บริหารงานทั่วไป</span>
                <i class="fa-solid fa-chevron-down fa-xs"></i>
            </a>
            <ul class="collapse sidebar-submenu list-unstyled <?php echo $isEnterpriseSection ? 'show' : ''; ?>" id="enterpriseSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/assets" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ทะเบียนครุภัณฑ์</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/documents" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ระบบสารบรรณ</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/meetings" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> จัดการประชุม</a></li>
            </ul>
        </li>

        <li class="nav-header">เว็บไซต์และรายงาน</li>

        <!-- Website CMS (Phase 6) -->
        <li>
            <a href="#cmsSubmenu" data-bs-toggle="collapse" class="nav-link sidebar-group-link d-flex justify-content-between align-items-center <?php echo $isCmsSection ? 'section-active' : ''; ?>" aria-expanded="<?php echo $isCmsSection ? 'true' : 'false'; ?>">
                <span><i class="fa-solid fa-globe fa-fw"></i> จัดการเว็บไซต์</span>
                <i class="fa-solid fa-chevron-down fa-xs"></i>
            </a>
            <ul class="collapse sidebar-submenu list-unstyled <?php echo $isCmsSection ? 'show' : ''; ?>" id="cmsSubmenu">
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

        <li class="nav-header">ระบบ</li>
        
        <li>
            <a href="<?php echo $_ENV['APP_URL']; ?>/admin/settings" class="nav-link text-white">
                <i class="fa-solid fa-gear fa-fw"></i> ตั้งค่าระบบ
            </a>
        </li>
    </ul>
    </nav>
</aside>
