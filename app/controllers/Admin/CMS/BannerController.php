<?php
namespace App\Controllers\Admin\CMS;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

class BannerController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('cms.manage');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->query("SELECT * FROM banners ORDER BY sort_order ASC, id DESC");
        $banners = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/cms/banners/index',
            'data' => [
                'page_title' => 'จัดการแบนเนอร์ (Banners)',
                'banners' => $banners,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function store()
    {
        AuthMiddleware::requirePermission('cms.manage');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/cms/banners');

        try {
            $db = Database::getInstance()->getConnection();
            
            // Handle File Upload
            $imageFile = '';
            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = ROOT_PATH . '/public/uploads/cms/banners/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileInfo = pathinfo($_FILES['image_file']['name']);
                $extension = strtolower($fileInfo['extension']);
                
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                    throw new \Exception("Invalid file type. Only JPG, PNG, WEBP allowed.");
                }
                
                $imageFile = uniqid('banner_') . '.' . $extension;
                move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadDir . $imageFile);
            } else {
                throw new \Exception("Banner Image is required.");
            }

            $stmt = $db->prepare("
                INSERT INTO banners (title, subtitle, image_file, button_text, button_url, published_at, expired_at, sort_order, status, created_by)
                VALUES (:title, :subtitle, :img, :btn_txt, :btn_url, :pub, :exp, :sort, :status, :uid)
            ");
            
            $stmt->execute([
                'title' => $_POST['title'] ?? null,
                'subtitle' => $_POST['subtitle'] ?? null,
                'img' => $imageFile,
                'btn_txt' => $_POST['button_text'] ?? null,
                'btn_url' => $_POST['button_url'] ?? null,
                'pub' => !empty($_POST['published_at']) ? $_POST['published_at'] . ' 00:00:00' : null,
                'exp' => !empty($_POST['expired_at']) ? $_POST['expired_at'] . ' 23:59:59' : null,
                'sort' => $_POST['sort_order'] ?? 0,
                'status' => $_POST['status'] ?? 'DRAFT',
                'uid' => \App\Helpers\Auth::user()['id']
            ]);

            $_SESSION['success'] = "บันทึกแบนเนอร์เรียบร้อยแล้ว";

        } catch (\Exception $e) {
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
        }

        $this->redirect('/admin/cms/banners');
    }
}
