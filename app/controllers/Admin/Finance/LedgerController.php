<?php
namespace App\Controllers\Admin\Finance;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

class LedgerController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('admin');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        
        $fundFilter = $_GET['fund_id'] ?? '';
        
        $sql = "
            SELECT t.*, f.name as fund_name, u.fullname as creator_name 
            FROM fund_transactions t
            JOIN funds f ON t.fund_id = f.id
            LEFT JOIN users u ON t.created_by = u.id
            WHERE 1=1
        ";
        
        $params = [];
        if (!empty($fundFilter)) {
            $sql .= " AND t.fund_id = :fund_id";
            $params['fund_id'] = $fundFilter;
        }
        
        $sql .= " ORDER BY t.transaction_date DESC, t.id DESC LIMIT 500";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $funds = $db->query("SELECT id, name, current_balance FROM funds")->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/finance/ledger/index',
            'data' => [
                'page_title' => 'สมุดบัญชีแยกประเภท (Master Ledger)',
                'transactions' => $transactions,
                'funds' => $funds,
                'current_fund_id' => $fundFilter
            ]
        ]);
    }
}
