<?php
namespace App\Controllers\Admin\CMS;

use App\Core\Controller;
use App\Core\Database;
use App\Helpers\Auth;
use App\Helpers\CSRF;
use PDO;

class PageController extends Controller
{
    public function index()
    {
        Auth::requirePermission('admin');
        $db = Database::getInstance()->getConnection();
        $items = $db->query('SELECT * FROM pages ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/cms/pages/index',
            'data' => [
                'page_title' => 'หน้าเว็บเพจ (Pages)',
            'items' => $items
            ]
        ]);
    }

    public function store()
    {
        Auth::requirePermission('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) {
            $this->redirect('/admin/cms/pages?error=invalid_request');
        }

        $db = Database::getInstance()->getConnection();
        $id = $_POST['id'] ?? null;
        
        // Simple Generic Bindings
        $data = [];
        foreach (['title','slug','status'] as $col) {
            $data[$col] = $_POST[$col] ?? '';
        }

        if ($id) {
            // Update (Mocked for generic scaffold)
            $set = [];
            foreach ($data as $k => $v) {
                $set[] = "$k = :$k";
            }
            $data['id'] = $id;
            $stmt = $db->prepare('UPDATE pages SET ' . implode(', ', $set) . ' WHERE id = :id');
            $stmt->execute($data);
            $this->redirect('/admin/cms/pages?success=updated');
        } else {
            // Insert
            $stmt = $db->prepare('INSERT INTO pages (title, slug, status) VALUES (:title, :slug, :status)');
            $stmt->execute($data);
            $this->redirect('/admin/cms/pages?success=created');
        }
    }

    public function delete()
    {
        Auth::requirePermission('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) {
            $this->redirect('/admin/cms/pages?error=invalid_request');
        }
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('DELETE FROM pages WHERE id = :id');
        $stmt->execute(['id' => $_POST['id']]);
        $this->redirect('/admin/cms/pages?success=deleted');
    }
}
