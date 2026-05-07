<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * Service class for processing Treasurer's Office summary reports and analytics.
 */
class SummaryReportService
{
    /**
     * Generate the complete summary report structure.
     *
     * @param array $filters Expects 'start_date' and 'end_date'
     * @return array
     */
    public function getSummaryReport(array $filters = []): array
    {
        $startDate = isset($filters['start_date']) ? Carbon::parse($filters['start_date']) : now()->startOfMonth();
        $endDate = isset($filters['end_date']) ? Carbon::parse($filters['end_date']) : now()->endOfDay();

        // Generate a unique cache key based on filters to optimize subsequent requests
        $cacheKey = 'report_summary_' . md5(serialize($filters) . Auth::id());

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($startDate, $endDate) {
            return [
                'overall_flow' => $this->getOverallSystemTotals($startDate, $endDate),
                'growth_comparison' => $this->getGrowthComparison(),
                'analytics_data' => [
                    'daily'   => $this->getDailyAnalytics($startDate, $endDate),
                    'weekly'  => $this->getWeeklyAnalytics($startDate, $endDate),
                    'monthly' => $this->getMonthlyAnalytics($startDate, $endDate),
                ],
                'fund_distribution' => $this->getFundDistribution($startDate, $endDate),
                'top_payees' => $this->getTopPayees($startDate, $endDate),
                'meta_data' => [
                    'report_range' => "{$startDate->toDateString()} to {$endDate->toDateString()}",
                    'generated_at' => now()->toDateTimeString()
                ]
            ];
        });
    }

    /**
     * Fetch data for Statement of Expenditures (From Transactions)
     */
    public function getSOEData(array $filters = [])
    {
        $query = Transaction::where('user_id', Auth::id())
            ->whereIn('type', ['expense', 'Expense', 'EXPENSE'])
            ->where('status', 'active');

        if (isset($filters['start_date'])) $query->whereDate('transaction_date', '>=', $filters['start_date']);
        if (isset($filters['end_date'])) $query->whereDate('transaction_date', '<=', $filters['end_date']);
        if (isset($filters['specific_fund'])) $query->where('specific_fund', $filters['specific_fund']);

        return $query->orderBy('transaction_date', 'asc')->get();
    }

    /**
     * Fetch data for Check Disbursement Record (From Deposits)
     */
    public function getCDRData(array $filters = [])
    {
        $query = Deposit::where('user_id', Auth::id())
            ->where('status', 'active');

        if (isset($filters['start_date'])) $query->whereDate('deposit_date', '>=', $filters['start_date']);
        if (isset($filters['end_date'])) $query->whereDate('deposit_date', '<=', $filters['end_date']);
        if (isset($filters['specific_fund'])) $query->where('specific_fund', $filters['specific_fund']);

        return $query->orderBy('deposit_date', 'asc')->get();
    }

    /**
     * Fetch detailed list of transactions for export reports.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDetailedTransactions(array $filters = [])
    {
        $startDate = isset($filters['start_date']) ? Carbon::parse($filters['start_date']) : now()->startOfMonth();
        $endDate = isset($filters['end_date']) ? Carbon::parse($filters['end_date']) : now()->endOfDay();

        return Transaction::query()
            ->where('user_id', Auth::id())
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('status', 'active')
            ->orderBy('transaction_date', 'desc')
            ->get();
    }

    /**
     * Calculate overall system totals from inception.
     */
    public function getOverallSystemTotals(Carbon $start, Carbon $end): array
    {
        $income = Transaction::where('user_id', Auth::id())->whereIn('type', ['income', 'Income', 'collection', 'Collection'])
            ->whereBetween('transaction_date', [$start, $end])->where('status', 'active')->sum('amount');
        $expense = Transaction::where('user_id', Auth::id())->whereIn('type', ['expense', 'Expense'])
            ->whereBetween('transaction_date', [$start, $end])->where('status', 'active')->sum('amount');
        
        $deposits = Deposit::where('user_id', Auth::id())->whereBetween('deposit_date', [$start, $end])->where('status', 'active')->sum('amount');

        return [
            'total_income'   => (float) $income,
            'total_expenses' => (float) $expense,
            'total_deposits' => (float) $deposits,
            'net_balance'    => (float) ($income + $deposits - $expense),
        ];
    }

    /**
     * Calculate percentage growth comparison between current and previous months.
     */
    public function getGrowthComparison(): array
    {
        $currentMonthStart = now()->startOfMonth();
        $previousMonthStart = now()->subMonth()->startOfMonth();
        $previousMonthEnd = now()->subMonth()->endOfMonth();

        $currentTotal = Transaction::where('user_id', Auth::id())->whereIn('type', ['income', 'Income', 'collection', 'Collection'])
            ->where('transaction_date', '>=', $currentMonthStart)
            ->sum('amount');
        $previousTotal = Transaction::where('user_id', Auth::id())->whereIn('type', ['income', 'Income', 'collection', 'Collection'])
            ->whereBetween('transaction_date', [now()->subMonth()->startOfMonth(), $previousMonthEnd])
            ->sum('amount');

        // Calculate percentage growth safely
        $growth = $previousTotal > 0
            ? (($currentTotal - $previousTotal) / $previousTotal) * 100
            : ($currentTotal > 0 ? 100 : 0);

        return [
            'current_period_amount' => (float) $currentTotal,
            'previous_period_amount' => (float) $previousTotal,
            'percentage_change' => round($growth, 2),
        ];
    }

    /**
     * Get daily aggregation for line charts.
     */
    private function getDailyAnalytics(Carbon $start, Carbon $end): array
    {
        return Transaction::query()
            ->selectRaw('DATE(transaction_date) as label, SUM(amount) as value')
            ->where('user_id', Auth::id())->whereIn('type', ['income', 'Income', 'collection', 'Collection'])
            ->whereBetween('transaction_date', [$start, $end])
            ->where('status', 'active')
            ->groupBy('label')
            ->orderBy('label')
            ->get()
            ->toArray();
    }

    /**
     * Get weekly aggregation using ISO week formatting.
     */
    private function getWeeklyAnalytics(Carbon $start, Carbon $end): array
    {
        // Using YEARWEEK(date, 1) for ISO week consistency (Monday start)
        return Transaction::query()
            ->selectRaw('YEARWEEK(transaction_date, 1) as label_id')
            ->selectRaw('MIN(DATE(transaction_date)) as label') // Use the first day of week as label
            ->selectRaw('SUM(amount) as value')
            ->where('user_id', Auth::id())->whereIn('type', ['income', 'Income', 'collection', 'Collection'])
            ->whereBetween('transaction_date', [$start, $end])
            ->where('status', 'active')
            ->groupBy('label_id')
            ->orderBy('label_id')
            ->get()
            ->map(fn($item) => [
                'label' => 'Week of ' . $item->label,
                'value' => (float) $item->value
            ])
            ->toArray();
    }

    /**
     * Get monthly aggregation for yearly trend analysis.
     */
    private function getMonthlyAnalytics(Carbon $start, Carbon $end): array
    {
        return Transaction::query()
            ->selectRaw('DATE_FORMAT(transaction_date, "%Y-%m") as label, SUM(amount) as value')
            ->where('user_id', Auth::id())->whereIn('type', ['income', 'Income', 'collection', 'Collection'])
            ->whereBetween('transaction_date', [$start, $end])
            ->where('status', 'active')
            ->groupBy('label')
            ->orderBy('label')
            ->get()
            ->map(fn($item) => [
                'label' => Carbon::parse($item->label . '-01')->format('M Y'),
                'value' => (float) $item->value
            ])
            ->toArray();
    }

/**
     * Get breakdown of net balance per specific fund.
     * Optimized: Single query with grouping instead of multiple queries per fund
     */
    private function getFundDistribution(Carbon $start, Carbon $end): array
    {
        $funds = Transaction::SPECIFIC_FUNDS;
        $distribution = [];

        // Use single aggregated queries for better performance
        $incomeData = Transaction::select('specific_fund', DB::raw('SUM(amount) as total'))
            ->where('user_id', Auth::id())
            ->whereIn('type', ['income', 'Income', 'collection', 'Collection'])
            ->whereBetween('transaction_date', [$start, $end])
            ->where('status', 'active')
            ->groupBy('specific_fund')
            ->pluck('total', 'specific_fund')
            ->toArray();

        $expenseData = Transaction::select('specific_fund', DB::raw('SUM(amount) as total'))
            ->where('user_id', Auth::id())
            ->whereIn('type', ['expense', 'Expense'])
            ->whereBetween('transaction_date', [$start, $end])
            ->where('status', 'active')
            ->groupBy('specific_fund')
            ->pluck('total', 'specific_fund')
            ->toArray();

        $depositData = Deposit::select('specific_fund', DB::raw('SUM(amount) as total'))
            ->where('user_id', Auth::id())
            ->whereBetween('deposit_date', [$start, $end])
            ->where('status', 'active')
            ->groupBy('specific_fund')
            ->pluck('total', 'specific_fund')
            ->toArray();

        foreach ($funds as $fund) {
            $income = (float) ($incomeData[$fund] ?? 0);
            $expense = (float) ($expenseData[$fund] ?? 0);
            $deposits = (float) ($depositData[$fund] ?? 0);

            if ($income > 0 || $expense > 0 || $deposits > 0) {
                $distribution[] = [
                    'fund' => $fund,
                    'income' => $income,
                    'expense' => $expense,
                    'deposits' => $deposits,
                    'net' => $income + $deposits - $expense
                ];
            }
        }
        return $distribution;
    }

    /**
     * Identify top 5 payees by total amount issued (Expenses).
     */
    private function getTopPayees(Carbon $start, Carbon $end): array
    {
        return Transaction::select('payee', DB::raw('SUM(amount) as total'))
            ->where('user_id', Auth::id())->whereIn('type', ['expense', 'Expense'])
            ->whereBetween('transaction_date', [$start, $end])
            ->where('status', 'active')
            ->groupBy('payee')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->toArray();
    }
}