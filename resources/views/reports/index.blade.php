<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Summary Reports') }}
        </h2>
    </x-slot>

    <div class="py-2 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-1">
                <div>
                    <h1 class="text-3xl font-black text-slate-950 tracking-tight">Reports</h1>
                    <p class="text-slate-500 font-semibold text-sm">Generate summary reports</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200/60 shadow-xl shadow-slate-200/30">
                <div class="max-w-4xl mx-auto">
                    <h3 class="text-xl font-black text-slate-950 mb-6 text-center">Generate Report</h3>
                    
                    <form method="GET" action="{{ route('summary.report.export') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <!-- Date Selection -->
                            <div class="flex flex-col">
                                <label for="start_date" class="text-xs font-black text-slate-600 uppercase tracking-[0.2em] mb-2">From Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}" 
                                    class="rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer">
                            </div>
                            <div class="flex flex-col">
                                <label for="end_date" class="text-xs font-black text-slate-600 uppercase tracking-[0.2em] mb-2">To Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}" 
                                    class="rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer">
                            </div>

                            <!-- Specific Fund -->
                            <div class="flex flex-col">
                                <label for="specific_fund" class="text-xs font-black text-slate-600 uppercase tracking-[0.2em] mb-2">Specific Fund</label>
                                <select name="specific_fund" id="specific_fund" 
                                    class="rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer">
                                    <option value="" class="py-2">-- ALL FUNDS --</option>
                                    @foreach(\App\Models\Transaction::SPECIFIC_FUNDS as $fund)
                                        <option value="{{ $fund }}" {{ request('specific_fund') == $fund ? 'selected' : '' }} class="py-2">
                                            {{ $fund }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Buttons Section -->
                        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                            <button type="submit" name="report_type" value="soe" 
                                class="min-w-[200px] bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-black py-3 px-6 rounded-xl text-center shadow-lg transform transition duration-300 hover:-translate-y-0.5 hover:scale-105 hover:shadow-xl active:scale-95 uppercase tracking-wider text-sm cursor-pointer">
                                Generate SOE Report
                            </button>
                            <button type="submit" name="report_type" value="cdr" 
                                class="min-w-[200px] bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-black py-3 px-6 rounded-xl text-center shadow-lg transform transition duration-300 hover:-translate-y-0.5 hover:scale-105 hover:shadow-xl active:scale-95 uppercase tracking-wider text-sm cursor-pointer">
                                Generate CDR Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
