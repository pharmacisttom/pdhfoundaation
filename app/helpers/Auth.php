<?php
namespace App\Helpers;

class Auth
{
    public static function check()
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['user_data']);
    }

    public static function user()
    {
        return $_SESSION['user_data'] ?? null;
    }

    public static function hasPermission($permission)
    {
        if (!self::check()) return false;
        // Super admin check (role_id = 1)
        if ($_SESSION['user_data']['role_id'] == 1) return true;
        
        $permissions = $_SESSION['user_permissions'] ?? [];
        return in_array($permission, $permissions);
    }

    public static function requirePermission($permission)
    {
        if (!self::hasPermission($permission)) {
            header('HTTP/1.1 403 Forbidden');
            echo "<h1>403 Forbidden</h1><p>คุณไม่มีสิทธิ์ในการทำรายการนี้</p><a href='" . ($_ENV['APP_URL'] ?? '') . "/admin'>กลับหน้าหลัก</a>";
            exit;
        }
    }
}
