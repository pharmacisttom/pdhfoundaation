<?php
use App\Core\Router;

// Web routes definitions

// Public Routes
Router::get('/', ['App\Controllers\Public\HomeController', 'index']);
Router::get('/about', ['App\Controllers\Public\HomeController', 'about']);

// Admin Auth
Router::get('/admin/login', ['App\Controllers\Admin\AuthController', 'showLoginForm']);
Router::post('/admin/login', ['App\Controllers\Admin\AuthController', 'login']);
Router::post('/admin/logout', ['App\Controllers\Admin\AuthController', 'logout']);

// Admin Dashboard
Router::get('/admin/dashboard', ['App\Controllers\Admin\DashboardController', 'index']);

// Admin Settings
Router::get('/admin/settings', ['App\Controllers\Admin\SettingController', 'index']);
Router::post('/admin/settings', ['App\Controllers\Admin\SettingController', 'update']);

// Foundation Profile Management
Router::get('/admin/foundation/profile', ['App\Controllers\Admin\Foundation\ProfileController', 'index']);
Router::post('/admin/foundation/profile', ['App\Controllers\Admin\Foundation\ProfileController', 'update']);

Router::get('/admin/foundation/history', ['App\Controllers\Admin\Foundation\HistoryController', 'index']);
Router::post('/admin/foundation/history/store', ['App\Controllers\Admin\Foundation\HistoryController', 'store']);
Router::post('/admin/foundation/history/delete', ['App\Controllers\Admin\Foundation\HistoryController', 'delete']);

Router::get('/admin/foundation/board', ['App\Controllers\Admin\Foundation\BoardController', 'index']);
Router::post('/admin/foundation/board/store', ['App\Controllers\Admin\Foundation\BoardController', 'store']);
Router::post('/admin/foundation/board/delete', ['App\Controllers\Admin\Foundation\BoardController', 'delete']);

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

// Financial Engine (Phase 3)
Router::get('/admin/finance/funds', ['App\Controllers\Admin\PlaceholderController', 'index']);
Router::post('/admin/finance/funds/store', ['App\Controllers\Admin\PlaceholderController', 'index']);

Router::get('/admin/finance/projects', ['App\Controllers\Admin\Finance\ProjectController', 'index']);
Router::post('/admin/finance/projects/store', ['App\Controllers\Admin\Finance\ProjectController', 'store']);
Router::post('/admin/finance/projects/delete', ['App\Controllers\Admin\Finance\ProjectController', 'delete']);

Router::get('/admin/finance/ledger', ['App\Controllers\Admin\PlaceholderController', 'index']);

Router::get('/admin/finance/expenses', ['App\Controllers\Admin\PlaceholderController', 'index']);
Router::get('/admin/finance/expenses/create', ['App\Controllers\Admin\PlaceholderController', 'index']);
Router::post('/admin/finance/expenses/store', ['App\Controllers\Admin\PlaceholderController', 'index']);
Router::post('/admin/finance/expenses/approve', ['App\Controllers\Admin\PlaceholderController', 'index']);
Router::post('/admin/finance/expenses/void', ['App\Controllers\Admin\PlaceholderController', 'index']);

// Enterprise Modules (Phase 4)
// Bank
Router::get('/admin/banks', ['App\Controllers\Admin\PlaceholderController', 'index']);
Router::post('/admin/banks/store', ['App\Controllers\Admin\PlaceholderController', 'index']);

// Asset
Router::get('/admin/assets', ['App\Controllers\Admin\PlaceholderController', 'index']);
Router::get('/admin/assets/transfers', ['App\Controllers\Admin\PlaceholderController', 'index']);

// Document
Router::get('/admin/documents', ['App\Controllers\Admin\PlaceholderController', 'index']);
Router::get('/admin/documents/categories', ['App\Controllers\Admin\PlaceholderController', 'index']);

// Meeting
Router::get('/admin/meetings', ['App\Controllers\Admin\PlaceholderController', 'index']);
Router::get('/admin/meetings/tasks', ['App\Controllers\Admin\PlaceholderController', 'index']);

// Report Center (Phase 7)
Router::get('/admin/reports', ['App\Controllers\Admin\ReportController', 'index']);
Router::get('/admin/reports/generate', ['App\Controllers\Admin\ReportController', 'generate']);

// Website CMS (Phase 6)
Router::get('/admin/cms/banners', ['App\Controllers\Admin\CMS\BannerController', 'index']);
Router::post('/admin/cms/banners/store', ['App\Controllers\Admin\CMS\BannerController', 'store']);

Router::get('/admin/cms/news', ['App\Controllers\Admin\CMS\NewsController', 'index']);
Router::post('/admin/cms/news/store', ['App\Controllers\Admin\CMS\NewsController', 'store']);
Router::post('/admin/cms/news/delete', ['App\Controllers\Admin\CMS\NewsController', 'delete']);
Router::post('/admin/cms/news/toggle', ['App\Controllers\Admin\CMS\NewsController', 'togglePublish']);

Router::get('/admin/cms/activities', ['App\Controllers\Admin\CMS\ActivityController', 'index']);
Router::post('/admin/cms/activities/store', ['App\Controllers\Admin\CMS\ActivityController', 'store']);
Router::post('/admin/cms/activities/delete', ['App\Controllers\Admin\CMS\ActivityController', 'delete']);

Router::get('/admin/cms/pages', ['App\Controllers\Admin\CMS\PageController', 'index']);
Router::post('/admin/cms/pages/store', ['App\Controllers\Admin\CMS\PageController', 'store']);
Router::post('/admin/cms/pages/delete', ['App\Controllers\Admin\CMS\PageController', 'delete']);

Router::get('/admin/cms/downloads', ['App\Controllers\Admin\CMS\DownloadController', 'index']);
Router::post('/admin/cms/downloads/store', ['App\Controllers\Admin\CMS\DownloadController', 'store']);
Router::post('/admin/cms/downloads/delete', ['App\Controllers\Admin\CMS\DownloadController', 'delete']);
