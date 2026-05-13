<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class SummaryReportService
{
    public function getSummaryReport(array $filters = []): array
    {
        $startDate = isset($filters['start_date']) ? Carbon::parse($filters['start_date']) : now()->startOfMonth();
        $endDate = isset($filters['end_date']) ? Carbon::parse($filters['end_date']) : now()->endOfDay();

        $cacheKey = 'report_summary_' . md5(serialize($filters)); // Removed Auth::id() as data is now global

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($startDate, $endDate) {
            $totalIncome = $this->getTotalIncome($startDate, $endDate);
            $totalExpenses = $this->getTotalExpenses($startDate, $endDate);
            $totalDeposits = $this->getTotalDeposits($startDate, $endDate);
            $netBalance = ($totalIncome + $totalDeposits) - $totalExpenses;

            return [
                'overall_flow' => [
                    'total_income' => $totalIncome,
                    'total_expenses' => $totalExpenses,
                    'total_deposits' => $totalDeposits,
                    'net_balance' => $netBalance,
                    'total_transactions_count'  => Transaction::withoutGlobalScopes()->whereBetween('transaction_date', [$startDate, $endDate])->count(),
                ],
                'growth_comparison' => $this->getGrowthComparison(),
                'analytics_data' => [
                    'daily'   => $this->getDailyAnalytics($startDate, $endDate),
                    'weekly'  => $this->getWeeklyAnalytics($startDate, $endDate),
                    'monthly' => $this->getMonthlyAnalytics($startDate, $endDate),
                ],
                'meta_data' => [
                    'report_range' => "{$startDate->toDateString()} to {$endDate->toDateString()}",
                    'generated_at' => now()->toDateTimeString()
                ]
            ];
        });
    }

    public function getSOEData(array $filters): \Illuminate\Support\Collection
    {
        $query = Transaction::withoutGlobalScopes()->whereIn('type', ['expense', 'Expense', 'EXPENSE'])
            ->where('status', 'active');

        if (!empty($filters['start_date'])) {
            $query->whereDate('transaction_date', '>=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $query->whereDate('transaction_date', '<=', $filters['end_date']);
        }
        if (!empty($filters['specific_fund'])) {
            $query->where('specific_fund', $filters['specific_fund']);
        }

        return $query->orderBy('transaction_date', 'asc')->get();
    }

    public function getCDRData(array $filters): \Illuminate\Support\Collection
    {
        $query = Deposit::withoutGlobalScopes()->where('status', 'active');

        if (!empty($filters['start_date'])) {
            $query->whereDate('deposit_date', '>=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $query->whereDate('deposit_date', '<=', $filters['end_date']);
        }
        if (!empty($filters['specific_fund'])) {
            $query->where('specific_fund', $filters['specific_fund']);
        }

        return $query->orderBy('deposit_date', 'asc')->get();
    }

    private function getTotalIncome(Carbon $start, Carbon $end): float
    {
        return (float) Transaction::withoutGlobalScopes()->where('type', 'income')
                                ->where('status', 'active')
                                ->whereBetween('transaction_date', [$start, $end])
                                ->sum(\DB::raw('COALESCE(NULLIF(amount_issued, 0), amount)'));
    }

    private function getTotalExpenses(Carbon $start, Carbon $end): float
    {
        return (float) Transaction::withoutGlobalScopes()->where('type', 'expense')
                                ->where('status', 'active')
                                ->whereBetween('transaction_date', [$start, $end])
                                ->sum(\DB::raw('COALESCE(NULLIF(amount_issued, 0), amount)'));
    }

    private function getTotalDeposits(Carbon $start, Carbon $end): float
    {
        return (float) Deposit::withoutGlobalScopes()->where('status', 'active')
                            ->whereBetween('deposit_date', [$start, $end])
                            ->sum('amount');
    }

    private function getGrowthComparison(): array
    {
        $currentTotal = Transaction::withoutGlobalScopes()->where('status', 'active')
                                    ->where('type', 'income')
                                    ->where('transaction_date', '>=', now()->startOfMonth())
                                    ->sum(\DB::raw('COALESCE(NULLIF(amount_issued, 0), amount)'));
        $previousTotal = Transaction::withoutGlobalScopes()->where('status', 'active')
                                    ->where('type', 'income')
                                    ->whereBetween('transaction_date', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth()
        ])->sum('amount');

        $growth = $previousTotal > 0 ? (($currentTotal - $previousTotal) / $previousTotal) * 100 : ($currentTotal > 0 ? 100 : 0);

        return [
            'current_period_amount' => (float) $currentTotal,
            'previous_period_amount' => (float) $previousTotal,
            'percentage_change' => round($growth, 2),
        ];
    }

    private function getDailyAnalytics(Carbon $start, Carbon $end): array
    {
        return Transaction::query()
            ->selectRaw('DATE(transaction_date) as label, SUM(amount) as value')
            ->whereBetween('transaction_date', [$start, $end])
            ->groupBy('label')
            ->orderBy('label')
            ->get()
            ->toArray();
    }

    private function getWeeklyAnalytics(Carbon $start, Carbon $end): array
    {
        return Transaction::query()
            ->selectRaw('YEARWEEK(transaction_date, 1) as label_id, MIN(DATE(transaction_date)) as label, SUM(amount) as value')
            ->whereBetween('transaction_date', [$start, $end])
            ->groupBy('label_id')
            ->get()
            ->map(fn($item) => ['label' => 'Week of ' . $item->label, 'value' => (float) $item->value])
            ->toArray();
    }

    private function getMonthlyAnalytics(Carbon $start, Carbon $end): array
    {
        return Transaction::query()
            ->selectRaw('DATE_FORMAT(transaction_date, "%Y-%m") as label, SUM(amount) as value')
            ->whereBetween('transaction_date', [$start, $end])
            ->groupBy('label')
            ->orderBy('label')
            ->get()
            ->map(fn($item) => ['label' => Carbon::parse($item->label)->format('M Y'), 'value' => (float) $item->value])
            ->toArray();
    }
}