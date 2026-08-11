<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-plus-circle text-primary me-2"></i> <?php echo $data['page_title']; ?></h4>
    <a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/expenses" class="btn btn-light border rounded-pill px-4 shadow-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> ย้อนกลับ
    </a>
</div>

<?php if (!empty($data['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $data['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/finance/expenses/store" method="POST">
            <?php echo \App\Helpers\CSRF::field(); ?>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">หักจากกองทุน <span class="text-danger">*</span></label>
                    <select name="fund_id" class="form-select" required>
                        <option value="">เลือกกองทุน...</option>
                        <?php foreach($data['funds'] as $f): ?>
                            <option value="<?php echo $f['id']; ?>"><?php echo htmlspecialchars($f['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">เชื่อมโยงโครงการ (ทางเลือก)</label>
                    <select name="project_id" class="form-select">
                        <option value="">ไม่เชื่อมโยงกับโครงการใดๆ</option>
                        <?php foreach($data['projects'] as $p): ?>
                            <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['project_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">วันที่เบิกจ่าย <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="expense_date" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">ยอดเงินเบิกจ่ายทั้งหมด (บาท) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" name="total_amount" required min="1">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">ผู้รับเงิน / ร้านค้า (Vendor)</label>
                    <input type="text" class="form-control" name="vendor" placeholder="เช่น บริษัท เอบีซี จำกัด">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-bold">รายละเอียด/หมายเหตุการเบิกจ่าย</label>
                    <textarea class="form-control" name="note" rows="3" placeholder="ระบุเหตุผลการเบิกจ่าย..."></textarea>
                </div>
                
                <div class="col-12 mt-5 text-end">
                    <hr>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 btn-lg shadow-sm">
                        <i class="fa-solid fa-save me-2"></i> บันทึกรายการขอเบิกจ่าย
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
