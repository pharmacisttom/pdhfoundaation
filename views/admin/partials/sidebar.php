<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar" style="width: 280px; min-height: 100vh;">
    <a href="<?php echo $_ENV['APP_URL']; ?>/admin" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none border-bottom border-secondary pb-3 w-100">
        <i class="fa-solid fa-hospital-user fa-2x me-3 text-success"></i>
        <span class="fs-5 fw-bold">PDH Foundation</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?php echo $_ENV['APP_URL']; ?>/admin" class="nav-link text-white <?php echo $_SERVER['REQUEST_URI'] == '/pdhfoundation/public/admin' ? 'active bg-success' : ''; ?>" aria-current="page">
                <i class="fa-solid fa-gauge-high"></i> ภาพรวม (Dashboard)
            </a>
        </li>
        <li>
            <a href="#foundationSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between align-items-center nav-link text-white">
                <span><i class="fa-solid fa-building-flag"></i> ข้อมูลมูลนิธิ</span>
            </a>
            <ul class="collapse list-unstyled ps-4" id="foundationSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/profile" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ข้อมูลทั่วไป/วิสัยทัศน์</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/history" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ประวัติ/เจตนารมณ์</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/patrons" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> องค์อุปถัมภ์</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/founders" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ผู้ก่อตั้ง</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/founding-donors" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ผู้บริจาคก่อตั้ง</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/benefactors" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ผู้มีคุณูปการ</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/milestones" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> Timeline</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/board" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> คณะกรรมการ</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/documents" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> เอกสารสำคัญ</a></li>
            </ul>
        </li>
        <li>
            <a href="#donationSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between align-items-center nav-link text-white">
                <span><i class="fa-solid fa-hand-holding-dollar"></i> ระบบรับบริจาค</span>
            </a>
            <ul class="collapse list-unstyled ps-4" id="donationSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/donors" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ฐานข้อมูลผู้บริจาค</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/donations" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> รายการรับบริจาค</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/receipts" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> จัดการใบเสร็จรับเงิน</a></li>
            </ul>
        </li>
        <li>
            <a href="#financeSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between align-items-center nav-link text-white">
                <span><i class="fa-solid fa-coins"></i> ระบบการเงินและบัญชี</span>
            </a>
            <ul class="collapse list-unstyled ps-4" id="financeSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/funds" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> จัดการกองทุน</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/projects" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> จัดการโครงการ</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/ledger" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> สมุดบัญชีแยกประเภท</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/expenses" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ขออนุมัติเบิกจ่าย</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/revenues" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> รับรายได้อื่นๆ</a></li>
            </ul>
        </li>
        <li>
            <a href="#bankSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between align-items-center nav-link text-white">
                <span><i class="fa-solid fa-building-columns"></i> บัญชีธนาคาร</span>
            </a>
            <ul class="collapse list-unstyled ps-4" id="bankSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/banks" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> จัดการบัญชีธนาคาร</a></li>
            </ul>
        </li>
        <li>
            <a href="#assetSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between align-items-center nav-link text-white">
                <span><i class="fa-solid fa-boxes-stacked"></i> ทะเบียนครุภัณฑ์</span>
            </a>
            <ul class="collapse list-unstyled ps-4" id="assetSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/assets" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> รายการครุภัณฑ์</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/assets/transfers" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> โอนย้ายครุภัณฑ์</a></li>
            </ul>
        </li>
        <li>
            <a href="#documentSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between align-items-center nav-link text-white">
                <span><i class="fa-solid fa-file-contract"></i> ระบบสารบรรณ (E-Doc)</span>
            </a>
            <ul class="collapse list-unstyled ps-4" id="documentSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/documents?type=in" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> หนังสือเข้า</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/documents?type=out" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> หนังสือออก</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/documents/categories" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> หมวดหมู่เอกสาร</a></li>
            </ul>
        </li>
        <li>
            <a href="#meetingSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between align-items-center nav-link text-white">
                <span><i class="fa-solid fa-users-viewfinder"></i> จัดการการประชุม</span>
            </a>
            <ul class="collapse list-unstyled ps-4" id="meetingSubmenu">
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/meetings" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> วาระการประชุม</a></li>
                <li><a href="<?php echo $_ENV['APP_URL']; ?>/admin/meetings/tasks" class="nav-link text-white small"><i class="fa-solid fa-circle fa-2xs me-2"></i> ติดตามมติ (Tasks)</a></li>
            </ul>
        </li>
        <li>
            <a href="<?php echo $_ENV['APP_URL']; ?>/admin/settings" class="nav-link text-white">
                <i class="fa-solid fa-gear"></i> ตั้งค่าระบบ
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode(\App\Helpers\Auth::user()['fullname']); ?>&background=0D8ABC&color=fff" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong><?php echo htmlspecialchars(\App\Helpers\Auth::user()['fullname']); ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="<?php echo $_ENV['APP_URL']; ?>/admin/profile">ข้อมูลส่วนตัว</a></li>
            <li><a class="dropdown-item" href="<?php echo $_ENV['APP_URL']; ?>/admin/change-password">เปลี่ยนรหัสผ่าน</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="<?php echo $_ENV['APP_URL']; ?>/admin/logout" method="POST" class="m-0">
                    <button type="submit" class="dropdown-item text-danger">ออกจากระบบ</button>
                </form>
            </li>
        </ul>
    </div>
</div>
