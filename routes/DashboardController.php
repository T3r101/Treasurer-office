<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Deposit;
use App\Services\SummaryReportService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $reportService;

    /**
     * DashboardController constructor.
     *
     * @param SummaryReportService $reportService
     */
    public function __construct(SummaryReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display the dashboard with financial metrics and charts.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch summary metrics using the service
        $summary = $this->reportService->getSummaryReport();
        
        $totalIncome = $summary['overall_flow']['total_income'] ?? 0;
        $totalExpenses = $summary['overall_flow']['total_expenses'] ?? 0;
        $totalDeposits = $summary['overall_flow']['total_deposits'] ?? 0;
        
        // Gross Volume is calculated as the total sum of all financial activity
        $totalTransactions = $totalIncome + $totalExpenses + $totalDeposits;

        $growth = $summary['growth_comparison']['percentage_change'] ?? 0;

        // Prepare monthly trend data for the chart (labels and values)
        $monthlyTrend = collect($summary['analytics_data']['monthly'] ?? [])->map(function($item) {
            return (object) [
                'month' => $item['label'],
                'amount' => $item['value']
            ];
        });

        // Fetch and unify recent activities from Transactions and Deposits
        $transactions = Transaction::where('user_id', Auth::id())
            ->where('status', 'active')
            ->select('id', 'check_no', 'payee', 'nature_of_payment', 'type', 'amount', 'amount_issued', 'transaction_date', 'created_at');

        if ($search) {
            $transactions->where('check_no', 'like', "%{$search}%");
        }

        $transactions = $transactions->latest('created_at')->take(10)->get()
            ->map(function($item) {
                $item->source_type = 'Transaction';
                $item->description = $item->payee . ' - ' . ($item->nature_of_payment ?? $item->type);
                $item->amount = $item->amount_issued > 0 ? $item->amount_issued : $item->amount;
                return $item;
            });

        $deposits = Deposit::where('user_id', Auth::id())
            ->where('status', 'active')
            ->select('id', 'cheque_number', 'payee', 'nature_of_payment', 'amount', 'deposit_date', 'created_at');

        if ($search) {
            $deposits->where('cheque_number', 'like', "%{$search}%");
        }

        $deposits = $deposits->latest('created_at')->take(10)->get()
            ->map(function($item) {
                $item->source_type = 'Deposit';
                $item->transaction_date = $item->deposit_date; // Unify date field for sorting
                $item->description = 'Deposit: ' . ($item->payee ?? $item->nature_of_payment ?? 'Financial Deposit');
                return $item;
            });

        // Combine, sort, and limit the activity list to the 5 most recent items
        $recentActivity = $transactions->concat($deposits)
            ->sortByDesc('created_at')
            ->take(6);

        return view('dashboard', compact(
            'totalTransactions',
            'totalIncome',
            'totalExpenses',
            'totalDeposits',
            'growth',
            'monthlyTrend',
            'recentActivity'
        ));
    }
}
