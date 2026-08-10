<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-success">
        <i class="fa-solid <?php echo $data['direction'] == 'IN' ? 'fa-inbox' : 'fa-paper-plane'; ?> me-2"></i> 
        <?php echo $data['page_title']; ?>
    </h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#docModal">
        <i class="fa-solid fa-plus me-1"></i> เพิ่มหนังสือใหม่
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
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>เลขที่หนังสือ</th>
                        <th>ลงวันที่</th>
                        <th>เรื่อง</th>
                        <th>หมวดหมู่</th>
                        <th>จาก/ถึง</th>
                        <th class="text-center">ไฟล์แนบ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['documents'])): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">ยังไม่มีข้อมูลเอกสาร</td></tr>
                    <?php else: ?>
                        <?php foreach ($data['documents'] as $doc): ?>
                            <tr>
                                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($doc['doc_number'] ?? '-'); ?></span></td>
                                <td><?php echo date('d/m/Y', strtotime($doc['doc_date'])); ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($doc['subject']); ?></strong>
                                </td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($doc['category_name']); ?></span></td>
                                <td>
                                    <?php if ($data['direction'] == 'IN'): ?>
                                        <div class="small text-muted">จาก:</div>
                                        <?php echo htmlspecialchars($doc['doc_from']); ?>
                                    <?php else: ?>
                                        <div class="small text-muted">ถึง:</div>
                                        <?php echo htmlspecialchars($doc['doc_to']); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($doc['file_path']): ?>
                                        <a href="<?php echo $_ENV['APP_URL']; ?>/public/uploads/documents/<?php echo $doc['file_path']; ?>" target="_blank" class="text-danger"><i class="fa-solid fa-file-pdf fa-lg"></i></a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Placeholder -->
<div class="modal fade" id="docModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ลงทะเบียนรับ/ส่ง หนังสือ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-5 text-muted">
                <i class="fa-solid fa-person-digging fa-3x mb-3"></i>
                <p>แบบฟอร์มบันทึกข้อมูลสารบรรณ</p>
                <small>กำลังอยู่ระหว่างการเชื่อมต่อไฟล์แนบ</small>
            </div>
        </div>
    </div>
</div>
