<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class PlaceholderController extends Controller
{
    public function index()
    {
        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/placeholder',
            'data' => [
                'page_title' => 'กำลังพัฒนา (Under Construction)'
            ]
        ]);
    }
}
