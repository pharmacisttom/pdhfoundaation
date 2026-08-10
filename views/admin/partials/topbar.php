<nav class="topbar d-flex justify-content-between align-items-center bg-white px-4 py-3 border-bottom shadow-sm" style="position: sticky; top: 0; z-index: 1020;">
    <div>
        <button type="button" id="sidebarCollapse" class="btn btn-light shadow-sm d-md-none border">
            <i class="fa-solid fa-bars"></i>
        </button>
        <span class="ms-3 fw-bold fs-5 text-dark d-none d-md-inline"><?php echo $data['page_title'] ?? ''; ?></span>
    </div>
    
    <div class="d-flex align-items-center">
        <!-- Dashboard Button -->
        <a href="<?php echo $_ENV['APP_URL']; ?>/" target="_blank" class="btn btn-outline-success btn-sm me-3 rounded-pill" title="View Public Website">
            <i class="fa-solid fa-globe me-1"></i> ดูหน้าเว็บ
        </a>

        <!-- Notifications -->
        <div class="dropdown me-3">
            <a href="#" class="text-secondary position-relative dropdown-toggle text-decoration-none" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-regular fa-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="notifDropdown" style="width: 300px;">
                <li class="bg-light px-3 py-2 border-bottom"><h6 class="dropdown-header text-dark fw-bold mb-0 p-0">การแจ้งเตือน (Notifications)</h6></li>
                <li><a class="dropdown-item py-2 border-bottom" href="#"><i class="fa-solid fa-circle-exclamation text-warning me-2"></i> มีคำขอเบิกจ่ายรออนุมัติ 2 รายการ</a></li>
                <li><a class="dropdown-item py-2 border-bottom" href="#"><i class="fa-solid fa-hand-holding-dollar text-success me-2"></i> มีผู้บริจาคใหม่ผ่านโอนเงิน</a></li>
                <li><a class="dropdown-item text-center small text-primary py-2" href="#">ดูการแจ้งเตือนทั้งหมด</a></li>
            </ul>
        </div>
        
        <!-- User Profile Dropdown -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode(\App\Helpers\Auth::user()['fullname'] ?? 'Admin'); ?>&background=198754&color=fff" alt="User" width="36" height="36" class="rounded-circle me-2 shadow-sm border border-2 border-white">
                <div class="d-none d-md-block text-end me-1">
                    <strong class="d-block text-dark small" style="line-height: 1;"><?php echo htmlspecialchars(\App\Helpers\Auth::user()['fullname'] ?? 'Admin'); ?></strong>
                    <small class="text-muted" style="font-size: 0.7rem;">Administrator</small>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                <li><a class="dropdown-item py-2" href="#"><i class="fa-solid fa-user-gear fa-sm me-2 text-secondary"></i> ข้อมูลส่วนตัว</a></li>
                <li><a class="dropdown-item py-2" href="#"><i class="fa-solid fa-key fa-sm me-2 text-secondary"></i> เปลี่ยนรหัสผ่าน</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="<?php echo $_ENV['APP_URL']; ?>/admin/logout" method="POST" class="m-0 p-0">
                        <button type="submit" class="dropdown-item py-2 text-danger fw-bold"><i class="fa-solid fa-right-from-bracket fa-sm me-2"></i> ออกจากระบบ</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
