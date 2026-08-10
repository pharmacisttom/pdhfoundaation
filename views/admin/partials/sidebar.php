<nav id="sidebar">
    <div class="sidebar-header">
        <h3>PDH Foundation</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="active">
            <a href="<?php echo $_ENV['APP_URL']; ?>/admin/dashboard">
                <i class="fa-solid fa-gauge"></i> แดชบอร์ด
            </a>
        </li>
        <li>
            <a href="#foundationSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-building-flag"></i> ข้อมูลมูลนิธิ</span>
            </a>
            <ul class="collapse list-unstyled" id="foundationSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/profile"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> ข้อมูลทั่วไป/วิสัยทัศน์</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/history"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> ประวัติ/เจตนารมณ์</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/patrons"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> องค์อุปถัมภ์</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/founders"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> ผู้ก่อตั้ง</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/founding-donors"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> ผู้บริจาคก่อตั้ง</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/benefactors"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> ผู้มีคุณูปการ</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/milestones"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> Timeline</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/board"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> คณะกรรมการ</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/documents"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> เอกสารสำคัญ</a></li>
            </ul>
        </li>
        <li>
            <a href="#donationSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-hand-holding-dollar"></i> ระบบรับบริจาค</span>
            </a>
            <ul class="collapse list-unstyled" id="donationSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/donors"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> ฐานข้อมูลผู้บริจาค (CRM)</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/donations"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> รายการรับบริจาค</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/receipts"><i class="fa-solid fa-circle fa-2xs ms-3 me-2"></i> จัดการใบเสร็จรับเงิน</a></li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class="fa-solid fa-users"></i> ผู้บริจาค
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa-solid fa-file-invoice-dollar"></i> ใบเสร็จรับเงิน
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa-solid fa-piggy-bank"></i> กองทุน
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa-solid fa-briefcase-medical"></i> โครงการ
            </a>
        </li>
        
        <p class="text-muted small px-3 mt-3 mb-1 fw-bold">จัดการระบบ</p>
        
        <li>
            <a href="#">
                <i class="fa-solid fa-globe"></i> เว็บไซต์ CMS
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa-solid fa-chart-pie"></i> รายงาน
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa-solid fa-user-shield"></i> ผู้ใช้งาน
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa-solid fa-gear"></i> ตั้งค่า
            </a>
        </li>
    </ul>
</nav>
