<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Deposit Details') }}
        </h2>
    </x-slot>

    <div class="py-2 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-2">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-1">
                    <div>
                        <h1 class="text-3xl font-black text-slate-950 tracking-tight">Deposit Details</h1>
                        <p class="text-slate-500 font-semibold text-sm">Detailed record view</p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-slate-200/60 shadow-xl shadow-slate-200/30">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100"><span class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Cheque Number</span><p class="text-lg font-bold text-slate-900">{{ $deposit->cheque_number ?? 'N/A' }}</p></div>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100"><span class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Payee</span><p class="text-lg font-bold text-slate-900">{{ $deposit->payee }}</p></div>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100"><span class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Amount</span><p class="text-lg font-black text-cyan-600">₱{{ number_format($deposit->amount, 2) }}</p></div>
                        </div>
                        <div class="space-y-3">
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100"><span class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Deposit Date</span><p class="text-lg font-bold text-slate-900">{{ $deposit->deposit_date->format('M d, Y') }}</p></div>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100"><span class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Specific Fund</span><p class="text-lg font-bold text-slate-900">{{ $deposit->specific_fund }}</p></div>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100"><span class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Status</span><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black uppercase tracking-wider {{ $deposit->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">{{ $deposit->status }}</span></div>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Nature of Payment / Description</span>
                        <p class="text-slate-700">{{ $deposit->nature_of_payment ?: ($deposit->description ?: 'No description provided') }}</p>
                    </div>

                    <div class="mt-6 flex items-center justify-center pt-4 border-t border-slate-200 space-x-4">
                        <a href="{{ route('deposits.index') }}" class="px-6 py-3 text-slate-600 font-bold hover:text-slate-900 border border-slate-200 rounded-xl hover:bg-slate-50 transition-all duration-300">
                            Back to List
                        </a>
                        <form action="{{ route('deposits.destroy', $deposit) }}" method="POST" onsubmit="return confirm('Delete this record?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-6 py-3 text-rose-600 font-bold hover:text-rose-700 border border-rose-100 rounded-xl hover:bg-rose-50 transition-all duration-300">Delete</button>
                        </form>
                        <a href="{{ route('deposits.edit', $deposit) }}" class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-black py-3 px-8 rounded-xl transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-lg">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>