<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;

class DashboardController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::handle();
    }

    public function index()
    {
        // Dummy data for Phase 1
        $data = [
            'page_title' => 'แดชบอร์ด',
            'today_donations' => 15000,
            'month_donations' => 450000,
            'total_donors' => 120,
            'active_projects' => 5
        ];

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/dashboard',
            'data' => $data
        ]);
    }
}
