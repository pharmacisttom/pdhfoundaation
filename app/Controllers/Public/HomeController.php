<?php
namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Database;
use PDO;

class HomeController extends Controller
{
    public function index()
    {
        $db = Database::getInstance()->getConnection();
        
        // Fetch active projects for the homepage
        $projects = $db->query("SELECT * FROM projects WHERE status = 'ACTIVE' ORDER BY id DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
        
        // Fetch latest news (mock for now, or use documents if any)
        
        $this->view('public/layouts/main', [
            'content_view' => 'public/pages/home',
            'data' => [
                'title' => 'หน้าแรก | มูลนิธิเพื่อโรงพยาบาลปลวกแดง',
                'projects' => $projects
            ]
        ]);
    }

    public function about()
    {
        $this->view('public/layouts/main', [
            'content_view' => 'public/pages/about',
            'data' => [
                'title' => 'เกี่ยวกับเรา | มูลนิธิเพื่อโรงพยาบาลปลวกแดง'
            ]
        ]);
    }
}
