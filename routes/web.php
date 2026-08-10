<?php
use App\Core\Router;

// Web routes definitions

// Public Routes
Router::get('/', ['App\Controllers\HomeController', 'index']);
Router::get('/about', ['App\Controllers\HomeController', 'about']);

// Admin Auth
Router::get('/admin/login', ['App\Controllers\Admin\AuthController', 'showLoginForm']);
Router::post('/admin/login', ['App\Controllers\Admin\AuthController', 'login']);
Router::get('/admin/logout', ['App\Controllers\Admin\AuthController', 'logout']);

// Admin Dashboard
Router::get('/admin/dashboard', ['App\Controllers\Admin\DashboardController', 'index']);

// Admin Settings
Router::get('/admin/settings', ['App\Controllers\Admin\SettingController', 'index']);
Router::post('/admin/settings', ['App\Controllers\Admin\SettingController', 'update']);

// Foundation Profile Management
Router::get('/admin/foundation/profile', ['App\Controllers\Admin\Foundation\ProfileController', 'index']);
Router::post('/admin/foundation/profile', ['App\Controllers\Admin\Foundation\ProfileController', 'update']);

Router::get('/admin/foundation/patrons', ['App\Controllers\Admin\Foundation\PatronController', 'index']);
Router::post('/admin/foundation/patrons/store', ['App\Controllers\Admin\Foundation\PatronController', 'store']);
Router::post('/admin/foundation/patrons/update', ['App\Controllers\Admin\Foundation\PatronController', 'update']);
Router::post('/admin/foundation/patrons/delete', ['App\Controllers\Admin\Foundation\PatronController', 'delete']);
Router::post('/admin/foundation/patrons/sort', ['App\Controllers\Admin\Foundation\PatronController', 'updateSort']);
Router::post('/admin/foundation/patrons/toggle', ['App\Controllers\Admin\Foundation\PatronController', 'togglePublish']);

// Donation Engine (Phase 2)
Router::get('/admin/donors', ['App\Controllers\Admin\Donation\DonorController', 'index']);
Router::get('/admin/donors/profile', ['App\Controllers\Admin\Donation\DonorController', 'profile']); // ?id=...

Router::get('/admin/donations', ['App\Controllers\Admin\Donation\DonationController', 'index']);
Router::post('/admin/donations/store', ['App\Controllers\Admin\Donation\DonationController', 'store']);
Router::post('/admin/donations/verify', ['App\Controllers\Admin\Donation\DonationController', 'verify']);
Router::post('/admin/donations/approve', ['App\Controllers\Admin\Donation\DonationController', 'approve']);

Router::get('/admin/receipts', ['App\Controllers\Admin\Donation\ReceiptController', 'index']);
Router::post('/admin/receipts/generate', ['App\Controllers\Admin\Donation\ReceiptController', 'generate']);
Router::post('/admin/receipts/cancel', ['App\Controllers\Admin\Donation\ReceiptController', 'cancel']);
Router::get('/admin/receipts/print', ['App\Controllers\Admin\Donation\ReceiptController', 'printPdf']); // ?id=...

// Public Verify Endpoint
Router::get('/verify', ['App\Controllers\VerifyController', 'index']);
