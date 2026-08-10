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
$dotenv->load();

// Start Session securely
session_set_cookie_params([
    'lifetime' => $_ENV['SESSION_LIFETIME'] * 60,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

// Initialize App
$app = new App\Core\App();
$app->run();
