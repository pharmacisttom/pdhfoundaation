<?php
/**
 * PDH Foundation Management System
 * Entry Point
 */

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

// Autoloader
require_once ROOT_PATH . '/vendor/autoload.php';

// Load Environment Variables
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->safeLoad();

$appDebug = filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOL);
$sessionLifetime = max(1, (int) ($_ENV['SESSION_LIFETIME'] ?? 120));
$logPath = ROOT_PATH . '/storage/logs';
if (!is_dir($logPath) && !mkdir($logPath, 0770, true) && !is_dir($logPath)) {
    throw new RuntimeException('Unable to create the application log directory.');
}

ini_set('display_errors', $appDebug ? '1' : '0');
error_reporting(E_ALL);

set_exception_handler(static function (Throwable $exception) use ($appDebug, $logPath): void {
    error_log(sprintf("[%s] %s\n%s\n", date('c'), $exception->getMessage(), $exception->getTraceAsString()), 3, $logPath . '/app.log');

    if (!headers_sent()) {
        http_response_code(500);
    }

    if ($appDebug) {
        echo '<pre>' . htmlspecialchars((string) $exception, ENT_QUOTES, 'UTF-8') . '</pre>';
        return;
    }

    require ROOT_PATH . '/views/errors/500.php';
});

// Start Session securely
$sessionPath = ROOT_PATH . '/storage/sessions';
if (!is_dir($sessionPath) && !mkdir($sessionPath, 0770, true) && !is_dir($sessionPath)) {
    throw new RuntimeException('Unable to create the session storage directory.');
}
session_save_path($sessionPath);

$isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
session_set_cookie_params([
    'lifetime' => $sessionLifetime * 60,
    'path' => '/',
    'domain' => '',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

// Initialize App
$app = new App\Core\App();
$app->run();
