<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Summary Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 p-8 mb-8">
                <div class="max-w-4xl mx-auto">
                    <h3 class="text-2xl font-extrabold text-black mb-8 text-center">Summary Report Generator</h3>
                    
                    <form method="GET" action="{{ route('summary.report.export') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                            <!-- Date Selection -->
                            <div class="flex flex-col">
                                <label for="start_date" class="text-xs font-bold text-black uppercase tracking-[0.2em] mb-2">From Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}" 
                                    class="rounded-xl border border-gray-300 bg-gray-50 text-gray-900 p-3 focus:ring-2 focus:ring-[#00C6FF] focus:border-transparent outline-none transition">
                            </div>
                            <div class="flex flex-col">
                                <label for="end_date" class="text-xs font-bold text-black uppercase tracking-[0.2em] mb-2">To Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}" 
                                    class="rounded-xl border border-gray-300 bg-gray-50 text-gray-900 p-3 focus:ring-2 focus:ring-[#00C6FF] focus:border-transparent outline-none transition">
                            </div>

                            <!-- Specific Fund -->
                            <div class="flex flex-col">
                                <label for="specific_fund" class="text-xs font-bold text-gray-700 uppercase tracking-[0.2em] mb-2">Specific Fund</label>
                                <select name="specific_fund" id="specific_fund" 
                                    class="rounded-xl border border-gray-300 bg-gray-50 text-gray-900 p-3 focus:ring-2 focus:ring-[#00C6FF] focus:border-transparent outline-none transition">
                                    <option value="" class="py-1">-- ALL FUNDS --</option>
                                    @foreach(\App\Models\Transaction::SPECIFIC_FUNDS as $fund)
                                        <option value="{{ $fund }}" {{ request('specific_fund') == $fund ? 'selected' : '' }} class="py-1">
                                            {{ $fund }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Buttons Section -->
                        <div class="mt-10 flex flex-col sm:flex-row gap-6 justify-center">
                            <button type="submit" name="report_type" value="soe" 
                                class="min-w-[200px] bg-gradient-to-r from-[#00C6FF] to-[#FFB347] text-white font-sans font-extrabold py-3.5 px-8 rounded-xl text-center shadow-lg transform transition duration-300 hover:-translate-y-1 hover:brightness-110 active:scale-95 uppercase tracking-wider text-sm">
                                Generate SOE Report
                            </button>
                            <button type="submit" name="report_type" value="cdr" 
                                class="min-w-[200px] bg-gradient-to-r from-[#00C6FF] to-[#FFB347] text-white font-sans font-extrabold py-3.5 px-8 rounded-xl text-center shadow-lg transform transition duration-300 hover:-translate-y-1 hover:brightness-110 active:scale-95 uppercase tracking-wider text-sm">
                                Generate CDR Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($reportData))
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 p-8">
                <h3 class="text-xl font-bold text-black mb-6">Fund Distribution Breakdown</h3>
                <div class="overflow-x-auto pb-4">
                    <table class="min-w-full w-full table-auto divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Specific Fund</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Income</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Expenses</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Deposits</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Net Balance</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reportData['fund_distribution'] as $fund)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $fund['fund'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600 font-bold">₱ {{ number_format($fund['income'], 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600">₱ {{ number_format($fund['expense'], 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-blue-600 font-bold">₱ {{ number_format($fund['deposits'], 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-extrabold {{ $fund['net'] >= 0 ? 'text-gray-900' : 'text-red-700' }}">
                                        ₱ {{ number_format($fund['net'], 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">No data found for the selected period.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if(count($reportData['fund_distribution']) > 0)
                        <tfoot class="bg-gray-50 font-bold">
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">TOTAL</td>
                                <td class="px-6 py-4 text-sm text-right text-green-700">₱ {{ number_format($reportData['overall_flow']['total_income'], 2) }}</td>
                                <td class="px-6 py-4 text-sm text-right text-red-700">₱ {{ number_format($reportData['overall_flow']['total_expenses'], 2) }}</td>
                                <td class="px-6 py-4 text-sm text-right text-blue-700">₱ {{ number_format($reportData['overall_flow']['total_deposits'], 2) }}</td>
                                <td class="px-6 py-4 text-sm text-right text-gray-900">₱ {{ number_format($reportData['overall_flow']['net_balance'], 2) }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>