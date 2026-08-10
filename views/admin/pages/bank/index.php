<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-success"><i class="fa-solid fa-building-columns me-2"></i> จัดการบัญชีธนาคาร (Bank Management)</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bankModal">
        <i class="fa-solid fa-plus me-1"></i> เพิ่มบัญชี
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
                        <th>ธนาคาร</th>
                        <th>ชื่อบัญชี</th>
                        <th>เลขบัญชี</th>
                        <th>ประเภทบัญชี</th>
                        <th class="text-end">ยอดคงเหลือ (฿)</th>
                        <th class="text-center">QR Code</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['banks'])): ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">ยังไม่มีข้อมูลบัญชีธนาคาร</td></tr>
                    <?php else: ?>
                        <?php foreach ($data['banks'] as $bank): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($bank['bank_name']); ?></strong>
                                    <?php if ($bank['branch']): ?>
                                        <div class="small text-muted">สาขา: <?php echo htmlspecialchars($bank['branch']); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($bank['account_name']); ?></td>
                                <td><span class="font-monospace"><?php echo htmlspecialchars($bank['account_number']); ?></span></td>
                                <td><?php echo htmlspecialchars($bank['account_type']); ?></td>
                                <td class="text-end text-success fw-bold"><?php echo number_format($bank['current_balance'] ?? 0, 2); ?></td>
                                <td class="text-center">
                                    <?php if ($bank['qr_code_file']): ?>
                                        <i class="fa-solid fa-qrcode text-primary"></i>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($bank['status'] == 'ACTIVE'): ?>
                                        <span class="badge bg-success">ใช้งาน</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">ปิดใช้งาน</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-info"><i class="fa-solid fa-list"></i> Statement</button>
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
<div class="modal fade" id="bankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/banks/store" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มบัญชีธนาคาร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">ชื่อธนาคาร <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="bank_name" required placeholder="เช่น ธนาคารกรุงไทย">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">สาขา</label>
                        <input type="text" class="form-control" name="branch" placeholder="เช่น สาขาปลวกแดง">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ชื่อบัญชี <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="account_name" required placeholder="เช่น มูลนิธิเพื่อโรงพยาบาลปลวกแดง">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">เลขบัญชี <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="account_number" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ประเภทบัญชี</label>
                            <select class="form-select" name="account_type">
                                <option value="ออมทรัพย์">ออมทรัพย์</option>
                                <option value="กระแสรายวัน">กระแสรายวัน</option>
                                <option value="ฝากประจำ">ฝากประจำ</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ยอดยกมา (฿)</label>
                            <input type="number" step="0.01" class="form-control" name="current_balance" value="0.00">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> บันทึก</button>
                </div>
            </div>
        </form>
    </div>
</div>
