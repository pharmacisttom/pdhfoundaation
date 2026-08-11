<?php
namespace App\Controllers\Admin\Asset;

use App\Core\Controller;
use App\Core\Database;
use App\Helpers\Auth;
use App\Helpers\CSRF;
use PDO;
use Exception;

class AssetController extends Controller
{
    public function __construct()
    {
        Auth::requirePermission('admin');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        $items = $db->query('SELECT * FROM assets ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/asset/index',
            'data' => [
                'page_title' => 'ทะเบียนครุภัณฑ์ (Assets)',
                'items' => $items,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) {
            $this->redirect('/admin/assets');
        }

        $db = Database::getInstance()->getConnection();
        $id = $_POST['id'] ?? null;
        
        $data = [];
        foreach (['asset_code','name','asset_type','price'] as $col) {
            $data[$col] = $_POST[$col] ?? '';
        }

        try {
            $db->beginTransaction();

            if ($id) {
                // Update
                $set = [];
                foreach ($data as $k => $v) {
                    $set[] = "$k = :$k";
                }
                $data['id'] = $id;
                $stmt = $db->prepare('UPDATE assets SET ' . implode(', ', $set) . ' WHERE id = :id');
                $stmt->execute($data);
                $action = 'UPDATE';
            } else {
                // Insert
                $stmt = $db->prepare('INSERT INTO assets (asset_code, name, asset_type, price) VALUES (:asset_code, :name, :asset_type, :price)');
                $stmt->execute($data);
                $id = $db->lastInsertId();
                $action = 'CREATE';
            }

            // Audit
            $db->prepare("INSERT INTO audit_logs (user_id, action, module, record_id, new_data, ip_address) VALUES (?, ?, ?, ?, ?, ?)")
               ->execute([Auth::user()['id'], $action, strtoupper('Asset'), $id, json_encode($data), $_SERVER['REMOTE_ADDR']]);

            $db->commit();
            $_SESSION['success'] = "บันทึกข้อมูลเรียบร้อยแล้ว";
        } catch(Exception $e) {
            $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }
        
        $this->redirect('/admin/assets');
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) $this->redirect('/admin/assets');
        $db = Database::getInstance()->getConnection();
        
        try {
            $db->beginTransaction();
            $id = $_POST['id'];
            $stmt = $db->prepare('DELETE FROM assets WHERE id = :id');
            $stmt->execute(['id' => $id]);

            // Audit
            $db->prepare("INSERT INTO audit_logs (user_id, action, module, record_id, ip_address) VALUES (?, 'DELETE', ?, ?, ?)")
               ->execute([Auth::user()['id'], strtoupper('Asset'), $id, $_SERVER['REMOTE_ADDR']]);
            
            $db->commit();
            $_SESSION['success'] = "ลบข้อมูลเรียบร้อยแล้ว";
        } catch(Exception $e) {
            $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาดในการลบข้อมูล";
        }
        $this->redirect('/admin/assets');
    }
}
