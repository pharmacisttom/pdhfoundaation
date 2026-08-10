<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

class ReportController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::requirePermission('report.view');
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();
        
        // Fetch filter data options
        $funds = $db->query("SELECT id, name FROM funds")->fetchAll(PDO::FETCH_ASSOC);
        $projects = $db->query("SELECT id, name FROM projects")->fetchAll(PDO::FETCH_ASSOC);

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/report/index',
            'data' => [
                'page_title' => 'ศูนย์รายงาน (Report Center)',
                'funds' => $funds,
                'projects' => $projects
            ]
        ]);
    }

    public function generate()
    {
        AuthMiddleware::requirePermission('report.export');
        
        $reportType = $_GET['type'] ?? 'donation';
        $format = $_GET['format'] ?? 'csv';
        
        // Filters
        $startDate = $_GET['start_date'] ?? '2020-01-01';
        $endDate = $_GET['end_date'] ?? date('Y-m-d');
        
        $db = Database::getInstance()->getConnection();
        
        if ($reportType === 'donation') {
            $stmt = $db->prepare("
                SELECT 
                    d.donation_date, 
                    d.receipt_number, 
                    dr.full_name as donor_name, 
                    d.amount, 
                    d.payment_channel, 
                    d.status 
                FROM donations d
                LEFT JOIN donors dr ON d.donor_id = dr.id
                WHERE DATE(d.donation_date) BETWEEN :start AND :end
                ORDER BY d.donation_date DESC
            ");
            $stmt->execute(['start' => $startDate, 'end' => $endDate]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $headers = ['วันที่', 'เลขที่ใบเสร็จ', 'ชื่อผู้บริจาค', 'จำนวนเงิน', 'ช่องทาง', 'สถานะ'];
            $filename = "Donation_Report_{$startDate}_to_{$endDate}";
            
            if ($format === 'csv') {
                $this->exportCSV($data, $headers, $filename);
            }
            // Future: add PDF export routing here
        }
        
        if ($reportType === 'executive') {
            // Complex Executive Summary
            // Opening balance, total revenue, total expense, closing balance
            $data = [
                ['หมวดหมู่', 'ยอดเงิน (บาท)'],
                ['ยอดยกมาเริ่มต้น (Opening Balance)', '0.00'], // Needs complex calculation logic based on date
                ['รวมรับ (Total Revenue)', $this->getSum($db, 'REVENUE', $startDate, $endDate)],
                ['รวมจ่าย (Total Expense)', $this->getSum($db, 'EXPENSE', $startDate, $endDate)],
            ];
            $this->exportCSV($data, [], "Executive_Summary_{$startDate}_to_{$endDate}");
        }
    }

    private function getSum($db, $type, $start, $end) {
        $stmt = $db->prepare("SELECT SUM(amount) FROM fund_transactions WHERE transaction_type = :type AND DATE(transaction_date) BETWEEN :start AND :end");
        $stmt->execute(['type' => $type, 'start' => $start, 'end' => $end]);
        return $stmt->fetchColumn() ?: 0;
    }

    private function exportCSV($data, $headers, $filename)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename . '.csv');
        
        $output = fopen('php://output', 'w');
        // Add BOM for Excel UTF-8 reading
        fputs($output, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
        
        if (!empty($headers)) {
            fputcsv($output, $headers);
        }
        
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit();
    }
}
