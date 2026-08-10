<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-success"><i class="fa-solid fa-file-invoice-dollar me-2"></i> จัดการใบเสร็จรับเงิน (Receipts)</h4>
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
                        <th>เลขที่ใบเสร็จ</th>
                        <th>วันที่บริจาค</th>
                        <th>ผู้บริจาค</th>
                        <th class="text-end">ยอดเงิน (บาท)</th>
                        <th>อ้างอิงรหัสรับบริจาค</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-center">พิมพ์แล้ว</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['receipts'])): ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">ยังไม่มีข้อมูลใบเสร็จรับเงิน</td></tr>
                    <?php else: ?>
                        <?php foreach ($data['receipts'] as $receipt): ?>
                            <tr class="<?php echo $receipt['is_cancelled'] ? 'table-danger text-muted' : ''; ?>">
                                <td>
                                    <span class="fw-bold"><?php echo $receipt['receipt_number']; ?></span>
                                    <?php if ($receipt['reference_receipt_id']): ?>
                                        <div class="small text-muted"><i class="fa-solid fa-rotate-left"></i> ทดแทนใบเก่า</div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($receipt['donation_date'])); ?></td>
                                <td>
                                    <?php echo $receipt['donor_type'] == 'ORGANIZATION' ? htmlspecialchars($receipt['company_name']) : htmlspecialchars($receipt['first_name'] . ' ' . $receipt['last_name']); ?>
                                </td>
                                <td class="text-end fw-bold"><?php echo number_format($receipt['amount'], 2); ?></td>
                                <td><span class="badge bg-light text-dark border"><?php echo $receipt['donation_number']; ?></span></td>
                                <td class="text-center">
                                    <?php if ($receipt['is_cancelled']): ?>
                                        <span class="badge bg-danger">ยกเลิก (CANCELLED)</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">ใช้งานปกติ</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($receipt['print_count'] > 0): ?>
                                        <span class="badge bg-secondary"><?php echo $receipt['print_count']; ?> ครั้ง</span>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <?php if (!$receipt['is_cancelled']): ?>
                                        <a href="<?php echo $_ENV['APP_URL']; ?>/admin/receipts/print?id=<?php echo $receipt['id']; ?>" target="_blank" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fa-solid fa-print"></i> พิมพ์
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal" onclick="prepareCancel(<?php echo $receipt['id']; ?>, '<?php echo $receipt['receipt_number']; ?>')">
                                            <i class="fa-solid fa-ban"></i> ยกเลิก
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-outline-secondary" onclick="alert('เหตุผลที่ยกเลิก: <?php echo htmlspecialchars($receipt['cancel_reason']); ?>')">
                                            <i class="fa-solid fa-circle-info"></i> เหตุผล
                                        </button>
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

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/receipts/cancel" method="POST">
            <input type="hidden" name="receipt_id" id="cancel_receipt_id">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">ยกเลิกใบเสร็จรับเงิน</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fa-solid fa-triangle-exclamation"></i> การยกเลิกใบเสร็จ <strong>เลขที่ <span id="cancel_receipt_number"></span></strong> จะไม่ลบข้อมูลออกจากระบบ แต่จะถูกทำเครื่องหมายว่ายกเลิก และสถานะการรับบริจาคจะถูกคืนค่าเป็น "อนุมัติ" เพื่อให้ออกใบใหม่ได้
                    </div>
                    <div class="mb-3">
                        <label class="form-label">เหตุผลที่ยกเลิก <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="cancel_reason" rows="3" required placeholder="เช่น พิมพ์ชื่อผิด, เปลี่ยนแปลงยอดเงิน..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-ban"></i> ยืนยันการยกเลิก</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function prepareCancel(id, number) {
    document.getElementById('cancel_receipt_id').value = id;
    document.getElementById('cancel_receipt_number').innerText = number;
}
</script>
