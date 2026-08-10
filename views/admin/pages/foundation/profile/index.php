<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-success"><i class="fa-solid fa-building me-2"></i> ข้อมูลมูลนิธิ (Foundation Profile)</h4>
</div>

<?php if (!empty($data['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $data['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm rounded-4 border-0">
    <div class="card-body p-4">
        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/foundation/profile" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="existing_logo" value="<?php echo htmlspecialchars($data['profile']['logo'] ?? ''); ?>">
            <input type="hidden" name="existing_favicon" value="<?php echo htmlspecialchars($data['profile']['favicon'] ?? ''); ?>">

            <div class="row">
                <div class="col-md-3 border-end">
                    <h5 class="mb-3 text-primary">ตราสัญลักษณ์ (Logos)</h5>
                    <div class="mb-4 text-center">
                        <label class="form-label d-block text-start">Logo มูลนิธิ</label>
                        <div class="border rounded p-3 mb-2 bg-light">
                            <?php if (!empty($data['profile']['logo'])): ?>
                                <img src="<?php echo $_ENV['APP_URL']; ?>/uploads/foundation/<?php echo $data['profile']['logo']; ?>" class="img-fluid" style="max-height: 120px;" id="logoPreview">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/150" class="img-fluid" style="max-height: 120px;" id="logoPreview">
                            <?php endif; ?>
                        </div>
                        <input type="file" class="form-control form-control-sm" name="logo" accept="image/*" onchange="previewImage(this, '#logoPreview')">
                    </div>
                    
                    <div class="mb-4 text-center">
                        <label class="form-label d-block text-start">Favicon (ไอคอนบน Browser)</label>
                        <div class="border rounded p-3 mb-2 bg-light">
                            <?php if (!empty($data['profile']['favicon'])): ?>
                                <img src="<?php echo $_ENV['APP_URL']; ?>/uploads/foundation/<?php echo $data['profile']['favicon']; ?>" class="img-fluid" style="max-height: 64px;" id="faviconPreview">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/64" class="img-fluid" style="max-height: 64px;" id="faviconPreview">
                            <?php endif; ?>
                        </div>
                        <input type="file" class="form-control form-control-sm" name="favicon" accept=".ico,.png" onchange="previewImage(this, '#faviconPreview')">
                    </div>
                </div>
                
                <div class="col-md-9 ps-md-4">
                    <h5 class="mb-3 text-primary">ข้อมูลพื้นฐาน</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ชื่อมูลนิธิ (ภาษาไทย) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name_th" value="<?php echo htmlspecialchars($data['profile']['name_th'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ชื่อมูลนิธิ (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" name="name_en" value="<?php echo htmlspecialchars($data['profile']['name_en'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">ชื่อย่อ</label>
                            <input type="text" class="form-control" name="short_name" value="<?php echo htmlspecialchars($data['profile']['short_name'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">เลขทะเบียนมูลนิธิ</label>
                            <input type="text" class="form-control" name="registration_no" value="<?php echo htmlspecialchars($data['profile']['registration_no'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">เลขผู้เสียภาษี (Tax ID)</label>
                            <input type="text" class="form-control" name="tax_id" value="<?php echo htmlspecialchars($data['profile']['tax_id'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">วันที่ก่อตั้ง</label>
                            <input type="date" class="form-control" name="founded_date" value="<?php echo htmlspecialchars($data['profile']['founded_date'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">เวลาทำการ</label>
                            <input type="text" class="form-control" name="working_hours" value="<?php echo htmlspecialchars($data['profile']['working_hours'] ?? ''); ?>" placeholder="เช่น จ.-ศ. 08:30 - 16:30 น.">
                        </div>
                    </div>

                    <h5 class="mb-3 text-primary border-top pt-4">การติดต่อสื่อสาร</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">ที่อยู่ (Address)</label>
                            <textarea class="form-control" name="address" rows="3"><?php echo htmlspecialchars($data['profile']['address'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Google Maps (Iframe Embed Code)</label>
                            <textarea class="form-control text-muted" name="google_maps" rows="3" placeholder="<iframe src=...><\/iframe>"><?php echo htmlspecialchars($data['profile']['google_maps'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">โทรศัพท์ (Phone)</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($data['profile']['phone'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">อีเมล (Email)</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($data['profile']['email'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">เว็บไซต์ (Website URL)</label>
                            <input type="text" class="form-control" name="website" value="<?php echo htmlspecialchars($data['profile']['website'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Facebook URL</label>
                            <input type="text" class="form-control" name="facebook" value="<?php echo htmlspecialchars($data['profile']['facebook'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">LINE OA (@ID)</label>
                            <input type="text" class="form-control" name="line_oa" value="<?php echo htmlspecialchars($data['profile']['line_oa'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2"><i class="fa-solid fa-save me-2"></i> บันทึกข้อมูล</button>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</div>

<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(previewId).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
