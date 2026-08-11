<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-book-journal-whills text-primary me-2"></i> <?php echo $data['page_title']; ?></h4>
    <div>
        <a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/expenses/create" class="btn btn-danger rounded-pill px-4 shadow-sm me-2">
            <i class="fa-solid fa-minus-circle me-1"></i> จ่ายเงิน/เบิกจ่าย
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4 bg-light rounded-4">
        <form method="GET" action="<?php echo $_ENV['APP_URL']; ?>/admin/finance/ledger" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-muted small fw-bold">กรองตามกองทุน</label>
                <select name="fund_id" class="form-select" onchange="this.form.submit()">
                    <option value="">ทั้งหมด (All Funds)</option>
                    <?php foreach ($data['funds'] as $f): ?>
                        <option value="<?php echo $f['id']; ?>" <?php echo $data['current_fund_id'] == $f['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($f['name']); ?> (คงเหลือ: <?php echo number_format($f['current_balance'], 2); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table class="table table-hover align-middle" id="dataTable">
            <thead class="table-light">
                <tr>
                    <th>วันที่/เวลา</th>
                    <th>อ้างอิงประเภท</th>
                    <th>กองทุน</th>
                    <th class="text-end text-success">ยอดเข้า (Credit)</th>
                    <th class="text-end text-danger">ยอดออก (Debit)</th>
                    <th class="text-end">ยอดคงเหลือ (Balance)</th>
                    <th>หมายเหตุ</th>
                    <th>ผู้ทำรายการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['transactions'] as $item): ?>
                <tr>
                    <td><?php echo date('d/m/Y H:i', strtotime($item['transaction_date'])); ?></td>
                    <td>
                        <?php 
                        $badge = 'secondary';
                        if($item['reference_type'] == 'DONATION') $badge = 'success';
                        if($item['reference_type'] == 'EXPENSE') $badge = 'danger';
                        if($item['reference_type'] == 'OPENING') $badge = 'primary';
                        if($item['reference_type'] == 'VOID') $badge = 'dark';
                        ?>
                        <span class="badge bg-<?php echo $badge; ?> rounded-pill px-3"><?php echo $item['reference_type']; ?></span>
                    </td>
                    <td><?php echo htmlspecialchars($item['fund_name']); ?></td>
                    <td class="text-end text-success fw-bold"><?php echo $item['credit'] > 0 ? '+'.number_format($item['credit'], 2) : '-'; ?></td>
                    <td class="text-end text-danger fw-bold"><?php echo $item['debit'] > 0 ? '-'.number_format($item['debit'], 2) : '-'; ?></td>
                    <td class="text-end fw-bold"><?php echo number_format($item['running_balance'], 2); ?></td>
                    <td class="text-muted small"><?php echo htmlspecialchars($item['note'] ?? ''); ?></td>
                    <td class="small"><i class="fa-solid fa-user-circle text-muted"></i> <?php echo htmlspecialchars($item['creator_name'] ?? 'System'); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data['transactions'])): ?>
                <tr><td colspan="8" class="text-center py-4 text-muted">ยังไม่มีรายการเคลื่อนไหวในสมุดบัญชี</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if($.fn.DataTable) {
        $('#dataTable').DataTable({
            "order": [], // Keep server ordering
            "language": { "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json" },
            "pageLength": 50
        });
    }
});
</script>
