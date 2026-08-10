<?php
namespace App\Controllers\Admin\Finance;

use App\Core\Controller;
use App\Core\Database;
use App\Helpers\Auth;
use App\Helpers\CSRF;
use PDO;

class ProjectController extends Controller
{
    public function index()
    {
        Auth::requirePermission('admin');
        $db = Database::getInstance()->getConnection();
        $items = $db->query('SELECT * FROM projects ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/finance/projects/index',
            'data' => [
                'page_title' => 'จัดการโครงการ (Projects)',
            'items' => $items
            ]
        ]);
    }

    public function store()
    {
        Auth::requirePermission('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) {
            $this->redirect('/admin/finance/projects?error=invalid_request');
        }

        $db = Database::getInstance()->getConnection();
        $id = $_POST['id'] ?? null;
        
        // Simple Generic Bindings
        $data = [];
        foreach (['project_code','project_name','budget','status'] as $col) {
            $data[$col] = $_POST[$col] ?? '';
        }

        if ($id) {
            // Update (Mocked for generic scaffold)
            $set = [];
            foreach ($data as $k => $v) {
                $set[] = "$k = :$k";
            }
            $data['id'] = $id;
            $stmt = $db->prepare('UPDATE projects SET ' . implode(', ', $set) . ' WHERE id = :id');
            $stmt->execute($data);
            $this->redirect('/admin/finance/projects?success=updated');
        } else {
            // Insert
            $stmt = $db->prepare('INSERT INTO projects (project_code, project_name, budget, status) VALUES (:project_code, :project_name, :budget, :status)');
            $stmt->execute($data);
            $this->redirect('/admin/finance/projects?success=created');
        }
    }

    public function delete()
    {
        Auth::requirePermission('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) {
            $this->redirect('/admin/finance/projects?error=invalid_request');
        }
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('DELETE FROM projects WHERE id = :id');
        $stmt->execute(['id' => $_POST['id']]);
        $this->redirect('/admin/finance/projects?success=deleted');
    }
}
