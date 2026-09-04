<?php
namespace App\Controllers\Admin\Foundation;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

class ProfileController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('cms.manage');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM foundation_profiles LIMIT 1");
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$profile) {
            // Should not happen as seeded, but just in case
            $profile = ['name_th' => ''];
        }

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/foundation/profile/index',
            'data' => [
                'page_title' => 'ข้อมูลทั่วไป (Foundation Profile)',
                'profile' => $profile,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/foundation/profile');
        
        $db = Database::getInstance()->getConnection();
        
        $logo = $this->handleUpload('logo');
        $favicon = $this->handleUpload('favicon');
        
        if (!$logo) $logo = $_POST['existing_logo'] ?? null;
        if (!$favicon) $favicon = $_POST['existing_favicon'] ?? null;

        $stmt = $db->prepare("UPDATE foundation_profiles SET 
            name_th = :name_th, name_en = :name_en, short_name = :short_name, 
            registration_no = :registration_no, tax_id = :tax_id, founded_date = :founded_date, 
            address = :address, phone = :phone, email = :email, website = :website, 
            facebook = :facebook, line_oa = :line_oa, google_maps = :google_maps, working_hours = :working_hours,
            logo = :logo, favicon = :favicon, updated_by = :updated_by");
        
        $stmt->execute([
            'name_th' => $_POST['name_th'] ?? '',
            'name_en' => $_POST['name_en'] ?? null,
            'short_name' => $_POST['short_name'] ?? null,
            'registration_no' => $_POST['registration_no'] ?? null,
            'tax_id' => $_POST['tax_id'] ?? null,
            'founded_date' => !empty($_POST['founded_date']) ? $_POST['founded_date'] : null,
            'address' => $_POST['address'] ?? null,
            'phone' => $_POST['phone'] ?? null,
            'email' => $_POST['email'] ?? null,
            'website' => $_POST['website'] ?? null,
            'facebook' => $_POST['facebook'] ?? null,
            'line_oa' => $_POST['line_oa'] ?? null,
            'google_maps' => $_POST['google_maps'] ?? null,
            'working_hours' => $_POST['working_hours'] ?? null,
            'logo' => $logo,
            'favicon' => $favicon,
            'updated_by' => \App\Helpers\Auth::user()['id']
        ]);
        
        $_SESSION['success'] = "อัปเดตข้อมูลมูลนิธิสำเร็จ";
        $this->redirect('/admin/foundation/profile');
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
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'ico'])) {
                $filename = uniqid($inputName . '_') . '.' . $extension;
                if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadDir . $filename)) {
                    return $filename;
                }
            }
        }
        return null;
    }
}
