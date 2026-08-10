<?php $donor = $data['donor']; ?>
<div class="mb-4">
    <a href="<?php echo $_ENV['APP_URL']; ?>/admin/donors" class="text-decoration-none text-muted"><i class="fa-solid fa-arrow-left"></i> กลับไปหน้าฐานข้อมูลผู้บริจาค</a>
</div>

<div class="row">
    <!-- Profile Card -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-body text-center pt-4">
                <div class="mb-3">
                    <?php if ($donor['donor_type'] == 'ORGANIZATION'): ?>
                        <i class="fa-solid fa-building fa-4x text-secondary"></i>
                    <?php else: ?>
                        <i class="fa-solid fa-user-circle fa-4x text-secondary"></i>
                    <?php endif; ?>
                </div>
                <h4 class="mb-1">
                    <?php if ($donor['donor_type'] == 'ORGANIZATION'): ?>
                        <?php echo htmlspecialchars($donor['company_name']); ?>
                    <?php else: ?>
                        <?php echo htmlspecialchars($donor['prefix'] . $donor['first_name'] . ' ' . $donor['last_name']); ?>
                    <?php endif; ?>
                </h4>
                <div class="text-muted mb-3">รหัส: <span class="badge bg-secondary"><?php echo $donor['donor_code']; ?></span></div>
                
                <div class="mb-3">
                    <?php if ($donor['is_vip']): ?> <span class="badge bg-warning text-dark">VIP</span> <?php endif; ?>
                    <?php if ($donor['is_founding']): ?> <span class="badge bg-info text-dark">ผู้บริจาคก่อตั้ง</span> <?php endif; ?>
                    <?php if ($donor['is_benefactor']): ?> <span class="badge bg-primary">ผู้มีคุณูปการ</span> <?php endif; ?>
                </div>

                <ul class="list-group list-group-flush text-start mt-4">
                    <li class="list-group-item px-0"><i class="fa-solid fa-id-card text-muted me-2"></i> <?php echo htmlspecialchars($donor['tax_id'] ?? '-'); ?></li>
                    <li class="list-group-item px-0"><i class="fa-solid fa-phone text-muted me-2"></i> <?php echo htmlspecialchars($donor['phone'] ?? '-'); ?></li>
                    <li class="list-group-item px-0"><i class="fa-solid fa-envelope text-muted me-2"></i> <?php echo htmlspecialchars($donor['email'] ?? '-'); ?></li>
                    <li class="list-group-item px-0"><i class="fa-solid fa-location-dot text-muted me-2"></i> <?php echo htmlspecialchars($donor['address'] ?? '-'); ?></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Timeline & Stats -->
    <div class="col-md-8">
        <div class="card shadow-sm rounded-4 border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-4 text-primary"><i class="fa-solid fa-chart-line me-2"></i> ประวัติการบริจาค (Timeline)</h5>
                
                <?php if (empty($data['donations'])): ?>
                    <div class="text-center text-muted py-5">
                        <i class="fa-solid fa-box-open fa-3x mb-3"></i>
                        <p>ยังไม่มีประวัติการบริจาค</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>วันที่</th>
                                    <th>เลขที่อ้างอิง</th>
                                    <th>ยอดบริจาค</th>
                                    <th>กองทุน/โครงการ</th>
                                    <th>สถานะ</th>
                                    <th>เลขที่ใบเสร็จ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['donations'] as $donation): ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y', strtotime($donation['donation_date'])); ?></td>
                                        <td><span class="badge bg-light text-dark border"><?php echo $donation['donation_number']; ?></span></td>
                                        <td class="text-success fw-bold text-end"><?php echo number_format($donation['amount'], 2); ?> ฿</td>
                                        <td>
                                            <div class="small"><?php echo htmlspecialchars($donation['fund_name'] ?? '-'); ?></div>
                                            <div class="small text-muted"><?php echo htmlspecialchars($donation['project_name'] ?? ''); ?></div>
                                        </td>
                                        <td>
                                            <?php 
                                            $statusClass = 'bg-secondary';
                                            if ($donation['status'] == 'APPROVED') $statusClass = 'bg-primary';
                                            if ($donation['status'] == 'RECEIPT_ISSUED') $statusClass = 'bg-success';
                                            if ($donation['status'] == 'CANCELLED') $statusClass = 'bg-danger';
                                            ?>
                                            <span class="badge <?php echo $statusClass; ?>"><?php echo $donation['status']; ?></span>
                                        </td>
                                        <td>
                                            <?php if ($donation['receipt_number']): ?>
                                                <a href="#" class="text-decoration-none"><i class="fa-solid fa-file-pdf text-danger"></i> <?php echo $donation['receipt_number']; ?></a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
