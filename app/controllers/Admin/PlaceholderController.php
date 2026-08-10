<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class PlaceholderController extends Controller
{
    public function index()
    {
        $this->view('admin/pages/placeholder', [
            'page_title' => 'กำลังพัฒนา (Under Construction)'
        ]);
    }
}
