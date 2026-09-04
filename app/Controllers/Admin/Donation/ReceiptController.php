<?php
namespace App\Controllers\Admin\Donation;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use App\Services\DocumentService;
use PDO;

class ReceiptController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('receipt.view');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->query("
            SELECT r.*, dn.donation_number, dn.amount, dn.donation_date, 
                   d.donor_code, d.donor_type, d.first_name, d.last_name, d.company_name
            FROM receipts r
            JOIN donations dn ON r.donation_id = dn.id
            JOIN donors d ON dn.donor_id = d.id
            ORDER BY r.id DESC
        ");
        $receipts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/donation/receipts/index',
            'data' => [
                'page_title' => 'จัดการใบเสร็จรับเงิน (Receipts)',
                'receipts' => $receipts,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function generate()
    {
        AuthMiddleware::requirePermission('receipt.create');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/donations');
        
        try {
            $donationId = $_POST['donation_id'];
            $db = Database::getInstance()->getConnection();
            $db->beginTransaction();

            // Verify donation status
            $stmt = $db->prepare("SELECT status FROM donations WHERE id = :id FOR UPDATE");
            $stmt->execute(['id' => $donationId]);
            $status = $stmt->fetchColumn();

            if ($status !== 'APPROVED') {
                throw new \Exception("ไม่สามารถออกใบเสร็จได้ รายการนี้ยังไม่ได้รับการอนุมัติ");
            }

            // Generate RC number
            $receiptNumber = DocumentService::generateNumber('RC-');

            // Insert receipt
            $insert = $db->prepare("INSERT INTO receipts (receipt_number, donation_id, created_by) VALUES (?, ?, ?)");
            $insert->execute([$receiptNumber, $donationId, \App\Helpers\Auth::user()['id']]);

            // Update donation status
            $update = $db->prepare("UPDATE donations SET status = 'RECEIPT_ISSUED', updated_by = ? WHERE id = ?");
            $update->execute([\App\Helpers\Auth::user()['id'], $donationId]);

            // Log
            $db->prepare("INSERT INTO audit_logs (user_id, action, table_name, record_id, new_data) VALUES (?, ?, ?, ?, ?)")
               ->execute([\App\Helpers\Auth::user()['id'], 'GENERATE_RECEIPT', 'receipts', $db->lastInsertId(), json_encode(['receipt_number' => $receiptNumber])]);

            $db->commit();
            $_SESSION['success'] = "ออกใบเสร็จเลขที่ {$receiptNumber} สำเร็จ";

        } catch (\Exception $e) {
            if (isset($db) && $db->inTransaction()) $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }

        $this->redirect('/admin/receipts');
    }

    public function cancel()
    {
        AuthMiddleware::requirePermission('receipt.cancel');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/receipts');
        
        try {
            $receiptId = $_POST['receipt_id'];
            $reason = $_POST['cancel_reason'];
            
            $db = Database::getInstance()->getConnection();
            $db->beginTransaction();

            $stmt = $db->prepare("SELECT donation_id, is_cancelled FROM receipts WHERE id = :id FOR UPDATE");
            $stmt->execute(['id' => $receiptId]);
            $receipt = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$receipt || $receipt['is_cancelled']) {
                throw new \Exception("ใบเสร็จนี้ถูกยกเลิกไปแล้ว หรือไม่พบข้อมูล");
            }

            // Mark as cancelled
            $update = $db->prepare("UPDATE receipts SET is_cancelled = 1, cancelled_at = NOW(), cancel_reason = ?, cancelled_by = ? WHERE id = ?");
            $update->execute([$reason, \App\Helpers\Auth::user()['id'], $receiptId]);

            // Revert donation status to APPROVED so a new receipt can be generated if needed, OR Cancelled entirely?
            // Usually we revert to APPROVED to allow issuing a replacement receipt.
            $updateDn = $db->prepare("UPDATE donations SET status = 'APPROVED' WHERE id = ?");
            $updateDn->execute([$receipt['donation_id']]);

            $db->commit();
            $_SESSION['success'] = "ยกเลิกใบเสร็จเรียบร้อยแล้ว";

        } catch (\Exception $e) {
            if (isset($db) && $db->inTransaction()) $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }

        $this->redirect('/admin/receipts');
    }

    public function printPdf()
    {
        if (!isset($_GET['id'])) $this->redirect('/admin/receipts');
        
        $id = $_GET['id'];
        $db = Database::getInstance()->getConnection();
        
        // Log the print action
        $stmt = $db->prepare("INSERT INTO receipt_print_logs (receipt_id, printed_by, ip_address) VALUES (?, ?, ?)");
        $stmt->execute([$id, \App\Helpers\Auth::user()['id'], $_SERVER['REMOTE_ADDR']]);
        
        // Update print count
        $db->prepare("UPDATE receipts SET print_count = print_count + 1, printed_at = NOW(), printed_by = ? WHERE id = ?")
           ->execute([\App\Helpers\Auth::user()['id'], $id]);

        // Output basic PDF (Placeholder until mPDF full Thai setup is completed)
        echo "<h1>PDF Placeholder for Receipt ID: {$id}</h1>";
        echo "<p>mPDF and QR Code rendering will be implemented here.</p>";
        echo "<script>window.print();</script>";
    }
}
