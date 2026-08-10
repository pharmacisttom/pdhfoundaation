<nav class="topbar">
    <div>
        <button type="button" id="sidebarCollapse" class="btn btn-light shadow-sm">
            <i class="fa-solid fa-bars"></i>
        </button>
        <span class="ms-3 fw-bold fs-5"><?php echo $data['page_title'] ?? ''; ?></span>
    </div>
    
    <div class="d-flex align-items-center">
        <!-- Notifications (Mock) -->
        <div class="dropdown me-3">
            <a href="#" class="text-secondary position-relative dropdown-toggle" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notifDropdown">
                <li><h6 class="dropdown-header">การแจ้งเตือน</h6></li>
                <li><a class="dropdown-item" href="#">มีรายการบริจาคใหม่ 1 รายการ</a></li>
            </ul>
        </div>
        
        <!-- User Profile Dropdown -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://via.placeholder.com/32" alt="User" class="rounded-circle me-2">
                <strong><?php echo \App\Helpers\Auth::user()['name'] ?? 'Admin'; ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user fa-sm me-2"></i> โปรไฟล์</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?php echo $_ENV['APP_URL']; ?>/admin/logout"><i class="fa-solid fa-right-from-bracket fa-sm me-2"></i> ออกจากระบบ</a></li>
            </ul>
        </div>
    </div>
</nav>
