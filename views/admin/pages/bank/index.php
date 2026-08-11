<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-building-columns text-primary me-2"></i> <?php echo $data['page_title']; ?></h4>
    <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#formModal">
        <i class="fa-solid fa-plus me-1"></i> เพิ่มบัญชีธนาคาร
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

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table class="table table-hover align-middle" id="dataTable">
            <thead class="table-light">
                <tr>
                    <th>ธนาคาร</th>
                    <th>สาขา</th>
                    <th>ชื่อบัญชี</th>
                    <th>เลขที่บัญชี</th>
                    <th>ประเภท</th>
                    <th>QR Code</th>
                    <th class="text-center">สถานะ</th>
                    <th class="text-end">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['banks'] as $item): ?>
                <tr>
                    <td class="fw-bold"><?php echo htmlspecialchars($item['bank_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['branch'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($item['account_name']); ?></td>
                    <td class="text-primary font-monospace"><?php echo htmlspecialchars($item['account_number']); ?></td>
                    <td><?php echo htmlspecialchars($item['account_type'] ?? '-'); ?></td>
                    <td>
                        <?php if($item['qr_code_file']): ?>
                            <img src="<?php echo $_ENV['APP_URL'] . $item['qr_code_file']; ?>" alt="QR" width="40" height="40" class="rounded border">
                        <?php else: ?>
                            <span class="text-muted small">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-<?php echo $item['status'] == 'ACTIVE' ? 'success' : 'secondary'; ?> rounded-pill px-3"><?php echo $item['status']; ?></span>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-light border edit-btn" data-item='<?php echo json_encode($item); ?>'><i class="fa-solid fa-pen text-warning"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data['banks'])): ?>
                <tr><td colspan="8" class="text-center py-4 text-muted">ไม่พบข้อมูลบัญชีธนาคาร</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="formModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="<?php echo $_ENV['APP_URL']; ?>/admin/banks/store" method="POST" enctype="multipart/form-data">
                <?php echo \App\Helpers\CSRF::field(); ?>
                <input type="hidden" name="id" id="form_id">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">ข้อมูลบัญชีธนาคาร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">ชื่อธนาคาร <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="bank_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">สาขา</label>
                        <input type="text" class="form-control" name="branch">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ชื่อบัญชี <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="account_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">เลขที่บัญชี <span class="text-danger">*</span></label>
                        <input type="text" class="form-control font-monospace" name="account_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ประเภทบัญชี</label>
                        <select name="account_type" class="form-select">
                            <option value="ออมทรัพย์">ออมทรัพย์</option>
                            <option value="กระแสรายวัน">กระแสรายวัน</option>
                            <option value="ฝากประจำ">ฝากประจำ</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ภาพ QR Code (ถ้ามี)</label>
                        <input type="file" class="form-control" name="qr_code_file" accept=".jpg,.jpeg,.png,.webp">
                        <div class="form-text">รองรับ jpg, png ขนาดไม่เกิน 2MB</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">สถานะ</label>
                        <select name="status" class="form-select">
                            <option value="ACTIVE">เปิดใช้งาน (ACTIVE)</option>
                            <option value="INACTIVE">ปิดใช้งาน (INACTIVE)</option>
                            <option value="CLOSED">ปิดบัญชีถาวร (CLOSED)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if($.fn.DataTable) {
        $('#dataTable').DataTable({
            "order": [],
            "language": { "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json" }
        });
    }

    // Edit Form populator
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const data = JSON.parse(this.dataset.item);
            document.getElementById('form_id').value = data.id;
            for(let key in data) {
                let el = document.querySelector(`input[name='${key}'], select[name='${key}']`);
                if(el && el.type !== 'file') el.value = data[key];
            }
            new bootstrap.Modal(document.getElementById('formModal')).show();
        });
    });

    document.getElementById('formModal').addEventListener('hidden.bs.modal', function () {
        this.querySelector('form').reset();
        document.getElementById('form_id').value = '';
    });
});
</script>
