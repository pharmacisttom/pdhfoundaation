<?php
namespace App\Controllers\Admin\Document;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

class DocumentController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('document.view');
    }

    public function index()
    {
        // $type can be 'in' or 'out'
        $type = $_GET['type'] ?? 'in';
        $direction = strtoupper($type);
        if (!in_array($direction, ['IN', 'OUT', 'INTERNAL'])) {
            $direction = 'IN';
        }

        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("
            SELECT d.*, c.name as category_name 
            FROM documents d
            LEFT JOIN document_categories c ON d.category_id = c.id
            WHERE d.document_direction = :dir
            ORDER BY d.id DESC
        ");
        $stmt->execute(['dir' => $direction]);
        $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories = $db->query("SELECT * FROM document_categories WHERE is_active = 1")->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/document/index',
            'data' => [
                'page_title' => $direction == 'IN' ? 'หนังสือเข้า (Inbound Documents)' : 'หนังสือออก (Outbound Documents)',
                'direction' => $direction,
                'documents' => $documents,
                'categories' => $categories,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function categories()
    {
        AuthMiddleware::requirePermission('document.manage');
        $db = Database::getInstance()->getConnection();
        $categories = $db->query("SELECT * FROM document_categories ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/document/categories',
            'data' => [
                'page_title' => 'หมวดหมู่เอกสาร (Document Categories)',
                'categories' => $categories,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }
}
