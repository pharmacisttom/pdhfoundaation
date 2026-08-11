<?php
namespace App\Controllers\Admin\Finance;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use App\Helpers\CSRF;
use App\Helpers\Auth;
use PDO;
use Exception;

class ExpenseController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('admin');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        
        $sql = "
            SELECT e.*, f.name as fund_name, p.project_name, u.fullname as requester_name 
            FROM expenses e
            JOIN funds f ON e.fund_id = f.id
            LEFT JOIN projects p ON e.project_id = p.id
            LEFT JOIN users u ON e.requester_id = u.id
            ORDER BY e.id DESC
        ";
        
        $expenses = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/finance/expenses/index',
            'data' => [
                'page_title' => 'บันทึกรายจ่าย (Expenses)',
                'expenses' => $expenses,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function create()
    {
        $db = Database::getInstance()->getConnection();
        $funds = $db->query("SELECT id, name FROM funds WHERE status = 'OPEN'")->fetchAll(PDO::FETCH_ASSOC);
        $projects = $db->query("SELECT id, project_name FROM projects WHERE status = 'ACTIVE'")->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/finance/expenses/create',
            'data' => [
                'page_title' => 'สร้างรายการเบิกจ่ายใหม่',
                'funds' => $funds,
                'projects' => $projects,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['error']);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) {
            $this->redirect('/admin/finance/expenses');
        }

        $db = Database::getInstance()->getConnection();
        
        try {
            $db->beginTransaction();

            $expense_number = 'EXP-' . date('Ymd') . '-' . rand(1000, 9999);
            
            // Insert Master
            $stmt = $db->prepare("INSERT INTO expenses (expense_number, expense_date, requester_id, fund_id, project_id, vendor, total_amount, note, status, created_by) 
                                  VALUES (:num, :date, :req, :fund, :proj, :ven, :total, :note, 'SUBMITTED', :uid)");
            
            $stmt->execute([
                'num' => $expense_number,
                'date' => $_POST['expense_date'],
                'req' => Auth::user()['id'],
                'fund' => $_POST['fund_id'],
                'proj' => !empty($_POST['project_id']) ? $_POST['project_id'] : null,
                'ven' => $_POST['vendor'] ?? null,
                'total' => $_POST['total_amount'],
                'note' => $_POST['note'] ?? null,
                'uid' => Auth::user()['id']
            ]);
            
            $expenseId = $db->lastInsertId();

            // Insert Approval workflow log
            $wf = $db->prepare("INSERT INTO expense_approvals (expense_id, approver_id, role_at_time, action, comment) VALUES (?, ?, ?, 'SUBMITTED', ?)");
            $wf->execute([$expenseId, Auth::user()['id'], 'Requester', 'Submitted for approval']);

            // Insert Audit Log
            $audit = $db->prepare("INSERT INTO audit_logs (user_id, action, module, record_id, new_data, ip_address) VALUES (?, 'CREATE', 'EXPENSES', ?, ?, ?)");
            $audit->execute([Auth::user()['id'], $expenseId, json_encode(['expense_number' => $expense_number, 'amount' => $_POST['total_amount']]), $_SERVER['REMOTE_ADDR']]);

            $db->commit();
            $_SESSION['success'] = "บันทึกขอเบิกจ่ายเรียบร้อย รอการอนุมัติ";
            
        } catch (Exception $e) {
            $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
            $this->redirect('/admin/finance/expenses/create');
        }

        $this->redirect('/admin/finance/expenses');
    }

    public function approve()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) $this->redirect('/admin/finance/expenses');
        $db = Database::getInstance()->getConnection();
        
        try {
            $db->beginTransaction();
            $id = $_POST['id'];
            $expense = $db->query("SELECT * FROM expenses WHERE id = $id AND status = 'SUBMITTED' FOR UPDATE")->fetch(PDO::FETCH_ASSOC);
            if(!$expense) throw new Exception("ไม่สามารถอนุมัติรายการนี้ได้");

            // Update Expense
            $stmt = $db->prepare("UPDATE expenses SET status = 'APPROVED' WHERE id = ?");
            $stmt->execute([$id]);

            // Deduct Fund Balance
            $fund = $db->query("SELECT current_balance FROM funds WHERE id = {$expense['fund_id']} FOR UPDATE")->fetch(PDO::FETCH_ASSOC);
            $newBal = $fund['current_balance'] - $expense['total_amount'];
            $db->prepare("UPDATE funds SET current_balance = ? WHERE id = ?")->execute([$newBal, $expense['fund_id']]);

            // Insert Ledger
            $trx = $db->prepare("INSERT INTO fund_transactions (fund_id, transaction_date, debit, reference_type, reference_id, running_balance, note, created_by) VALUES (?, NOW(), ?, 'EXPENSE', ?, ?, ?, ?)");
            $trx->execute([$expense['fund_id'], $expense['total_amount'], $id, $newBal, "จ่าย: ".$expense['note'], Auth::user()['id']]);

            // Approval Log & Audit Log
            $db->prepare("INSERT INTO expense_approvals (expense_id, approver_id, action, comment) VALUES (?, ?, 'APPROVED', 'Approved by Admin')")->execute([$id, Auth::user()['id']]);
            $db->prepare("INSERT INTO audit_logs (user_id, action, module, record_id, ip_address) VALUES (?, 'UPDATE', 'EXPENSES', ?, ?)")->execute([Auth::user()['id'], $id, $_SERVER['REMOTE_ADDR']]);

            $db->commit();
            $_SESSION['success'] = "อนุมัติรายการเบิกจ่ายเรียบร้อยแล้ว";
        } catch(Exception $e) {
            $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
        $this->redirect('/admin/finance/expenses');
    }

    public function void()
    {
        // ... (Similar logic for voiding, reverting balances, etc.)
        $this->redirect('/admin/finance/expenses');
    }
}
