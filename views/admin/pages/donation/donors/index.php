<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-success"><i class="fa-solid fa-address-book me-2"></i> ฐานข้อมูลผู้บริจาค (Donor CRM)</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#donorModal">
        <i class="fa-solid fa-plus me-1"></i> เพิ่มผู้บริจาค
    </button>
</div>

<div class="card shadow-sm rounded-4 border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="donorsTable">
                <thead class="table-light">
                    <tr>
                        <th>รหัสผู้บริจาค</th>
                        <th>ชื่อ-นามสกุล / หน่วยงาน</th>
                        <th>ประเภท</th>
                        <th>เบอร์โทรศัพท์</th>
                        <th class="text-end">จำนวนครั้ง</th>
                        <th class="text-end">ยอดบริจาคสะสม</th>
                        <th class="text-center">ป้ายกำกับ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['donors'])): ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">ยังไม่มีข้อมูล</td></tr>
                    <?php else: ?>
                        <?php foreach ($data['donors'] as $donor): ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?php echo $donor['donor_code']; ?></span></td>
                                <td>
                                    <strong>
                                        <?php if ($donor['donor_type'] == 'ORGANIZATION'): ?>
                                            <?php echo htmlspecialchars($donor['company_name']); ?>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($donor['prefix'] . $donor['first_name'] . ' ' . $donor['last_name']); ?>
                                        <?php endif; ?>
                                    </strong>
                                </td>
                                <td>
                                    <?php echo $donor['donor_type'] == 'ORGANIZATION' ? '<i class="fa-solid fa-building text-muted"></i> นิติบุคคล' : '<i class="fa-solid fa-user text-muted"></i> บุคคลธรรมดา'; ?>
                                </td>
                                <td><?php echo htmlspecialchars($donor['phone'] ?? '-'); ?></td>
                                <td class="text-end"><?php echo number_format($donor['donation_count']); ?></td>
                                <td class="text-end text-success fw-bold"><?php echo number_format($donor['total_donated'] ?? 0, 2); ?> ฿</td>
                                <td class="text-center">
                                    <?php if ($donor['is_vip']): ?> <span class="badge bg-warning text-dark">VIP</span> <?php endif; ?>
                                    <?php if ($donor['is_founding']): ?> <span class="badge bg-info text-dark">ผู้ก่อตั้ง</span> <?php endif; ?>
                                    <?php if ($donor['is_benefactor']): ?> <span class="badge bg-primary">คุณูปการ</span> <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo $_ENV['APP_URL']; ?>/admin/donors/profile?id=<?php echo $donor['id']; ?>" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fa-solid fa-id-card"></i> Profile
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
