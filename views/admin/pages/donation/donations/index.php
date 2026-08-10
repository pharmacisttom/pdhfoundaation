<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-success"><i class="fa-solid fa-hand-holding-heart me-2"></i> รายการรับบริจาค (Donations)</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#donationModal">
        <i class="fa-solid fa-plus me-1"></i> เพิ่มรายการบริจาค
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
                        <th>วันที่</th>
                        <th>เลขที่อ้างอิง</th>
                        <th>ผู้บริจาค</th>
                        <th class="text-end">ยอดเงิน (บาท)</th>
                        <th>กองทุน</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['donations'])): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">ยังไม่มีข้อมูลรายการบริจาค</td></tr>
                    <?php else: ?>
                        <?php foreach ($data['donations'] as $dn): ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($dn['donation_date'])); ?></td>
                                <td><span class="badge bg-light text-dark border"><?php echo $dn['donation_number']; ?></span></td>
                                <td>
                                    <strong>
                                        <?php echo $dn['donor_type'] == 'ORGANIZATION' ? htmlspecialchars($dn['company_name']) : htmlspecialchars($dn['first_name'] . ' ' . $dn['last_name']); ?>
                                    </strong>
                                    <div class="small text-muted"><?php echo $dn['donor_code']; ?></div>
                                </td>
                                <td class="text-end fw-bold text-success"><?php echo number_format($dn['amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars($dn['fund_name'] ?? '-'); ?></td>
                                <td class="text-center">
                                    <?php 
                                    $badge = 'bg-secondary';
                                    if ($dn['status'] == 'VERIFIED') $badge = 'bg-info text-dark';
                                    if ($dn['status'] == 'APPROVED') $badge = 'bg-primary';
                                    if ($dn['status'] == 'RECEIPT_ISSUED') $badge = 'bg-success';
                                    if ($dn['status'] == 'CANCELLED') $badge = 'bg-danger';
                                    ?>
                                    <span class="badge <?php echo $badge; ?>"><?php echo $dn['status']; ?></span>
                                </td>
                                <td class="text-end">
                                    <?php if ($dn['status'] == 'DRAFT' || $dn['status'] == 'PENDING'): ?>
                                        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/donations/verify" method="POST" class="d-inline" onsubmit="return confirm('ตรวจสอบรายการนี้ว่าถูกต้อง?');">
                                            <input type="hidden" name="id" value="<?php echo $dn['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-check"></i> ตรวจสอบ (Verify)</button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <?php if ($dn['status'] == 'VERIFIED'): ?>
                                        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/donations/approve" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันอนุมัติรายการนี้?');">
                                            <input type="hidden" name="id" value="<?php echo $dn['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-stamp"></i> อนุมัติ (Approve)</button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if ($dn['status'] == 'APPROVED'): ?>
                                        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/receipts/generate" method="POST" class="d-inline">
                                            <input type="hidden" name="donation_id" value="<?php echo $dn['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-success"><i class="fa-solid fa-file-invoice"></i> ออกใบเสร็จ</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="donationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/donations/store" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มรายการรับบริจาคใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ผู้บริจาค <span class="text-danger">*</span></label>
                            <select class="form-select select2" name="donor_id" required>
                                <option value="">เลือกผู้บริจาค...</option>
                                <?php foreach ($data['donors'] as $donor): ?>
                                    <option value="<?php echo $donor['id']; ?>">
                                        [<?php echo $donor['donor_code']; ?>] 
                                        <?php echo $donor['donor_type'] == 'ORGANIZATION' ? $donor['company_name'] : $donor['first_name'] . ' ' . $donor['last_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">วันที่บริจาค <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="donation_date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">จำนวนเงิน (บาท) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="amount" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ช่องทางการชำระเงิน</label>
                            <select class="form-select" name="payment_method">
                                <option value="CASH">เงินสด (Cash)</option>
                                <option value="TRANSFER" selected>โอนเงินผ่านธนาคาร (Transfer)</option>
                                <option value="CHEQUE">เช็ค (Cheque)</option>
                                <option value="CREDIT_CARD">บัตรเครดิต (Credit Card)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">เข้าบัญชีธนาคาร</label>
                            <select class="form-select" name="bank_account_id">
                                <option value="">ไม่ระบุ</option>
                                <?php foreach ($data['banks'] as $bank): ?>
                                    <option value="<?php echo $bank['id']; ?>"><?php echo $bank['bank_name'] . ' - ' . $bank['account_number']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">วัตถุประสงค์ / กองทุน</label>
                            <select class="form-select" name="fund_id">
                                <option value="">ไม่ระบุ</option>
                                <?php foreach ($data['funds'] as $fund): ?>
                                    <option value="<?php echo $fund['id']; ?>"><?php echo htmlspecialchars($fund['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ระบุโครงการเฉพาะ (ถ้ามี)</label>
                            <select class="form-select" name="project_id">
                                <option value="">ไม่ระบุ</option>
                                <?php foreach ($data['projects'] as $proj): ?>
                                    <option value="<?php echo $proj['id']; ?>"><?php echo htmlspecialchars($proj['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">แนบสลิป/หลักฐานการโอนเงิน</label>
                            <input type="file" class="form-control" name="slip_file" accept="image/*,.pdf">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">หมายเหตุ</label>
                            <textarea class="form-control" name="note" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> บันทึกเข้าระบบ</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Select2 for searchable dropdown -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#donationModal')
        });
    });
</script>
