<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fa-solid fa-money-bill-wave text-danger me-2"></i> <?php echo $data['page_title']; ?></h4>
    <a href="<?php echo $_ENV['APP_URL']; ?>/admin/finance/expenses/create" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="fa-solid fa-plus me-1"></i> ทำรายการขอเบิกจ่ายใหม่
    </a>
</div>

<?php if (!empty($data['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $data['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <table class="table table-hover align-middle" id="dataTable">
            <thead class="table-light">
                <tr>
                    <th>เลขที่เอกสาร</th>
                    <th>วันที่เบิกจ่าย</th>
                    <th>กองทุน</th>
                    <th>ผู้ขอเบิก</th>
                    <th class="text-end">ยอดเงินรวม</th>
                    <th class="text-center">สถานะ</th>
                    <th class="text-end">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['expenses'] as $item): ?>
                <tr>
                    <td class="fw-bold text-primary"><?php echo htmlspecialchars($item['expense_number']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($item['expense_date'])); ?></td>
                    <td><?php echo htmlspecialchars($item['fund_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['requester_name']); ?></td>
                    <td class="text-end fw-bold text-danger"><?php echo number_format($item['total_amount'], 2); ?></td>
                    <td class="text-center">
                        <?php 
                        $badge = 'secondary';
                        if($item['status'] == 'SUBMITTED') $badge = 'warning text-dark';
                        if($item['status'] == 'APPROVED' || $item['status'] == 'PAID') $badge = 'success';
                        if($item['status'] == 'REJECTED' || $item['status'] == 'VOIDED') $badge = 'danger';
                        ?>
                        <span class="badge bg-<?php echo $badge; ?> rounded-pill px-3"><?php echo $item['status']; ?></span>
                    </td>
                    <td class="text-end">
                        <?php if($item['status'] == 'SUBMITTED'): ?>
                        <form action="<?php echo $_ENV['APP_URL']; ?>/admin/finance/expenses/approve" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการอนุมัติจ่ายเงินและหักยอดเงินจากกองทุน?');">
                            <?php echo \App\Helpers\CSRF::field(); ?>
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3"><i class="fa-solid fa-check me-1"></i> อนุมัติ</button>
                        </form>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-light border"><i class="fa-solid fa-eye text-primary"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data['expenses'])): ?>
                <tr><td colspan="7" class="text-center py-4 text-muted">ไม่พบข้อมูลการเบิกจ่าย</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if($.fn.DataTable) {
        $('#dataTable').DataTable({
            "order": [],
            "language": { "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json" }
        });
    }
});
</script>
