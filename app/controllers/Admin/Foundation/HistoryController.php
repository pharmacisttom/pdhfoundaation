<?php
namespace App\Controllers\Admin\Foundation;

use App\Core\Controller;
use App\Core\Database;
use App\Helpers\Auth;
use App\Helpers\CSRF;
use PDO;

class HistoryController extends Controller
{
    public function index()
    {
        Auth::requirePermission('admin');
        $db = Database::getInstance()->getConnection();
        $items = $db->query('SELECT * FROM foundation_history ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/foundation/history/index',
            'data' => [
                'page_title' => 'ประวัติและเจตนารมณ์ (History)',
            'items' => $items
            ]
        ]);
    }

    public function store()
    {
        Auth::requirePermission('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) {
            $this->redirect('/admin/foundation/history?error=invalid_request');
        }

        $db = Database::getInstance()->getConnection();
        $id = $_POST['id'] ?? null;
        
        // Simple Generic Bindings
        $data = [];
        foreach (['title','content','year'] as $col) {
            $data[$col] = $_POST[$col] ?? '';
        }

        if ($id) {
            // Update (Mocked for generic scaffold)
            $set = [];
            foreach ($data as $k => $v) {
                $set[] = "$k = :$k";
            }
            $data['id'] = $id;
            $stmt = $db->prepare('UPDATE foundation_history SET ' . implode(', ', $set) . ' WHERE id = :id');
            $stmt->execute($data);
            $this->redirect('/admin/foundation/history?success=updated');
        } else {
            // Insert
            $stmt = $db->prepare('INSERT INTO foundation_history (title, content, year) VALUES (:title, :content, :year)');
            $stmt->execute($data);
            $this->redirect('/admin/foundation/history?success=created');
        }
    }

    public function delete()
    {
        Auth::requirePermission('admin');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !CSRF::verify($_POST['csrf_token'])) {
            $this->redirect('/admin/foundation/history?error=invalid_request');
        }
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('DELETE FROM foundation_history WHERE id = :id');
        $stmt->execute(['id' => $_POST['id']]);
        $this->redirect('/admin/foundation/history?success=deleted');
    }
}
