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
