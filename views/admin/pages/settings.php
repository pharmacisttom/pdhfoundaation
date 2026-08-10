<div class="card">
    <div class="card-header">
        ข้อมูลมูลนิธิ (Foundation Profile)
    </div>
    <div class="card-body">
        
        <?php if (!empty($data['success'])): ?>
            <div class="alert alert-success"><?php echo $data['success']; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($data['error'])): ?>
            <div class="alert alert-danger"><?php echo $data['error']; ?></div>
        <?php endif; ?>

        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/settings" method="POST">
            <!-- Mock CSRF -->
            <input type="hidden" name="csrf_token" value="token_here">
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">ชื่อระบบ (App Name)</label>
                    <input type="text" class="form-control" name="app_name" value="<?php echo htmlspecialchars($data['settings']['app_name'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">ชื่อมูลนิธิ (ภาษาไทย)</label>
                    <input type="text" class="form-control" name="foundation_name_th" value="<?php echo htmlspecialchars($data['settings']['foundation_name_th'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">เลขทะเบียนมูลนิธิ</label>
                    <input type="text" class="form-control" name="registration_no" value="<?php echo htmlspecialchars($data['settings']['registration_no'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">เลขประจำตัวผู้เสียภาษี</label>
                    <input type="text" class="form-control" name="tax_id" value="<?php echo htmlspecialchars($data['settings']['tax_id'] ?? ''); ?>">
                </div>
            </div>

            <hr>
            <h5>การติดต่อ (Contact Info)</h5>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">อีเมล (Email)</label>
                    <input type="email" class="form-control" name="contact_email" value="<?php echo htmlspecialchars($data['settings']['contact_email'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">เบอร์โทรศัพท์ (Phone)</label>
                    <input type="text" class="form-control" name="contact_phone" value="<?php echo htmlspecialchars($data['settings']['contact_phone'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">ที่อยู่ (Address)</label>
                <textarea class="form-control" name="address" rows="3"><?php echo htmlspecialchars($data['settings']['address'] ?? ''); ?></textarea>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> บันทึกการตั้งค่า</button>
            </div>
        </form>
    </div>
</div>
