<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card kpi-card">
            <div class="kpi-icon primary">
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <div class="kpi-details">
                <p>ยอดบริจาควันนี้</p>
                <h4>฿<?php echo number_format($data['today_donations'] ?? 0); ?></h4>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card kpi-card">
            <div class="kpi-icon gold">
                <i class="fa-solid fa-money-bill-trend-up"></i>
            </div>
            <div class="kpi-details">
                <p>ยอดบริจาคเดือนนี้</p>
                <h4>฿<?php echo number_format($data['month_donations'] ?? 0); ?></h4>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card kpi-card">
            <div class="kpi-icon blue">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="kpi-details">
                <p>จำนวนผู้บริจาค</p>
                <h4><?php echo number_format($data['total_donors'] ?? 0); ?></h4>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card kpi-card">
            <div class="kpi-icon danger">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
            <div class="kpi-details">
                <p>โครงการกำลังดำเนินงาน</p>
                <h4><?php echo number_format($data['active_projects'] ?? 0); ?></h4>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-chart-line me-2"></i> สถิติการบริจาค (รายเดือน)</span>
            </div>
            <div class="card-body">
                <canvas id="donationChart" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="card h-100">
            <div class="card-header">
                <span><i class="fa-solid fa-list-check me-2"></i> รายการรอดำเนินการ</span>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        อนุมัติการรับบริจาค
                        <span class="badge bg-primary rounded-pill">14</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        ออกใบเสร็จรับเงิน
                        <span class="badge bg-warning text-dark rounded-pill">5</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        อนุมัติรายจ่าย
                        <span class="badge bg-danger rounded-pill">2</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('donationChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
            datasets: [{
                label: 'ยอดบริจาค (บาท)',
                data: [120000, 190000, 300000, 500000, 200000, 450000],
                backgroundColor: 'rgba(25, 135, 84, 0.7)',
                borderColor: 'rgba(25, 135, 84, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
