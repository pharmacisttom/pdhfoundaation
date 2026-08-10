<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-success"><i class="fa-solid fa-tags me-2"></i> หมวดหมู่เอกสาร (Categories)</h4>
    <button class="btn btn-primary" onclick="alert('ฟังก์ชันกำลังพัฒนา');">
        <i class="fa-solid fa-plus me-1"></i> เพิ่มหมวดหมู่
    </button>
</div>

<div class="card shadow-sm rounded-4 border-0 w-50">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            <?php foreach ($data['categories'] as $cat): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <?php echo htmlspecialchars($cat['name']); ?>
                    <?php if ($cat['is_active']): ?>
                        <span class="badge bg-success rounded-pill">ใช้งาน</span>
                    <?php else: ?>
                        <span class="badge bg-secondary rounded-pill">ปิด</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
