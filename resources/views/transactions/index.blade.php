<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    @push('styles')
    <style>
        @media print {
            nav, header, aside, footer, .no-print, form, .pagination-container, button, .flex.justify-between.items-center.mb-4, .text-lg.font-medium, h2, h3, a {
                display: none !important;
            }
            body { background: white !important; color: black !important; margin: 0; padding: 0; }
            .py-12 { padding: 0 !important; }
            .max-w-7xl { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
            .bg-white { box-shadow: none !important; border: none !important; background: transparent !important; }
            #print-area { display: block !important; width: 100% !important; position: static; top: 0; left: 0; }
            .print-header { display: block !important; margin-bottom: 1rem; width: 100%; }
            .header-content { display: flex; align-items: center; justify-content: space-between; text-align: center; margin-bottom: 10px; }
            .logo-img { width: 80px; height: 80px; object-fit: contain; }
            .header-text { flex: 1; }
            .gov-line { font-size: 14pt; font-weight: bold; margin: 0; line-height: 1.2; color: black; }
            .month-line { font-size: 11pt; font-style: italic; margin-top: 5px; display: block; color: black; }
            .report-title { text-align: center; font-size: 13pt; font-weight: bold; margin-top: 15px; text-transform: uppercase; text-decoration: underline; color: black; }
            .header-divider { border-bottom: 2px solid #000; margin-top: 8px; margin-bottom: 20px; }
            table { border-collapse: collapse; width: 100% !important; font-size: 10pt; table-layout: auto; }
            th, td { border: 1px solid #000 !important; padding: 8px !important; text-align: left; color: black !important; }
            th { background-color: #f3f4f6 !important; font-weight: bold; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .truncate { white-space: normal !important; overflow: visible !important; text-overflow: clip !important; }
            .col-category, .col-date { display: none !important; }
        }
    </style>
    @endpush

    <div class="py-2 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-1">
                <div>
                    <h1 class="text-3xl font-black text-slate-950 tracking-tight">Transactions</h1>
                    <p class="text-slate-500 font-semibold text-sm">Manage all city treasury transactions</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-1">
                <div class="bg-white rounded-3xl p-3 border border-slate-200/60 shadow-xl shadow-slate-200/30 relative overflow-hidden group hover:shadow-2xl transition-all duration-300 cursor-pointer hover:scale-[1.005] hover:-translate-y-0.5">
                    <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total Transactions</h3>
                    <p class="text-2xl font-black text-slate-950 tracking-tight">{{ $transactions->total() }}</p>
                </div>

                <div class="bg-white rounded-3xl p-3 border border-slate-200/60 shadow-xl shadow-slate-200/30 relative overflow-hidden group hover:shadow-2xl transition-all duration-300 cursor-pointer hover:scale-[1.005] hover:-translate-y-0.5">
                    <div class="absolute top-0 right-0 p-4 opacity-10 text-emerald-600 group-hover:opacity-20 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1h.01" /></svg>
                    </div>
                    <h3 class="text-xs font-black text-emerald-600/70 uppercase tracking-widest mb-1">Total Amount</h3>
                    <p class="text-2xl font-black text-slate-950 tracking-tight">₱{{ number_format($transactions->sum('amount_issued') ?: $transactions->sum('amount'), 2) }}</p>
                </div>

                <div class="bg-white rounded-3xl p-3 border border-slate-200/60 shadow-xl shadow-slate-200/30 relative overflow-hidden group hover:shadow-2xl transition-all duration-300 cursor-pointer hover:scale-[1.005] hover:-translate-y-0.5">
                    <div class="absolute top-0 right-0 p-4 opacity-10 text-blue-600 group-hover:opacity-20 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M17 8h.01M12 4v16m0 0h4m-4 0a2 2 0 110 4m-4 0H8a2 2 0 110-4m0 0h4m-4 0a2 2 0 110-4m0 0H8" /></svg>
                    </div>
                    <h3 class="text-xs font-black text-blue-600/70 uppercase tracking-widest mb-1">This Month</h3>
                    <p class="text-2xl font-black text-slate-950 tracking-tight">{{ $transactions->filter(fn($t) => $t->transaction_date && $t->transaction_date->month === now()->month)->count() }}</p>
                </div>
            </div>

            <!-- Actions Box -->
            <div class="bg-white rounded-3xl p-3 border border-slate-200/60 shadow-xl shadow-slate-200/30">
                <div class="flex flex-wrap justify-between items-center gap-2 mb-2 no-print">
                    <h3 class="text-lg font-black text-slate-900">Recent Transactions</h3>
                    <div class="flex flex-wrap items-center gap-2">
                        <form action="{{ route('transactions.index') }}" method="GET" class="flex items-center gap-1">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400 group-focus-within:text-cyan-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Check No..." 
                                    class="pl-9 pr-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 outline-none text-sm transition-all bg-slate-50/50 w-48 md:w-64">
                            </div>
                            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-xl transition-all text-sm">
                                Search
                            </button>
                        </form>
                        <a href="{{ route('transactions.create') }}" class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-bold py-2 px-4 rounded-xl transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-lg flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add New
                        </a>
                    </div>
                </div>

                <div id="print-area">
                    <div class="hidden print-header">
                        <div class="header-content">
                            <img src="{{ asset('image/logo1.png') }}" class="logo-img" alt="Logo Left">
                            <div class="header-text">
                                <p class="gov-line">Province of Bukidnon</p>
                                <p class="gov-line">City Government of Malaybalay</p>
                                <span class="month-line">"For the month of {{ request('from_date') ? \Carbon\Carbon::parse(request('from_date'))->format('F Y') : now()->format('F Y') }}"</span>
                            </div>
                            <img src="{{ asset('image/logo.png') }}" class="logo-img" alt="Logo Right">
                        </div>
                        <h2 class="report-title">Transaction List Report</h2>
                        <div class="header-divider"></div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Check No</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Office</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Payee</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Nature of Payment</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Amount Issued</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Account Code</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase">Specific Fund</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase col-category">Category</th>
                                    <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase col-date">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transactions as $transaction)
                                <tr class="hover:bg-slate-50 transition-all duration-300 cursor-pointer hover:scale-[1.005]">
                                    <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaction->check_no ?? 'N/A' }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600">{{ $transaction->office }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600">{{ $transaction->payee }}</td>
                                    <td class="px-3 py-2 text-sm text-gray-600 max-w-xs truncate">{{ $transaction->nature_of_payment }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm font-bold text-gray-900">{{ number_format($transaction->amount_issued, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">{{ $transaction->account_code }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">{{ $transaction->specific_fund }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm col-category">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $transaction->current_prior }}</span>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 col-date">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4 no-print pagination-container">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
