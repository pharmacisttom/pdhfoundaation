<?php
namespace App\Controllers\Admin\Foundation;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

class PatronController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('cms.manage');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM foundation_patrons ORDER BY sort_order ASC");
        $patrons = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/foundation/patrons/index',
            'data' => [
                'page_title' => 'องค์อุปถัมภ์',
                'patrons' => $patrons,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/foundation/patrons');
        
        $db = Database::getInstance()->getConnection();
        
        $photo = $this->handleUpload('photo');
        
        $stmt = $db->prepare("INSERT INTO foundation_patrons 
            (prefix, first_name, last_name, display_name, position, photo, biography, honor_text, start_date, end_date, is_published, created_by) 
            VALUES (:prefix, :first_name, :last_name, :display_name, :position, :photo, :biography, :honor_text, :start_date, :end_date, :is_published, :created_by)");
        
        $stmt->execute([
            'prefix' => $_POST['prefix'] ?? null,
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'display_name' => $_POST['display_name'] ?? null,
            'position' => $_POST['position'] ?? null,
            'photo' => $photo,
            'biography' => $_POST['biography'] ?? null,
            'honor_text' => $_POST['honor_text'] ?? null,
            'start_date' => !empty($_POST['start_date']) ? $_POST['start_date'] : null,
            'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
            'created_by' => \App\Helpers\Auth::user()['id']
        ]);
        
        $_SESSION['success'] = "เพิ่มข้อมูลสำเร็จ";
        $this->redirect('/admin/foundation/patrons');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/foundation/patrons');
        
        $id = $_POST['id'];
        $db = Database::getInstance()->getConnection();
        
        $photo = $this->handleUpload('photo');
        if (!$photo) {
            $photo = $_POST['existing_photo'] ?? null;
        }

        $stmt = $db->prepare("UPDATE foundation_patrons SET 
            prefix = :prefix, first_name = :first_name, last_name = :last_name, display_name = :display_name, 
            position = :position, photo = :photo, biography = :biography, honor_text = :honor_text, 
            start_date = :start_date, end_date = :end_date, is_published = :is_published, updated_by = :updated_by 
            WHERE id = :id");
        
        $stmt->execute([
            'prefix' => $_POST['prefix'] ?? null,
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'display_name' => $_POST['display_name'] ?? null,
            'position' => $_POST['position'] ?? null,
            'photo' => $photo,
            'biography' => $_POST['biography'] ?? null,
            'honor_text' => $_POST['honor_text'] ?? null,
            'start_date' => !empty($_POST['start_date']) ? $_POST['start_date'] : null,
            'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
            'updated_by' => \App\Helpers\Auth::user()['id'],
            'id' => $id
        ]);
        
        $_SESSION['success'] = "อัปเดตข้อมูลสำเร็จ";
        $this->redirect('/admin/foundation/patrons');
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/foundation/patrons');
        
        $id = $_POST['id'];
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM foundation_patrons WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        $_SESSION['success'] = "ลบข้อมูลสำเร็จ";
        $this->redirect('/admin/foundation/patrons');
    }

    public function updateSort()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['order']) && is_array($input['order'])) {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("UPDATE foundation_patrons SET sort_order = :sort_order WHERE id = :id");
            foreach ($input['order'] as $index => $id) {
                $stmt->execute(['sort_order' => $index, 'id' => $id]);
            }
            $this->json(['status' => 'success']);
        }
        $this->json(['status' => 'error'], 400);
    }

    public function togglePublish()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['id']) && isset($input['status'])) {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("UPDATE foundation_patrons SET is_published = :status WHERE id = :id");
            $stmt->execute([
                'status' => $input['status'] ? 1 : 0,
                'id' => $input['id']
            ]);
            $this->json(['status' => 'success']);
        }
        $this->json(['status' => 'error'], 400);
    }

    private function handleUpload($inputName)
    {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = ROOT_PATH . '/public/uploads/foundation/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileInfo = pathinfo($_FILES[$inputName]['name']);
            $extension = strtolower($fileInfo['extension']);
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $filename = uniqid('patron_') . '.' . $extension;
                if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadDir . $filename)) {
                    return $filename;
                }
            }
        }
        return null;
    }
}
