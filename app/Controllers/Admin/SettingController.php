<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

class SettingController extends Controller
{
    public function __construct()
    {
        // Require specific permission
        AuthMiddleware::requirePermission('setting.manage');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM system_settings");
        $settingsRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $settings = [];
        foreach ($settingsRaw as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/settings',
            'data' => [
                'page_title' => 'ตั้งค่าระบบ',
                'settings' => $settings,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/settings');
        }

        $db = Database::getInstance()->getConnection();
        
        try {
            $db->beginTransaction();
            
            $stmt = $db->prepare("UPDATE system_settings SET setting_value = :val WHERE setting_key = :key");
            
            foreach ($_POST as $key => $value) {
                // Ignore CSRF or other non-setting fields
                if (in_array($key, ['csrf_token'])) continue;
                
                $stmt->execute(['val' => $value, 'key' => $key]);
            }
            
            // Log action
            $log = $db->prepare("INSERT INTO audit_logs (user_id, module, action, ip_address) VALUES (:uid, 'SETTINGS', 'UPDATE', :ip)");
            $log->execute([
                'uid' => \App\Helpers\Auth::user()['id'],
                'ip' => $_SERVER['REMOTE_ADDR'] ?? null
            ]);
            
            $db->commit();
            $_SESSION['success'] = "บันทึกการตั้งค่าสำเร็จ";
        } catch (\Exception $e) {
            $db->rollBack();
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }

        $this->redirect('/admin/settings');
    }
}
