<x-app-layout>
<div class="py-6 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg print:p-0">
                <form action="{{ route('reports.cdr.download') }}" method="GET" target="_blank" class="mb-6">
                    @foreach(request()->except(['prepared_by_name', 'prepared_by_position', 'approved_by_name', 'approved_by_position', 'format', 'cheque_number']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <div class="flex flex-col md:flex-row justify-center items-center gap-4 mb-6">
                        <div class="flex flex-wrap justify-center gap-2 print:hidden">
                            <button type="submit" name="format" value="pdf" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-bold shadow transition">Export PDF</button>
                            <button type="submit" name="format" value="excel" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-bold shadow transition">Export Excel</button>
                            <a href="{{ route('reports.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-bold shadow transition">Back</a>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row justify-center gap-12 md:gap-24 p-6 bg-slate-50 rounded-2xl border border-slate-200 mb-8 shadow-sm text-center">
                        <div class="space-y-1 w-full md:w-72">
                            <label class="block text-[10px] font-black text-black uppercase tracking-widest mb-1">Prepared By</label>
                            <input type="text" name="prepared_by_name" value="{{ request('prepared_by_name', session('prepared_by_name', 'admin')) }}" 
                                class="w-full text-base font-bold text-black bg-transparent border-0 border-b border-slate-400 focus:ring-0 focus:border-blue-500 p-0 mb-1 text-center" placeholder="Name">
                            <input type="text" name="prepared_by_position" value="{{ request('prepared_by_position', session('prepared_by_position', 'Staff/Accountant')) }}" 
                                class="w-full text-xs text-black font-medium bg-transparent border-0 focus:ring-0 p-0 text-center" placeholder="Position">
                        </div>
                        <div class="space-y-1 w-full md:w-72">
                            <label class="block text-[10px] font-black text-black uppercase tracking-widest mb-1">Approved By</label>
                            <input type="text" name="approved_by_name" value="{{ request('approved_by_name', session('approved_by_name', 'Supervisor Name')) }}" 
                                class="w-full text-base font-bold text-black bg-transparent border-0 border-b border-slate-400 focus:ring-0 focus:border-blue-500 p-0 mb-1 text-center" placeholder="Name">
                            <input type="text" name="approved_by_position" value="{{ request('approved_by_position', session('approved_by_position', 'City Treasurer')) }}" 
                                class="w-full text-xs text-black font-medium bg-transparent border-0 focus:ring-0 p-0 text-center" placeholder="Position">
                        </div>
                    </div>

                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full w-full table-auto border-collapse border border-slate-400 text-black">
                        <thead class="bg-slate-200 text-black">
                            <tr>
                                <th class="border border-slate-400 px-4 py-2 font-black uppercase tracking-wider text-[11px]">Date</th>
                                <th class="border border-slate-400 px-4 py-2 font-black uppercase tracking-wider text-[11px]">Check No</th>
                                <th class="border border-slate-400 px-4 py-2 font-black uppercase tracking-wider text-[11px]">Payee</th>
                                <th class="border border-slate-400 px-4 py-2 font-black uppercase tracking-wider text-[11px]">Nature of Payment</th>
                                <th class="border border-slate-400 px-4 py-2 font-black uppercase tracking-wider text-[11px]">Specific Fund</th>
                                <th class="border border-slate-400 px-4 py-2 font-black uppercase tracking-wider text-[11px]">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-black">
                            @foreach($data as $item)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="border border-slate-400 px-4 py-2 whitespace-nowrap font-bold">{{ \Carbon\Carbon::parse($item->deposit_date)->format('M d, Y') }}</td>
                                <td class="border border-slate-400 px-4 py-2 whitespace-nowrap font-bold">{{ $item->cheque_number }}</td>
                                <td class="border border-slate-400 px-4 py-2 font-bold">{{ $item->payee }}</td>
                                <td class="border border-slate-400 px-4 py-2 font-bold">{{ $item->nature_of_payment }}</td>
                                <td class="border border-slate-400 px-4 py-2 whitespace-nowrap font-bold">{{ $item->specific_fund }}</td>
                                <td class="border border-slate-400 px-4 py-2 text-right font-black">₱ {{ number_format($item->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
