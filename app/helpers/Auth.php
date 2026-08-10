<?php
namespace App\Helpers;

class Auth
{
    public static function check()
    {
        return isset($_SESSION['user_id']);
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
}
