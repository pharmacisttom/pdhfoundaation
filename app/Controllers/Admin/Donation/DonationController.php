<?php
namespace App\Controllers\Admin\Donation;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use App\Services\DocumentService;
use PDO;

class DonationController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('donation.view');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->query("
            SELECT dn.*, d.donor_code, d.first_name, d.last_name, d.company_name, d.donor_type, f.name as fund_name
            FROM donations dn 
            LEFT JOIN donors d ON dn.donor_id = d.id 
            LEFT JOIN funds f ON dn.fund_id = f.id
            ORDER BY dn.id DESC
        ");
        $donations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch master data for modal
        $donors = $db->query("SELECT id, donor_code, donor_type, first_name, last_name, company_name FROM donors ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
        $funds = $db->query("SELECT id, name FROM funds WHERE is_active = 1")->fetchAll(PDO::FETCH_ASSOC);
        $projects = $db->query("SELECT id, name FROM projects WHERE is_active = 1")->fetchAll(PDO::FETCH_ASSOC);
        $banks = $db->query("SELECT id, bank_name, account_name, account_number FROM bank_accounts WHERE is_active = 1")->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/donation/donations/index',
            'data' => [
                'page_title' => 'รายการรับบริจาค (Donations)',
                'donations' => $donations,
                'donors' => $donors,
                'funds' => $funds,
                'projects' => $projects,
                'banks' => $banks,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function store()
    {
        AuthMiddleware::requirePermission('donation.create');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/donations');
        
        try {
            $db = Database::getInstance()->getConnection();
            $db->beginTransaction();

            $donationNumber = DocumentService::generateNumber('DON-');

            $stmt = $db->prepare("INSERT INTO donations 
                (donation_number, donation_date, donor_id, amount, payment_method, bank_account_id, fund_id, project_id, purpose, note, status, created_by) 
                VALUES (:dn, :dd, :di, :amt, :pm, :ba, :fi, :pi, :purp, :note, 'DRAFT', :cb)");
            
            $stmt->execute([
                'dn' => $donationNumber,
                'dd' => $_POST['donation_date'],
                'di' => $_POST['donor_id'],
                'amt' => $_POST['amount'],
                'pm' => $_POST['payment_method'],
                'ba' => !empty($_POST['bank_account_id']) ? $_POST['bank_account_id'] : null,
                'fi' => !empty($_POST['fund_id']) ? $_POST['fund_id'] : null,
                'pi' => !empty($_POST['project_id']) ? $_POST['project_id'] : null,
                'purp' => $_POST['purpose'] ?? null,
                'note' => $_POST['note'] ?? null,
                'cb' => \App\Helpers\Auth::user()['id']
            ]);

            // Handle slip upload
            $donationId = $db->lastInsertId();
            if (isset($_FILES['slip_file']) && $_FILES['slip_file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = ROOT_PATH . '/public/uploads/slips/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                
                $ext = strtolower(pathinfo($_FILES['slip_file']['name'], PATHINFO_EXTENSION));
                $filename = 'slip_' . $donationNumber . '.' . $ext;
                if (move_uploaded_file($_FILES['slip_file']['tmp_name'], $uploadDir . $filename)) {
                    $db->prepare("UPDATE donations SET slip_file = ? WHERE id = ?")->execute([$filename, $donationId]);
                }
            }

            $db->commit();
            $_SESSION['success'] = "บันทึกข้อมูลการรับบริจาคสำเร็จ เลขที่: " . $donationNumber;

        } catch (\Exception $e) {
            if ($db->inTransaction()) $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }

        $this->redirect('/admin/donations');
    }

    public function verify()
    {
        AuthMiddleware::requirePermission('donation.verify');
        $this->updateStatus('VERIFIED', "ตรวจสอบความถูกต้องเรียบร้อยแล้ว");
    }

    public function approve()
    {
        AuthMiddleware::requirePermission('donation.approve');
        $this->updateStatus('APPROVED', "อนุมัติรายการเรียบร้อยแล้ว");
    }

    private function updateStatus($newStatus, $successMessage)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/donations');
        
        try {
            $id = $_POST['id'];
            $db = Database::getInstance()->getConnection();
            $db->beginTransaction();

            // Verify current state before changing
            $stmt = $db->prepare("SELECT status FROM donations WHERE id = :id FOR UPDATE");
            $stmt->execute(['id' => $id]);
            $current = $stmt->fetchColumn();

            if (!$current) throw new \Exception("ไม่พบรายการบริจาค");
            if ($current == 'CANCELLED') throw new \Exception("รายการนี้ถูกยกเลิกไปแล้ว");

            $update = $db->prepare("UPDATE donations SET status = :status, updated_by = :uid WHERE id = :id");
            $update->execute([
                'status' => $newStatus,
                'uid' => \App\Helpers\Auth::user()['id'],
                'id' => $id
            ]);

            // Log to audit (simplified)
            $db->prepare("INSERT INTO audit_logs (user_id, action, table_name, record_id, new_data) VALUES (?, ?, ?, ?, ?)")
               ->execute([\App\Helpers\Auth::user()['id'], 'STATUS_CHANGE', 'donations', $id, json_encode(['status' => $newStatus])]);

            $db->commit();
            $_SESSION['success'] = $successMessage;

        } catch (\Exception $e) {
            if (isset($db) && $db->inTransaction()) $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }

        $this->redirect('/admin/donations');
    }
}
