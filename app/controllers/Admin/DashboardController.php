<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

class DashboardController extends Controller
{
    public function __construct()
    {
        AuthMiddleware::handle();
    }

    public function index()
    {
        $db = Database::getInstance()->getConnection();

        // 1. KPI Queries
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');
        $thisYear = date('Y');

        // Donations
        $todayDonations = $db->query("SELECT SUM(amount) FROM donations WHERE DATE(donation_date) = '$today' AND status = 'COMPLETED'")->fetchColumn() ?: 0;
        $monthDonations = $db->query("SELECT SUM(amount) FROM donations WHERE DATE_FORMAT(donation_date, '%Y-%m') = '$thisMonth' AND status = 'COMPLETED'")->fetchColumn() ?: 0;
        $yearDonations = $db->query("SELECT SUM(amount) FROM donations WHERE YEAR(donation_date) = '$thisYear' AND status = 'COMPLETED'")->fetchColumn() ?: 0;
        $totalDonations = $db->query("SELECT SUM(amount) FROM donations WHERE status = 'COMPLETED'")->fetchColumn() ?: 0;

        // Donors
        $totalDonors = $db->query("SELECT COUNT(*) FROM donors")->fetchColumn() ?: 0;

        // Fund Balances (Ledger)
        $totalRevenue = $db->query("SELECT SUM(credit) FROM fund_transactions WHERE reference_type IN ('DONATION', 'REVENUE')")->fetchColumn() ?: 0;
        $totalExpense = $db->query("SELECT SUM(debit) FROM fund_transactions WHERE reference_type = 'EXPENSE'")->fetchColumn() ?: 0;
        
        $fundCount = $db->query("SELECT COUNT(*) FROM funds WHERE status = 'OPEN'")->fetchColumn() ?: 0;
        $projectCount = $db->query("SELECT COUNT(*) FROM projects WHERE status = 'ACTIVE'")->fetchColumn() ?: 0;
        
        $pendingExpenses = $db->query("SELECT COUNT(*) FROM expenses WHERE status = 'PENDING' OR status = 'IN_PROGRESS'")->fetchColumn() ?: 0;

        // 2. Chart Data Queries
        // Donation Trend (Last 6 Months)
        $trendQuery = $db->query("
            SELECT DATE_FORMAT(donation_date, '%Y-%m') as mth, SUM(amount) as total 
            FROM donations 
            WHERE status = 'COMPLETED' 
            GROUP BY DATE_FORMAT(donation_date, '%Y-%m') 
            ORDER BY mth DESC LIMIT 6
        ")->fetchAll(PDO::FETCH_ASSOC);
        
        $chartLabels = [];
        $chartData = [];
        foreach(array_reverse($trendQuery) as $row) {
            $chartLabels[] = $row['mth'];
            $chartData[] = $row['total'];
        }

        // Fund Allocation
        $fundAllocQuery = $db->query("SELECT name, current_balance FROM funds WHERE status = 'OPEN'")->fetchAll(PDO::FETCH_ASSOC);
        $fundLabels = [];
        $fundData = [];
        foreach($fundAllocQuery as $row) {
            $fundLabels[] = $row['name'];
            $fundData[] = $row['current_balance'];
        }

        $this->view('admin/layouts/main', [
            'content_view' => 'admin/pages/dashboard',
            'data' => [
                'page_title' => 'Executive Dashboard',
                'kpi' => [
                    'today' => $todayDonations,
                    'month' => $monthDonations,
                    'year' => $yearDonations,
                    'total' => $totalDonations,
                    'donors' => $totalDonors,
                    'revenue' => $totalRevenue,
                    'expense' => $totalExpense,
                    'balance' => $totalRevenue - $totalExpense,
                    'funds' => $fundCount,
                    'projects' => $projectCount,
                    'pending_expenses' => $pendingExpenses
                ],
                'charts' => [
                    'trend_labels' => json_encode($chartLabels),
                    'trend_data' => json_encode($chartData),
                    'fund_labels' => json_encode($fundLabels),
                    'fund_data' => json_encode($fundData)
                ]
            ]
        ]);
    }
}
