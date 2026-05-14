<x-app-layout>
    <div class="py-10 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Overview</h1>
                    <p class="text-slate-500 font-medium text-sm">Real-time monitoring of city treasury activities and performance.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3">
                        <div class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.8)]"></div>
                        <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">System Live</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 shadow-xl shadow-slate-200/20 flex flex-wrap items-center justify-between gap-6 transition-all hover:bg-slate-100 ring-1 ring-slate-100">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gradient-to-br from-cyan-500/20 to-blue-500/10 rounded-2xl shadow-inner border border-white/5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Reports</h4>
                        <p class="text-slate-500 text-xs font-bold">Generate summaries and detailed statements</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('summary.report.export', ['type' => 'pdf']) }}" class="flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-rose-50 border border-slate-200 hover:border-rose-200 rounded-2xl text-xs font-black text-slate-700 uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        Export PDF
                    </a>
                </div>
            </div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Transactions Card -->
                <div class="bg-slate-50 rounded-3xl p-7 border border-slate-200 shadow-xl shadow-slate-200/30 relative overflow-hidden group hover:shadow-cyan-500/10 transition-all duration-500 cursor-pointer hover:scale-[1.02] hover:-translate-y-1 ring-1 ring-slate-100 hover:ring-cyan-500/30">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    </div>
                    <h3 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Gross Volume</h3>
                    <p class="text-3xl font-black text-slate-900 tracking-tight group-hover:text-cyan-600 transition-colors">₱{{ number_format($totalTransactions, 2) }}</p>
                    <div class="mt-3 h-1 w-12 bg-cyan-500 rounded-full group-hover:w-24 transition-all duration-500"></div>
                </div>

                <!-- Total Income Card -->
                <div class="bg-slate-50 rounded-3xl p-7 border border-slate-200 shadow-xl shadow-slate-200/30 relative overflow-hidden group hover:shadow-emerald-500/10 transition-all duration-500 cursor-pointer hover:scale-[1.02] hover:-translate-y-1 ring-1 ring-slate-100 hover:ring-emerald-500/30">
                    <div class="absolute top-0 right-0 p-4 opacity-5 text-emerald-600 group-hover:opacity-10 transition-opacity group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    </div>
                    <h3 class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-1">Total Income</h3>
                    <p class="text-3xl font-black text-slate-900 tracking-tight group-hover:text-emerald-600 transition-colors">₱{{ number_format($totalIncome, 2) }}</p>
                    <div class="mt-3 h-1 w-12 bg-emerald-500 rounded-full group-hover:w-24 transition-all duration-500"></div>
                </div>

                <!-- Total Expenses Card -->
                <div class="bg-slate-50 rounded-3xl p-7 border border-slate-200 shadow-xl shadow-slate-200/30 relative overflow-hidden group hover:shadow-rose-500/10 transition-all duration-500 cursor-pointer hover:scale-[1.02] hover:-translate-y-1 ring-1 ring-slate-100 hover:ring-rose-500/30">
                    <div class="absolute top-0 right-0 p-4 opacity-5 text-rose-600 group-hover:opacity-10 transition-opacity group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" /></svg>
                    </div>
                    <h3 class="text-xs font-black text-rose-600 uppercase tracking-widest mb-1">Total Expenses</h3>
                    <p class="text-3xl font-black text-slate-900 tracking-tight group-hover:text-rose-600 transition-colors">₱{{ number_format($totalExpenses, 2) }}</p>
                    <div class="mt-3 h-1 w-12 bg-rose-500 rounded-full group-hover:w-24 transition-all duration-500"></div>
                </div>

                <!-- Total Deposits Card -->
                <div class="bg-slate-50 rounded-3xl p-7 border border-slate-200 shadow-xl shadow-slate-200/30 relative overflow-hidden group hover:shadow-cyan-500/10 transition-all duration-500 cursor-pointer hover:scale-[1.02] hover:-translate-y-1 ring-1 ring-slate-100 hover:ring-cyan-500/30">
                    <div class="absolute top-0 right-0 p-4 opacity-5 text-cyan-600 group-hover:opacity-10 transition-opacity group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    </div>
                    <h3 class="text-xs font-black text-cyan-600 uppercase tracking-widest mb-1">Total Deposits</h3>
                    <p class="text-3xl font-black text-slate-900 tracking-tight group-hover:text-blue-600 transition-colors">₱{{ number_format($totalDeposits, 2) }}</p>
                    <div class="mt-3 h-1 w-12 bg-blue-400 rounded-full group-hover:w-24 transition-all duration-500"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<!-- Monthly Revenue Chart -->
                <div class="lg:col-span-2 bg-slate-50 rounded-3xl p-8 border border-slate-200 shadow-xl shadow-slate-200/30 relative overflow-hidden group">
                    <div class="absolute -right-20 -top-20 h-64 w-64 bg-cyan-500/5 rounded-full blur-3xl group-hover:bg-cyan-500/10 transition-colors"></div>
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Performance</h3>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mt-1">Monthly trend analysis</p>
                        </div>
                        <div class="px-4 py-1.5 bg-white rounded-xl border border-slate-200">
                            <span class="text-xs font-black {{ $growth >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 1) }}% <span class="text-slate-500 ml-1">vs last month</span>
                            </span>
                        </div>
                    </div>
                    <div class="h-72 relative">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Recent Activity Grid -->
                <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200 shadow-xl shadow-slate-200/30 flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Latest Actions</h3>
                            <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mt-0.5">Real-time updates</p>
                        </div>
                        <a href="{{ route('transactions.index') }}" class="text-xs font-black text-cyan-400 uppercase tracking-widest hover:text-cyan-300 transition-colors">
                            View All
                        </a>
                    </div>
                    <div class="space-y-4 flex-1 overflow-y-auto pr-2 custom-scrollbar">
@forelse ($recentActivity as $activity)
                            <div class="group flex items-center gap-4 p-4 rounded-2xl bg-white border border-slate-100 hover:bg-slate-100 hover:border-slate-200 transition-all duration-300 cursor-pointer shadow-sm">
                                <div class="p-3 rounded-2xl transition-transform group-hover:scale-110 {{ $activity->source_type === 'Deposit' ? 'bg-cyan-500/10 text-cyan-400' : 'bg-orange-500/10 text-orange-400' }}">
                                    @if($activity->source_type === 'Deposit')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" /><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" /></svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <p class="text-sm font-black text-slate-700 truncate group-hover:text-slate-900 transition-colors">{{ $activity->description }}</p>
                                        <p class="text-sm font-black {{ $activity->source_type === 'Deposit' ? 'text-emerald-600' : 'text-slate-900' }}">
                                            ₱{{ number_format($activity->amount, 0) }}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">{{ $activity->transaction_date->format('M d, H:i') }}</p>
                                        <span class="h-1 w-1 rounded-full bg-slate-700"></span>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $activity->source_type }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center py-10 text-slate-500 font-bold italic">No recent activity detected.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyTrend->pluck('month')) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($monthlyTrend->pluck('amount')) !!},
                    borderColor: '#06b6d4',
                    backgroundColor: 'rgba(6, 182, 212, 0.05)',
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#06b6d4',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { display: true, color: 'rgba(0,0,0,0.05)' }, ticks: { color: '#94a3b8', font: { weight: 'bold' } } },
                    x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { weight: 'bold' } } }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
