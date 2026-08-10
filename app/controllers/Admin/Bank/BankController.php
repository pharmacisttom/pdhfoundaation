<?php
namespace App\Controllers\Admin\Bank;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

class BankController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('bank.view'); // Change based on RBAC logic
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->query("SELECT * FROM bank_accounts ORDER BY id DESC");
        $banks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/bank/index',
            'data' => [
                'page_title' => 'จัดการบัญชีธนาคาร (Bank Management)',
                'banks' => $banks,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function store()
    {
        AuthMiddleware::requirePermission('bank.create');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/banks');
        
        try {
            $db = Database::getInstance()->getConnection();
            $db->beginTransaction();

            $stmt = $db->prepare("INSERT INTO bank_accounts (bank_name, branch, account_name, account_number, account_type, current_balance, status) 
                                  VALUES (:bank, :branch, :name, :acc_num, :type, :bal, :status)");
            
            $stmt->execute([
                'bank' => $_POST['bank_name'],
                'branch' => $_POST['branch'] ?? null,
                'name' => $_POST['account_name'],
                'acc_num' => $_POST['account_number'],
                'type' => $_POST['account_type'] ?? 'ออมทรัพย์',
                'bal' => $_POST['current_balance'] ?? 0,
                'status' => $_POST['status'] ?? 'ACTIVE'
            ]);

            $bankId = $db->lastInsertId();

            // Inject initial balance transaction if > 0
            if ($_POST['current_balance'] > 0) {
                $trx = $db->prepare("INSERT INTO bank_transactions (bank_account_id, transaction_date, transaction_type, amount, balance_after, note, created_by) 
                                     VALUES (?, NOW(), 'DEPOSIT', ?, ?, 'ยอดยกมาเริ่มต้น', ?)");
                $trx->execute([
                    $bankId, 
                    $_POST['current_balance'], 
                    $_POST['current_balance'],
                    \App\Helpers\Auth::user()['id']
                ]);
            }

            $db->commit();
            $_SESSION['success'] = "เพิ่มบัญชีธนาคารเรียบร้อยแล้ว";

        } catch (\Exception $e) {
            if (isset($db) && $db->inTransaction()) $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }

        $this->redirect('/admin/banks');
    }
}
