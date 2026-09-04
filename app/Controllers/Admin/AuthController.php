<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Helpers\Auth;
use App\Helpers\CSRF;
use PDO;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $this->redirect('/admin/dashboard');
        }
        
        // Generate CSRF token
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $this->view('admin/layouts/login', [
            'error' => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['error']);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/login');
        }

        // Validate CSRF
        if (!CSRF::verify($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = "Invalid form submission.";
            $this->redirect('/admin/login');
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "กรุณากรอกชื่อผู้ใช้และรหัสผ่าน";
            $this->redirect('/admin/login');
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.username = :username AND u.status = 'ACTIVE'");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Update last login
            $update = $db->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
            $update->execute(['id' => $user['id']]);

            // Load permissions
            $permStmt = $db->prepare("SELECT p.name FROM permissions p JOIN role_permissions rp ON p.id = rp.permission_id WHERE rp.role_id = :role_id");
            $permStmt->execute(['role_id' => $user['role_id']]);
            $permissions = $permStmt->fetchAll(PDO::FETCH_COLUMN);

            // Set session securely
            session_regenerate_id(true); // Prevent session fixation
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_data'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'role_id' => $user['role_id'],
                'role_name' => $user['role_name']
            ];
            $_SESSION['user_permissions'] = $permissions;

            // Audit log
            $log = $db->prepare("INSERT INTO audit_logs (user_id, module, action, ip_address, user_agent) VALUES (:uid, 'AUTH', 'LOGIN', :ip, :ua)");
            $log->execute([
                'uid' => $user['id'],
                'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
                'ua' => $_SERVER['HTTP_USER_AGENT'] ?? null
            ]);

            $this->redirect('/admin/dashboard');
        } else {
            $_SESSION['error'] = "ชื่อผู้ใช้ หรือรหัสผ่านไม่ถูกต้อง";
            $this->redirect('/admin/login');
        }
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin/login');
        }

        if (Auth::check()) {
            $db = Database::getInstance()->getConnection();
            $log = $db->prepare("INSERT INTO audit_logs (user_id, module, action, ip_address, user_agent) VALUES (:uid, 'AUTH', 'LOGOUT', :ip, :ua)");
            $log->execute([
                'uid' => $_SESSION['user_id'],
                'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
                'ua' => $_SERVER['HTTP_USER_AGENT'] ?? null
            ]);
        }

        session_unset();
        session_destroy();
        $this->redirect('/admin/login');
    }
}
