<?php require_once ROOT_PATH . '/views/admin/layouts/main.php'; ?>

<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-users text-primary me-2"></i> <?php echo $data['page_title']; ?></h4>
    <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#formModal">
        <i class="fa-solid fa-plus me-1"></i> เพิ่มข้อมูลใหม่
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table class="table table-hover align-middle" id="dataTable">
            <thead class="table-light">
                <tr>
                    <th width="5%">#</th>
                    <th>ชื่อ-นามสกุล</th>
<th>ตำแหน่ง</th>

                    <th width="15%" class="text-end">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['items'] as $index => $item): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
<td><?php echo htmlspecialchars($item['position']); ?></td>

                    <td class="text-end">
                        <button class="btn btn-sm btn-light border edit-btn" data-item='<?php echo json_encode($item); ?>'><i class="fa-solid fa-pen text-warning"></i></button>
                        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/board/delete" method="POST" class="d-inline delete-form">
                            <?php echo \App\Helpers\CSRF::field(); ?>
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <button type="button" class="btn btn-sm btn-light border btn-delete"><i class="fa-solid fa-trash text-danger"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data['items'])): ?>
                <tr><td colspan="10" class="text-center py-4 text-muted">ไม่พบข้อมูล</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="formModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/board/store" method="POST">
                <?php echo \App\Helpers\CSRF::field(); ?>
                <input type="hidden" name="id" id="form_id">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">จัดการข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
            <label class="form-label">ชื่อ-นามสกุล</label>
            <input type="text" class="form-control" name="name" required>
        </div>
<div class="mb-3">
            <label class="form-label">ตำแหน่ง</label>
            <input type="text" class="form-control" name="position" required>
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
    // Edit Form populator
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const data = JSON.parse(this.dataset.item);
            document.getElementById('form_id').value = data.id;
            for(let key in data) {
                let el = document.querySelector('input[name="' + key + '"]');
                if(el) el.value = data[key];
            }
            new bootstrap.Modal(document.getElementById('formModal')).show();
        });
    });

    // Modal reset on close
    document.getElementById('formModal').addEventListener('hidden.bs.modal', function () {
        this.querySelector('form').reset();
        document.getElementById('form_id').value = '';
    });
});
</script>
<?php $content = ob_get_clean(); ?>
<?php renderLayout($content, $data ?? []); ?>
