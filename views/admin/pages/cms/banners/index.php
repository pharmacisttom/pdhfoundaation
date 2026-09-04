<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-dark"><i class="fa-solid fa-images text-warning me-2"></i> จัดการแบนเนอร์ (Banners)</h4>
    <button class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#bannerModal">
        <i class="fa-solid fa-plus me-1"></i> เพิ่มแบนเนอร์ใหม่
    </button>
</div>

<?php if (!empty($data['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-check me-2"></i> <?php echo $data['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (!empty($data['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i> <?php echo $data['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 rounded-4 shadow-sm bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 datatable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">รูปภาพ (Preview)</th>
                        <th>หัวข้อ (Title)</th>
                        <th>ระยะเวลาเผยแพร่</th>
                        <th class="text-center">ลำดับ</th>
                        <th class="text-center">สถานะ</th>
                        <th class="text-end pe-4">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['banners'])): ?>
                        <!-- Let DataTables handle empty state, but fallback if DataTables fails -->
                    <?php else: ?>
                        <?php foreach ($data['banners'] as $banner): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="rounded overflow-hidden shadow-sm" style="width: 120px; height: 60px;">
                                        <img src="<?php echo $_ENV['APP_URL']; ?>/uploads/cms/banners/<?php echo $banner['image_file']; ?>" alt="Banner" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </td>
                                <td>
                                    <strong class="d-block text-dark"><?php echo htmlspecialchars($banner['title'] ?? '-'); ?></strong>
                                    <?php if ($banner['button_text']): ?>
                                        <span class="badge bg-light text-primary border mt-1"><i class="fa-solid fa-link me-1"></i> <?php echo htmlspecialchars($banner['button_text']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($banner['published_at']): ?>
                                        <small class="d-block text-success"><i class="fa-regular fa-calendar-check me-1"></i> เริ่ม: <?php echo date('d/m/Y', strtotime($banner['published_at'])); ?></small>
                                    <?php else: ?>
                                        <small class="d-block text-muted">ไม่ได้กำหนดวันเริ่ม</small>
                                    <?php endif; ?>
                                    
                                    <?php if ($banner['expired_at']): ?>
                                        <small class="d-block text-danger"><i class="fa-regular fa-calendar-xmark me-1"></i> สิ้นสุด: <?php echo date('d/m/Y', strtotime($banner['expired_at'])); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-circle"><?php echo $banner['sort_order']; ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($banner['status'] == 'PUBLISHED'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill"><i class="fa-solid fa-globe me-1"></i> เผยแพร่</span>
                                    <?php elseif ($banner['status'] == 'DRAFT'): ?>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded-pill"><i class="fa-solid fa-pen-ruler me-1"></i> ฉบับร่าง</span>
                                    <?php else: ?>
                                        <span class="badge bg-dark-subtle text-dark border border-dark-subtle px-2 py-1 rounded-pill"><i class="fa-solid fa-box-archive me-1"></i> เก็บถาวร</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light border text-primary" title="แก้ไข"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <form action="#" method="POST" class="d-inline">
                                        <button type="button" class="btn btn-sm btn-light border text-danger btn-delete" title="ลบ"><i class="fa-solid fa-trash"></i></button>
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
<div class="modal fade" id="bannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/cms/banners/store" method="POST" enctype="multipart/form-data">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-image text-warning me-2"></i> เพิ่มแบนเนอร์ใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">อัปโหลดรูปภาพ <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" name="image_file" accept="image/jpeg, image/png, image/webp" required>
                        <div class="form-text text-muted">แนะนำขนาด 1920x800 px (รองรับ JPG, PNG, WEBP) ขนาดไฟล์ไม่เกิน 2MB</div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">หัวข้อ (Title)</label>
                            <input type="text" class="form-control" name="title" placeholder="ข้อความบรรทัดหลัก">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">ข้อความรอง (Subtitle)</label>
                            <input type="text" class="form-control" name="subtitle" placeholder="ข้อความบรรทัดรอง">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">ข้อความปุ่ม (Button Text)</label>
                            <input type="text" class="form-control" name="button_text" placeholder="เช่น 'รายละเอียดเพิ่มเติม'">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">ลิงก์ของปุ่ม (Button URL)</label>
                            <input type="url" class="form-control" name="button_url" placeholder="https://...">
                        </div>
                    </div>

                    <hr class="text-secondary my-4">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">วันที่เผยแพร่</label>
                            <input type="text" class="form-control datepicker" name="published_at" placeholder="ตั้งเวลา Publish">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">วันที่สิ้นสุด</label>
                            <input type="text" class="form-control datepicker" name="expired_at" placeholder="ตั้งเวลาเอาลง">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">ลำดับ</label>
                            <input type="number" class="form-control" name="sort_order" value="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">สถานะ</label>
                            <select class="form-select" name="status">
                                <option value="DRAFT">ฉบับร่าง</option>
                                <option value="PUBLISHED" selected>เผยแพร่</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"><i class="fa-solid fa-save me-1"></i> บันทึกข้อมูล</button>
                </div>
            </div>
        </form>
    </div>
</div>
