<?php
namespace App\Controllers\Admin\Donation;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

class DonorController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('donor.view');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT d.*, 
                   (SELECT COUNT(*) FROM donations dn WHERE dn.donor_id = d.id AND dn.status != 'CANCELLED') as donation_count,
                   (SELECT SUM(amount) FROM donations dn WHERE dn.donor_id = d.id AND dn.status != 'CANCELLED') as total_donated
            FROM donors d 
            ORDER BY d.id DESC
        ");
        $donors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/donation/donors/index',
            'data' => [
                'page_title' => 'ฐานข้อมูลผู้บริจาค (Donor CRM)',
                'donors' => $donors,
                'success' => $_SESSION['success'] ?? null,
                'error' => $_SESSION['error'] ?? null
            ]
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function profile()
    {
        if (!isset($_GET['id'])) {
            $this->redirect('/admin/donors');
        }

        $id = $_GET['id'];
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("SELECT * FROM donors WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $donor = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$donor) {
            $this->redirect('/admin/donors');
        }

        // Fetch donations timeline
        $stmt = $db->prepare("
            SELECT dn.*, f.name as fund_name, p.name as project_name, r.receipt_number 
            FROM donations dn 
            LEFT JOIN funds f ON dn.fund_id = f.id 
            LEFT JOIN projects p ON dn.project_id = p.id 
            LEFT JOIN receipts r ON dn.id = r.donation_id AND r.is_cancelled = 0
            WHERE dn.donor_id = :id 
            ORDER BY dn.donation_date DESC, dn.id DESC
        ");
        $stmt->execute(['id' => $id]);
        $donations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/donation/donors/profile',
            'data' => [
                'page_title' => 'ประวัติผู้บริจาค: ' . $donor['donor_code'],
                'donor' => $donor,
                'donations' => $donations
            ]
        ]);
    }
}
