<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-success"><i class="fa-solid fa-piggy-bank me-2"></i> จัดการกองทุน (Fund Management)</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fundModal">
        <i class="fa-solid fa-plus me-1"></i> เพิ่มกองทุนใหม่
    </button>
</div>

<?php if (!empty($data['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $data['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (!empty($data['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $data['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm rounded-4 border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>รหัสกองทุน</th>
                        <th>ชื่อกองทุน</th>
                        <th class="text-end">ยอดยกมา (฿)</th>
                        <th class="text-end">คงเหลือปัจจุบัน (฿)</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['funds'])): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">ยังไม่มีข้อมูลกองทุน</td></tr>
                    <?php else: ?>
                        <?php foreach ($data['funds'] as $fund): ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($fund['fund_code'] ?? '-'); ?></span></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($fund['name']); ?></strong>
                                    <?php if ($fund['description']): ?>
                                        <div class="small text-muted"><?php echo htmlspecialchars($fund['description']); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end"><?php echo number_format($fund['opening_balance'] ?? 0, 2); ?></td>
                                <td class="text-end text-success fw-bold"><?php echo number_format($fund['current_balance'] ?? 0, 2); ?></td>
                                <td class="text-center">
                                    <?php if (($fund['status'] ?? 'OPEN') == 'OPEN'): ?>
                                        <span class="badge bg-success">เปิดรับ (OPEN)</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">ปิดรับ (CLOSED)</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/ledger?fund_id=<?php echo $fund['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-book"></i> สมุดบัญชี
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="fundModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/finance/funds/store" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มกองทุนใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">รหัสกองทุน</label>
                        <input type="text" class="form-control" name="fund_code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ชื่อกองทุน <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">รายละเอียด</label>
                        <textarea class="form-control" name="description" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ยอดยกมา (Opening Balance)</label>
                        <input type="number" step="0.01" class="form-control" name="opening_balance" value="0.00">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">สถานะ</label>
                        <select class="form-select" name="status">
                            <option value="OPEN">เปิดรับ (OPEN)</option>
                            <option value="CLOSED">ปิดรับ (CLOSED)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> บันทึก</button>
                </div>
            </div>
        </form>
    </div>
</div>
