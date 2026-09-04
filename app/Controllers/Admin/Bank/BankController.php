<?php
namespace App\Controllers\Admin\Bank;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use App\Helpers\CSRF;
use App\Helpers\Auth;
use PDO;
use Exception;

class BankController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('admin');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        
        $banks = $db->query("SELECT * FROM bank_accounts ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/bank/index',
            'data' => [
                'page_title' => 'จัดการบัญชีธนาคาร (Bank Accounts)',
                'banks' => $banks,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) $this->redirect('/admin/banks');
        
        $db = Database::getInstance()->getConnection();
        $id = $_POST['id'] ?? null;
        
        try {
            $db->beginTransaction();

            $data = [
                'bank_name' => $_POST['bank_name'],
                'branch' => $_POST['branch'] ?? null,
                'account_name' => $_POST['account_name'],
                'account_number' => $_POST['account_number'],
                'account_type' => $_POST['account_type'] ?? null,
                'status' => $_POST['status'] ?? 'ACTIVE'
            ];

            // Secure File Upload for QR Code
            if (isset($_FILES['qr_code_file']) && $_FILES['qr_code_file']['error'] === UPLOAD_ERR_OK) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $filename = $_FILES['qr_code_file']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                if (in_array($ext, $allowed) && $_FILES['qr_code_file']['size'] < 2097152) { // Max 2MB
                    $newName = uniqid('qr_') . '.' . $ext;
                    $dest = ROOT_PATH . '/public/uploads/banks/' . $newName;
                    if (!is_dir(ROOT_PATH . '/public/uploads/banks/')) mkdir(ROOT_PATH . '/public/uploads/banks/', 0775, true);
                    if (move_uploaded_file($_FILES['qr_code_file']['tmp_name'], $dest)) {
                        $data['qr_code_file'] = '/uploads/banks/' . $newName;
                    }
                } else {
                    throw new Exception("ไฟล์ QR Code ไม่ถูกต้อง หรือขนาดใหญ่เกินไป (สูงสุด 2MB)");
                }
            }

            if ($id) {
                $setParts = [];
                $params = [];
                foreach ($data as $key => $val) {
                    $setParts[] = "$key = :$key";
                    $params[$key] = $val;
                }
                $params['id'] = $id;
                $stmt = $db->prepare("UPDATE bank_accounts SET " . implode(', ', $setParts) . " WHERE id = :id");
                $stmt->execute($params);
                $action = 'UPDATE';
            } else {
                $cols = array_keys($data);
                $binds = array_map(function($c) { return ":$c"; }, $cols);
                $stmt = $db->prepare("INSERT INTO bank_accounts (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $binds) . ")");
                $stmt->execute($data);
                $id = $db->lastInsertId();
                $action = 'CREATE';
            }

            // Audit
            $db->prepare("INSERT INTO audit_logs (user_id, action, module, record_id, new_data, ip_address) VALUES (?, ?, 'BANKS', ?, ?, ?)")
               ->execute([Auth::user()['id'], $action, $id, json_encode($data), $_SERVER['REMOTE_ADDR']]);

            $db->commit();
            $_SESSION['success'] = "บันทึกข้อมูลบัญชีธนาคารเรียบร้อยแล้ว";
        } catch(Exception $e) {
            $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
        
        $this->redirect('/admin/banks');
    }
}
