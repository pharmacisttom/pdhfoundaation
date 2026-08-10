<?php
namespace App\Middleware;

use App\Helpers\Auth;
use App\Core\Controller;

class AuthMiddleware extends Controller
{
    public static function handle()
    {
        if (!Auth::check()) {
            header('Location: ' . $_ENV['APP_URL'] . '/admin/login');
            exit;
        }
    }

    public static function requirePermission($permission)
    {
        self::handle(); // Ensure logged in
        if (!Auth::hasPermission($permission)) {
            http_response_code(403);
            require_once APP_PATH . '/../views/errors/403.php';
            exit;
        }
    }
}
