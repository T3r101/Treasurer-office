<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit/Update Records') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-950 tracking-tight">Edit/Update</h1>
                    <p class="text-slate-500 font-semibold text-sm">Edit and update existing transaction and deposit records</p>
                </div>
                
                <!-- Search Form -->
                @if(isset($recentPayees) || isset($recentNumbers))
                <form method="GET" action="{{ route('edit-update.index') }}" class="flex items-center gap-2">
                    <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="Search by check no or payee..." 
                        class="px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-cyan-500 text-slate-950 font-medium">
                    <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
                        Search
                    </button>
                    @if(isset($query) && $query)
                    <a href="{{ route('edit-update.index') }}" class="text-slate-500 hover:text-slate-700 text-sm">
                        Clear
                    </a>
                    @endif
                </form>
                @endif
            </div>

            <!-- Transactions Section -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/60 shadow-xl shadow-slate-200/30">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-black text-slate-900">Transactions</h3>
                    <a href="{{ route('transactions.index') }}" class="text-sm text-cyan-600 font-bold hover:text-cyan-700">
                        View All
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="w-32 px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Check No</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Payee</th>
                                <th class="w-40 px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                                <th class="w-40 px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Date</th>
                                <th class="w-32 px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transactions ?? collect() as $transaction)
                            <tr class="hover:bg-slate-50 transition-all duration-300">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $transaction->check_no ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $transaction->payee }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-gray-900 text-right">₱{{ number_format($transaction->amount_issued ?? $transaction->amount ?? 0, 2) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500 text-center">{{ $transaction->transaction_date ? $transaction->transaction_date->format('M d, Y') : 'N/A' }}</td>
                                <td class="px-4 py-3 text-right">
<a href="{{ route('transactions.edit', $transaction) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-cyan-100 text-black text-sm font-bold rounded-lg hover:bg-cyan-200 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">No transactions found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Deposits Section -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/60 shadow-xl shadow-slate-200/30">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-black text-slate-900">Deposits</h3>
                    <a href="{{ route('deposits.index') }}" class="text-sm text-cyan-600 font-bold hover:text-cyan-700">
                        View All
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="w-32 px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Check No</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Payee</th>
                                <th class="w-40 px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Amount</th>
                                <th class="w-40 px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Date</th>
                                <th class="w-32 px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($deposits ?? collect() as $deposit)
                            <tr class="hover:bg-slate-50 transition-all duration-300">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $deposit->cheque_number ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $deposit->payee }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-gray-900 text-right">₱{{ number_format($deposit->amount ?? 0, 2) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500 text-center">{{ $deposit->deposit_date ? $deposit->deposit_date->format('M d, Y') : 'N/A' }}</td>
                                <td class="px-4 py-3 text-right">
<a href="{{ route('deposits.edit', $deposit) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-cyan-100 text-black text-sm font-bold rounded-lg hover:bg-cyan-200 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">No deposits found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-gradient-to-r from-cyan-50 to-blue-50 rounded-3xl p-6 border border-cyan-200/60">
                <div class="flex items-start gap-4">
                    <div class="p-3 rounded-xl bg-cyan-100 text-cyan-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-900 mb-1">Quick Tip</h4>
                        <p class="text-sm text-slate-600">Click the "Edit" button on any row to directly edit that transaction or deposit record. Use the search above to quickly find specific records by check number or payee name.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
