<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Transaction') }}
        </h2>
    </x-slot>

    <div class="py-2 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-2">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-1">
                    <div>
                        <h1 class="text-3xl font-black text-slate-950 tracking-tight">Edit Transaction</h1>
                        <p class="text-slate-500 font-semibold text-sm">Update existing transaction details</p>
                    </div>
                </div>

                <!-- Form Box -->
                <div class="bg-white rounded-3xl p-4 border border-slate-200/60 shadow-xl shadow-slate-200/30">
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div>
                                    <label for="check_no" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Check No</label>
                                    <input type="text" name="check_no" id="check_no" value="{{ old('check_no', $transaction->check_no) }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">
                                </div>
                                <div>
                                    <label for="office" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Office</label>
                                    <input type="text" name="office" id="office" value="{{ old('office', $transaction->office) }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">
                                </div>
                                <div>
                                    <label for="payee" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Payee</label>
                                    <input type="text" name="payee" id="payee" value="{{ old('payee', $transaction->payee) }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">
                                </div>
                                <div>
                                    <label for="nature_of_payment" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Nature of Payment</label>
                                    <textarea name="nature_of_payment" id="nature_of_payment" rows="2" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">{{ old('nature_of_payment', $transaction->nature_of_payment) }}</textarea>
                                </div>
                                <div>
                                    <label for="amount_issued" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Amount Issued</label>
                                    <input type="number" step="0.01" name="amount_issued" id="amount_issued" value="{{ old('amount_issued', $transaction->amount_issued) }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div>
                                    <label for="account_code" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Account Code</label>
                                    <input type="text" name="account_code" id="account_code" value="{{ old('account_code', $transaction->account_code) }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">
                                </div>
                                <div>
                                    <label for="specific_fund" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Specific Fund</label>
                                    <select name="specific_fund" id="specific_fund" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100" required>
                                        @foreach(\App\Models\Transaction::SPECIFIC_FUNDS as $fund)
                                            <option value="{{ $fund }}" {{ old('specific_fund', $transaction->specific_fund) == $fund ? 'selected' : '' }}>{{ $fund }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="current_prior" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Category</label>
                                    <select name="current_prior" id="current_prior" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">
                                        <option value="Current" {{ old('current_prior', $transaction->current_prior) == 'Current' ? 'selected' : '' }}>Current</option>
                                        <option value="Prior" {{ old('current_prior', $transaction->current_prior) == 'Prior' ? 'selected' : '' }}>Prior</option>
                                        <option value="Continuing" {{ old('current_prior', $transaction->current_prior) == 'Continuing' ? 'selected' : '' }}>Continuing</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="transaction_date" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Date</label>
                                    <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100" required>
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Status</label>
                                    <select name="status" id="status" class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100" required>
                                        <option value="active" {{ old('status', $transaction->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $transaction->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="amount" value="{{ $transaction->amount }}">
                        <input type="hidden" name="type" value="{{ $transaction->type }}">
                        <input type="hidden" name="description" value="{{ $transaction->description }}">

                        <div class="flex items-center justify-center mt-4 pt-2 border-t border-slate-200 space-x-4">
                            <a href="{{ route('transactions.index') }}" class="px-6 py-3 text-slate-600 font-bold hover:text-slate-900 border border-slate-200 rounded-xl hover:bg-slate-50 transition-all duration-300">
                                Cancel
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-black py-3 px-8 rounded-xl transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-lg">
                                Update Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>