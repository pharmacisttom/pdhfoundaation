<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-success"><i class="fa-solid fa-chart-pie me-2"></i> ศูนย์รายงาน (Report Center)</h4>
</div>

<div class="row g-4">
    <!-- Filters Sidebar -->
    <div class="col-md-4 col-lg-3">
        <div class="card border-0 rounded-4 shadow-sm h-100 bg-white">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="fw-bold"><i class="fa-solid fa-filter text-primary me-2"></i> ตัวกรองข้อมูล (Filters)</h6>
            </div>
            <div class="card-body">
                <form id="reportFilterForm" target="_blank" action="<?php echo $_ENV['APP_URL']; ?>/admin/reports/generate" method="GET">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">ประเภทรายงาน</label>
                        <select name="type" class="form-select select2" required>
                            <option value="donation">รายงานการรับบริจาค</option>
                            <option value="donor">รายงานฐานข้อมูลผู้บริจาค</option>
                            <option value="receipt">รายงานการออกใบเสร็จรับเงิน</option>
                            <option value="fund">รายงานสรุปยอดกองทุน</option>
                            <option value="project">รายงานสรุปโครงการ</option>
                            <option value="revenue">รายงานรายรับอื่นๆ</option>
                            <option value="expense">รายงานการเบิกจ่าย</option>
                            <option value="bank">รายงานสมุดบัญชีธนาคาร</option>
                            <option value="asset">รายงานทะเบียนครุภัณฑ์</option>
                            <option value="meeting">รายงานการประชุมและมติ</option>
                            <option value="document">รายงานระบบสารบรรณ</option>
                            <option value="executive" class="text-danger fw-bold">Executive Summary Report (Consolidated)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">ช่วงวันที่</label>
                        <input type="text" class="form-control datepicker" name="start_date" placeholder="ตั้งแต่วันที่" required value="<?php echo date('Y-m-01'); ?>">
                        <div class="text-center my-1"><i class="fa-solid fa-arrow-down text-muted small"></i></div>
                        <input type="text" class="form-control datepicker" name="end_date" placeholder="ถึงวันที่" required value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">กองทุน (เฉพาะรายงานที่เกี่ยวข้อง)</label>
                        <select name="fund_id" class="form-select select2">
                            <option value="all">-- ทุกกองทุน --</option>
                            <?php foreach ($data['funds'] as $fund): ?>
                                <option value="<?php echo $fund['id']; ?>"><?php echo htmlspecialchars($fund['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">รูปแบบการส่งออก (Export Format)</label>
                        <div class="d-flex gap-2">
                            <input type="radio" class="btn-check" name="format" id="fmt_csv" autocomplete="off" value="csv" checked>
                            <label class="btn btn-outline-success flex-fill" for="fmt_csv"><i class="fa-solid fa-file-csv"></i> CSV</label>

                            <input type="radio" class="btn-check" name="format" id="fmt_pdf" autocomplete="off" value="pdf">
                            <label class="btn btn-outline-danger flex-fill" for="fmt_pdf"><i class="fa-solid fa-file-pdf"></i> PDF</label>
                            
                            <!-- Excel disabled until ext-gd is enabled on server -->
                            <input type="radio" class="btn-check" name="format" id="fmt_excel" autocomplete="off" value="excel" disabled>
                            <label class="btn btn-outline-secondary flex-fill" for="fmt_excel" title="Requires PHP ext-gd"><i class="fa-solid fa-file-excel"></i> Excel</label>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill fw-bold shadow-sm"><i class="fa-solid fa-cloud-arrow-down me-2"></i> สร้างรายงาน (Generate)</button>
                        <button type="button" class="btn btn-light rounded-pill border" onclick="window.print();"><i class="fa-solid fa-print me-2"></i> พิมพ์หน้านี้</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Report Preview Area -->
    <div class="col-md-8 col-lg-9">
        <div class="card border-0 rounded-4 shadow-sm h-100 bg-white">
            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center py-5">
                <div class="mb-4">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/report-analysis-4268367-3561005.png" alt="Report Illustration" style="max-height: 250px; opacity: 0.8;">
                </div>
                <h4 class="fw-bold text-dark mb-2">ระบบสร้างรายงานอัจฉริยะ</h4>
                <p class="text-muted mx-auto" style="max-width: 500px;">
                    กรุณาเลือกประเภทรายงาน ช่วงวันที่ และเงื่อนไขที่ต้องการจากเมนูด้านซ้าย จากนั้นกดปุ่ม <strong>"สร้างรายงาน"</strong> เพื่อดาวน์โหลดข้อมูล
                </p>
                <div class="d-flex gap-3 mt-3 opacity-50">
                    <i class="fa-solid fa-file-csv fa-2x"></i>
                    <i class="fa-solid fa-file-pdf fa-2x"></i>
                    <i class="fa-solid fa-print fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Print Stylesheet */
@media print {
    .sidebar, .topbar, .col-md-4 { display: none !important; }
    #content, .page-content { padding: 0 !important; margin: 0 !important; }
    .col-md-8 { width: 100% !important; }
    .card { box-shadow: none !important; border: 1px solid #ccc !important; }
}
</style>
