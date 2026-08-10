<!-- KPI Cards Row 1: Donations -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo $_ENV['APP_URL']; ?>/admin/donations?filter=today" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">ยอดบริจาควันนี้</h6>
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-0"><?php echo number_format($data['kpi']['today'], 2); ?> <span class="fs-6 text-muted">฿</span></h3>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo $_ENV['APP_URL']; ?>/admin/donations?filter=month" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift bg-white border-bottom border-success border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-success fw-bold mb-0">ยอดบริจาคเดือนนี้</h6>
                        <div class="bg-success text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-success mb-0"><?php echo number_format($data['kpi']['month'], 2); ?> <span class="fs-6 text-muted">฿</span></h3>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo $_ENV['APP_URL']; ?>/admin/donations?filter=year" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">ยอดบริจาคปีนี้</h6>
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-0"><?php echo number_format($data['kpi']['year'], 2); ?> <span class="fs-6 text-muted">฿</span></h3>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="<?php echo $_ENV['APP_URL']; ?>/admin/donors" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">จำนวนผู้บริจาค</h6>
                        <div class="bg-info bg-opacity-10 text-info rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-0"><?php echo number_format($data['kpi']['donors']); ?> <span class="fs-6 text-muted">ราย</span></h3>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- KPI Cards Row 2: Foundation Operations -->
<div class="row g-3 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift bg-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted fw-bold mb-0">รายรับ - รายจ่ายสะสม</h6>
                    <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <small class="text-success d-block"><i class="fa-solid fa-arrow-up"></i> รับ: <?php echo number_format($data['kpi']['revenue'], 2); ?></small>
                        <small class="text-danger d-block"><i class="fa-solid fa-arrow-down"></i> จ่าย: <?php echo number_format($data['kpi']['expense'], 2); ?></small>
                    </div>
                    <h4 class="fw-bold text-dark mb-0 text-end">คงเหลือ<br><?php echo number_format($data['kpi']['balance'], 2); ?></h4>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-6">
        <a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/funds" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift bg-white">
                <div class="card-body text-center">
                    <h1 class="display-6 fw-bold text-primary mb-0"><?php echo $data['kpi']['funds']; ?></h1>
                    <span class="text-muted small fw-bold">กองทุน (Funds)</span>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-xl-2 col-md-6">
        <a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/projects" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift bg-white">
                <div class="card-body text-center">
                    <h1 class="display-6 fw-bold text-info mb-0"><?php echo $data['kpi']['projects']; ?></h1>
                    <span class="text-muted small fw-bold">โครงการ (Projects)</span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-4 col-md-6">
        <a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/expenses?status=pending" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100 hover-lift bg-warning bg-opacity-10 border-start border-warning border-4">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-warning-emphasis fw-bold mb-1">รายการรออนุมัติเบิกจ่าย</h6>
                        <small class="text-muted">กรุณาตรวจสอบและดำเนินการ</small>
                    </div>
                    <h1 class="display-5 fw-bold text-warning mb-0"><?php echo $data['kpi']['pending_expenses']; ?></h1>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4">
    <!-- Trend Chart -->
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-chart-area text-primary me-2"></i> สถิติการรับบริจาค (ย้อนหลัง 6 เดือน)</h6>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light border" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">ดูรายงานฉบับเต็ม</a></li>
                        <li><a class="dropdown-item" href="#">ส่งออก PDF</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <canvas id="trendChart" style="height: 300px; width: 100%;"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Doughnut Chart -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-pie-chart text-success me-2"></i> สัดส่วนกองทุน (Fund Allocation)</h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <div style="height: 250px; width: 100%;">
                    <canvas id="fundChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inject Chart.js Logic -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Trend Line Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    
    // Create Gradient for Line Chart
    let gradient = trendCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(25, 135, 84, 0.5)'); // Bootstrap Success
    gradient.addColorStop(1, 'rgba(25, 135, 84, 0.05)');

    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: <?php echo $data['charts']['trend_labels']; ?>,
            datasets: [{
                label: 'ยอดบริจาค (บาท)',
                data: <?php echo $data['charts']['trend_data']; ?>,
                borderColor: '#198754',
                backgroundColor: gradient,
                borderWidth: 2,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#198754',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [2, 2], drawBorder: false }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // 2. Fund Doughnut Chart
    const fundCtx = document.getElementById('fundChart').getContext('2d');
    new Chart(fundCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo $data['charts']['fund_labels']; ?>,
            datasets: [{
                data: <?php echo $data['charts']['fund_data']; ?>,
                backgroundColor: ['#198754', '#c9a227', '#0dcaf0', '#6c757d', '#fd7e14'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { family: "'Sarabun', sans-serif" }
                    }
                }
            }
        }
    });
});
</script>

<style>
/* Dashboard specific styles */
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.1) !important;
}
</style>
