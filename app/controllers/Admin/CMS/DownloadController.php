<?php
namespace App\Controllers\Admin\CMS;

use App\Core\Controller;
use App\Core\Database;
use App\Helpers\Auth;
use App\Helpers\CSRF;
use PDO;

class DownloadController extends Controller
{
    public function index()
    {
        Auth::requirePermission('admin');
        $db = Database::getInstance()->getConnection();
        $items = $db->query('SELECT * FROM downloads ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/pages/cms/downloads/index', [
            'page_title' => 'เอกสารดาวน์โหลด (Downloads)',
            'items' => $items
        ]);
    }

    public function store()
    {
        Auth::requirePermission('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) {
            $this->redirect('/admin/cms/downloads?error=invalid_request');
        }

        $db = Database::getInstance()->getConnection();
        $id = $_POST['id'] ?? null;
        
        // Simple Generic Bindings
        $data = [];
        foreach (['title','file_path','status'] as $col) {
            $data[$col] = $_POST[$col] ?? '';
        }

        if ($id) {
            // Update (Mocked for generic scaffold)
            $set = [];
            foreach ($data as $k => $v) {
                $set[] = "$k = :$k";
            }
            $data['id'] = $id;
            $stmt = $db->prepare('UPDATE downloads SET ' . implode(', ', $set) . ' WHERE id = :id');
            $stmt->execute($data);
            $this->redirect('/admin/cms/downloads?success=updated');
        } else {
            // Insert
            $stmt = $db->prepare('INSERT INTO downloads (title, file_path, status) VALUES (:title, :file_path, :status)');
            $stmt->execute($data);
            $this->redirect('/admin/cms/downloads?success=created');
        }
    }

    public function delete()
    {
        Auth::requirePermission('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) {
            $this->redirect('/admin/cms/downloads?error=invalid_request');
        }
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('DELETE FROM downloads WHERE id = :id');
        $stmt->execute(['id' => $_POST['id']]);
        $this->redirect('/admin/cms/downloads?success=deleted');
    }
}
