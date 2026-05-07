<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Transaction') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-950 tracking-tight">Add Transaction</h1>
                    <p class="text-slate-500 font-semibold text-sm">Create a new disbursement or income record</p>
                </div>
                <a href="{{ route('transactions.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 transition shadow-lg shadow-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Back to Records
                </a>
            </div>

            <div class="relative z-10 bg-white rounded-3xl p-8 border border-slate-200/60 shadow-xl shadow-slate-200/30">
                <div class="text-gray-900">
                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <div class="flex flex-col">
                                    <label for="check_no" class="text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Check No</label>
                                    <input type="text" name="check_no" id="check_no" value="{{ old('check_no') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">
                                    @error('check_no')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col">
                                    <label for="office" class="text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Office</label>
                                    <input type="text" name="office" id="office" value="{{ old('office') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">
                                    @error('office')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col">
                                    <label for="payee" class="text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Payee</label>
                                    <input type="text" name="payee" id="payee" value="{{ old('payee') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">
                                    @error('payee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Middle Column -->
                            <div class="space-y-6">
                                <div class="flex flex-col">
                                    <label for="nature_of_payment" class="text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Nature of Payment</label>
                                    <textarea name="nature_of_payment" id="nature_of_payment" rows="3" class="w-full rounded-xl border border-slate-300 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">{{ old('nature_of_payment') }}</textarea>
                                    @error('nature_of_payment')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col">
                                    <label for="amount" class="text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Total Amount</label>
                                    <input type="number" step="any" name="amount" id="amount" value="{{ old('amount') }}" class="relative z-50 block w-full rounded-xl border border-slate-300 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 !pointer-events-auto cursor-text" required>
                                    @error('amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col">
                                    <label for="amount_issued" class="text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Amount Issued</label>
                                    <input type="number" step="any" name="amount_issued" id="amount_issued" value="{{ old('amount_issued') }}" class="relative z-50 block w-full rounded-xl border border-slate-300 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 !pointer-events-auto cursor-text">
                                    @error('amount_issued')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col">
                                    <label for="account_code" class="text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Account Code</label>
                                    <input type="text" name="account_code" id="account_code" value="{{ old('account_code') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100">
                                    @error('account_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <div class="flex flex-col">
                                    <label for="specific_fund" class="text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Specific Fund</label>
                                    <select name="specific_fund" id="specific_fund" class="rounded-xl border border-slate-300 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer" required>
                                        <option value="" disabled {{ old('specific_fund', '') == '' ? 'selected' : '' }} class="text-slate-900">
                                            -- Select Specific Fund --
                                        </option>
                                        @foreach(\App\Models\Transaction::SPECIFIC_FUNDS as $fund)
                                            <option value="{{ $fund }}" {{ old('specific_fund', '') == $fund ? 'selected' : '' }} class="text-slate-900">
                                                {{ $fund }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specific_fund')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col">
                                    <label for="current_prior" class="text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Category</label>
                                    <select name="current_prior" id="current_prior" class="rounded-xl border border-slate-300 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer">
                                        <option value="" class="text-slate-900">Select</option>
                                        <option value="Current" {{ old('current_prior') == 'Current' ? 'selected' : '' }} class="text-slate-900">Current</option>
                                        <option value="Prior" {{ old('current_prior') == 'Prior' ? 'selected' : '' }} class="text-slate-900">Prior</option>
                                        <option value="Continuing" {{ old('current_prior') == 'Continuing' ? 'selected' : '' }} class="text-slate-900">Continuing</option>
                                    </select>
                                    @error('current_prior')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex flex-col">
                                    <label for="transaction_date" class="text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Transaction Date</label>
                                    <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 text-slate-900 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100" required>
                                    @error('transaction_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="type" value="{{ old('type', 'expense') }}">
                        <input type="hidden" name="description" value="">

                        <div class="flex flex-col sm:flex-row items-center justify-center mt-10 pt-8 border-t border-slate-100 gap-6">
                            <button type="button" class="min-w-[200px] bg-slate-100 hover:bg-slate-200 text-slate-700 font-black py-4 px-8 rounded-xl text-center shadow-sm transform transition duration-300 active:scale-95 uppercase tracking-wider text-sm">
                                Multiple Check Entry
                            </button>
                            <button type="submit" class="min-w-[200px] bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-black py-4 px-8 rounded-xl text-center shadow-lg transform transition duration-300 hover:-translate-y-1 hover:scale-105 active:scale-95 uppercase tracking-wider text-sm">
                                Save Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>