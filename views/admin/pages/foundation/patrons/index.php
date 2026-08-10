<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-success"><i class="fa-solid fa-users me-2"></i> องค์อุปถัมภ์ (Patrons)</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#patronModal" onclick="resetForm()">
        <i class="fa-solid fa-plus me-1"></i> เพิ่มองค์อุปถัมภ์
    </button>
</div>

<?php if (!empty($data['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $data['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm rounded-4 border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="patronsTable">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;"></th>
                        <th style="width: 80px;">รูปภาพ</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>ตำแหน่ง</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody id="sortablePatrons">
                    <?php if (empty($data['patrons'])): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">ยังไม่มีข้อมูล</td></tr>
                    <?php else: ?>
                        <?php foreach ($data['patrons'] as $patron): ?>
                            <tr data-id="<?php echo $patron['id']; ?>">
                                <td class="text-center text-muted" style="cursor: grab;"><i class="fa-solid fa-grip-lines drag-handle"></i></td>
                                <td>
                                    <?php if ($patron['photo']): ?>
                                        <img src="<?php echo $_ENV['APP_URL']; ?>/uploads/foundation/<?php echo $patron['photo']; ?>" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px;">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($patron['prefix'] . $patron['first_name'] . ' ' . $patron['last_name']); ?></strong>
                                    <?php if ($patron['display_name']): ?>
                                        <div class="small text-muted">(<?php echo htmlspecialchars($patron['display_name']); ?>)</div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($patron['position'] ?? '-'); ?></td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-inline-block">
                                        <input class="form-check-input status-toggle" type="checkbox" data-id="<?php echo $patron['id']; ?>" <?php echo $patron['is_published'] ? 'checked' : ''; ?>>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-secondary me-1" onclick='editPatron(<?php echo json_encode($patron); ?>)'><i class="fa-solid fa-pen"></i></button>
                                    <form action="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/patrons/delete" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบข้อมูล?');">
                                        <input type="hidden" name="id" value="<?php echo $patron['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
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
<div class="modal fade" id="patronModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/patrons/store" method="POST" enctype="multipart/form-data" id="patronForm">
            <input type="hidden" name="id" id="patron_id">
            <input type="hidden" name="existing_photo" id="existing_photo">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">เพิ่มองค์อุปถัมภ์</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-3">
                            <img id="photoPreview" src="https://via.placeholder.com/200" class="img-fluid rounded-circle mb-2" style="width: 200px; height: 200px; object-fit: cover;">
                            <input type="file" class="form-control form-control-sm" name="photo" id="photo" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <div class="col-md-9">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">คำนำหน้า</label>
                                    <input type="text" class="form-control" name="prefix" id="prefix">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">ชื่อ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">นามสกุล <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">นามแฝง/ชื่อที่ใช้แสดง</label>
                                    <input type="text" class="form-control" name="display_name" id="display_name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ตำแหน่ง</label>
                                    <input type="text" class="form-control" name="position" id="position">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">วันที่เริ่มเป็นองค์อุปถัมภ์</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">วันที่สิ้นสุด (ถ้ามี)</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date">
                                </div>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" checked>
                                <label class="form-check-label" for="is_published">เผยแพร่สู่สาธารณะ</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">ประวัติ (Biography)</label>
                            <textarea class="form-control tinymce" name="biography" id="biography" rows="5"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ข้อความเชิดชูเกียรติ</label>
                            <textarea class="form-control tinymce" name="honor_text" id="honor_text" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> บันทึกข้อมูล</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    // Initialize TinyMCE
    tinymce.init({
        selector: 'textarea.tinymce',
        menubar: false,
        plugins: 'lists link table code',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link code',
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });

    // Fix TinyMCE inside Bootstrap Modal
    document.addEventListener('focusin', function(e) {
        if (e.target.closest('.tox-tinymce-aux, .moxman-window, .tam-assetmanager-root') !== null) {
            e.stopImmediatePropagation();
        }
    });

    // Initialize Sortable
    var el = document.getElementById('sortablePatrons');
    if (el) {
        var sortable = Sortable.create(el, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function (evt) {
                var order = [];
                $('#sortablePatrons tr').each(function() {
                    order.push($(this).data('id'));
                });
                
                fetch('<?php echo $_ENV["APP_URL"]; ?>/admin/foundation/patrons/sort', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order: order })
                });
            }
        });
    }

    // Toggle Status
    $('.status-toggle').change(function() {
        var id = $(this).data('id');
        var status = $(this).prop('checked');
        
        fetch('<?php echo $_ENV["APP_URL"]; ?>/admin/foundation/patrons/toggle', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id, status: status })
        });
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#photoPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetForm() {
        $('#patronForm')[0].reset();
        $('#patronForm').attr('action', '<?php echo $_ENV["APP_URL"]; ?>/admin/foundation/patrons/store');
        $('#modalTitle').text('เพิ่มองค์อุปถัมภ์');
        $('#patron_id').val('');
        $('#existing_photo').val('');
        $('#photoPreview').attr('src', 'https://via.placeholder.com/200');
        tinymce.get('biography').setContent('');
        tinymce.get('honor_text').setContent('');
    }

    function editPatron(data) {
        resetForm();
        $('#patronForm').attr('action', '<?php echo $_ENV["APP_URL"]; ?>/admin/foundation/patrons/update');
        $('#modalTitle').text('แก้ไของค์อุปถัมภ์');
        
        $('#patron_id').val(data.id);
        $('#prefix').val(data.prefix);
        $('#first_name').val(data.first_name);
        $('#last_name').val(data.last_name);
        $('#display_name').val(data.display_name);
        $('#position').val(data.position);
        $('#start_date').val(data.start_date);
        $('#end_date').val(data.end_date);
        $('#is_published').prop('checked', data.is_published == 1);
        
        if (data.photo) {
            $('#existing_photo').val(data.photo);
            $('#photoPreview').attr('src', '<?php echo $_ENV["APP_URL"]; ?>/uploads/foundation/' + data.photo);
        }
        
        tinymce.get('biography').setContent(data.biography || '');
        tinymce.get('honor_text').setContent(data.honor_text || '');
        
        var modal = new bootstrap.Modal(document.getElementById('patronModal'));
        modal.show();
    }
</script>
