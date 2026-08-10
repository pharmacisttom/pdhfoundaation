<?php
namespace App\Controllers\Admin\Finance;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

class FundController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('setting.manage'); // Adjust permission as needed
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->query("SELECT * FROM funds ORDER BY id DESC");
        $funds = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/finance/funds/index',
            'data' => [
                'page_title' => 'จัดการกองทุน (Fund Management)',
                'funds' => $funds,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/finance/funds');
        
        try {
            $db = Database::getInstance()->getConnection();
            $db->beginTransaction();

            $stmt = $db->prepare("INSERT INTO funds (fund_code, name, description, opening_balance, current_balance, status) 
                                  VALUES (:code, :name, :desc, :bal, :bal, :status)");
            
            $stmt->execute([
                'code' => $_POST['fund_code'],
                'name' => $_POST['name'],
                'desc' => $_POST['description'] ?? null,
                'bal' => $_POST['opening_balance'] ?? 0,
                'status' => $_POST['status'] ?? 'OPEN'
            ]);

            $fundId = $db->lastInsertId();

            // If there's an opening balance > 0, inject an opening transaction to the ledger
            if ($_POST['opening_balance'] > 0) {
                $trx = $db->prepare("INSERT INTO fund_transactions (fund_id, transaction_date, credit, reference_type, reference_id, running_balance, note, created_by) 
                                     VALUES (?, NOW(), ?, 'OPENING', ?, ?, 'ยอดยกมาเริ่มต้น', ?)");
                $trx->execute([
                    $fundId, 
                    $_POST['opening_balance'], 
                    $fundId, 
                    $_POST['opening_balance'],
                    \App\Helpers\Auth::user()['id']
                ]);
            }

            $db->commit();
            $_SESSION['success'] = "เพิ่มกองทุนใหม่เรียบร้อยแล้ว";

        } catch (\Exception $e) {
            if (isset($db) && $db->inTransaction()) $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }

        $this->redirect('/admin/finance/funds');
    }
}
