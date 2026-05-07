<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Transaction') }}
        </h2>
    </x-slot>

    <div class="py-2 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-2">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-1">
                    <div>
                        <h1 class="text-3xl font-black text-slate-950 tracking-tight">Add Transaction</h1>
                        <p class="text-slate-500 font-semibold text-sm">Create a new transaction record</p>
                    </div>
                </div>

                <!-- Form Box -->
                <div class="bg-white rounded-3xl p-4 border border-slate-200/60 shadow-xl shadow-slate-200/30">
                    <form method="POST" action="{{ route('transactions.store') }}" class="space-y-3">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-2">
                                <div>
                                    <label for="check_no" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Check No</label>
                                    <input type="text" name="check_no" id="check_no" value="{{ old('check_no') }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100">
                                    @error('check_no')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="office" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Office</label>
                                    <input type="text" name="office" id="office" value="{{ old('office') }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100">
                                    @error('office')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="payee" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Payee</label>
                                    <input type="text" name="payee" id="payee" value="{{ old('payee') }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100">
                                    @error('payee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Middle Column -->
                            <div class="space-y-2">
                                <div>
                                    <label for="nature_of_payment" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Nature of Payment</label>
                                    <textarea name="nature_of_payment" id="nature_of_payment" rows="3" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100">{{ old('nature_of_payment') }}</textarea>
                                    @error('nature_of_payment')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="amount_issued" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Amount Issued</label>
                                    <input type="number" step="0.01" name="amount_issued" id="amount_issued" value="{{ old('amount_issued') }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100">
                                    @error('amount_issued')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="account_code" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Account Code</label>
                                    <input type="text" name="account_code" id="account_code" value="{{ old('account_code') }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100">
                                    @error('account_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-2">
                                <div>
                                    <label for="specific_fund" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Specific Fund</label>
                                    <select name="specific_fund" id="specific_fund" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer" required>
                                        <option value="" disabled {{ old('specific_fund', '') == '' ? 'selected' : '' }} class="text-slate-900">-- Select Specific Fund --</option>
                                        @foreach(\App\Models\Transaction::SPECIFIC_FUNDS as $fund)
                                            <option value="{{ $fund }}" {{ old('specific_fund') == $fund ? 'selected' : '' }} class="text-slate-900">
                                                {{ $fund }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specific_fund')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="current_prior" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Current/Prior</label>
                                    <select name="current_prior" id="current_prior" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer">
                                        <option value="" class="text-slate-900">Select</option>
                                        <option value="Current" {{ old('current_prior') == 'Current' ? 'selected' : '' }} class="text-slate-900">Current</option>
                                        <option value="Prior" {{ old('current_prior') == 'Prior' ? 'selected' : '' }} class="text-slate-900">Prior</option>
                                        <option value="Continuing" {{ old('current_prior') == 'Continuing' ? 'selected' : '' }} class="text-slate-900">Continuing</option>
                                    </select>
                                    @error('current_prior')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="transaction_date" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Date</label>
                                    <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100" required>
                                    @error('transaction_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="amount" value="0">
                        <input type="hidden" name="type" value="expense">
                        <input type="hidden" name="description" value="">

                        <div class="flex items-center justify-center mt-4 pt-2 border-t border-slate-200 space-x-4">
                            <button type="button" class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-black py-3 px-8 rounded-xl transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-lg">
                                Multiple Check Entry
                            </button>
                            <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-black py-3 px-8 rounded-xl transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-lg">
                                SAVE
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
