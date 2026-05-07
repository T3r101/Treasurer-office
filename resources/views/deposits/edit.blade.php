<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Deposit') }}
        </h2>
    </x-slot>

    <div class="py-2 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-2">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-1">
                    <div>
                        <h1 class="text-3xl font-black text-slate-950 tracking-tight">Edit Deposit</h1>
                        <p class="text-slate-500 font-semibold text-sm">Update existing deposit details</p>
                    </div>
                </div>

                <!-- Form Box -->
                <div class="bg-white rounded-3xl p-4 border border-slate-200/60 shadow-xl shadow-slate-200/30">
                    <form method="POST" action="{{ route('deposits.update', $deposit) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Left Column -->
                            <div class="space-y-2">
                                <div>
                                    <label for="amount" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Amount</label>
                                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $deposit->amount) }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100" required>
                                    @error('amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="cheque_number" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Cheque Number</label>
                                    <input type="text" name="cheque_number" id="cheque_number" value="{{ old('cheque_number', $deposit->cheque_number) }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100">
                                    @error('cheque_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="payee" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Payee</label>
                                    <input type="text" name="payee" id="payee" value="{{ old('payee', $deposit->payee) }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100">
                                    @error('payee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-2">
                                <div>
                                    <label for="nature_of_payment" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-1">Nature of Payment</label>
                                    <textarea name="nature_of_payment" id="nature_of_payment" rows="1" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-2 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100">{{ old('nature_of_payment', $deposit->nature_of_payment) }}</textarea>
                                    @error('nature_of_payment')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="specific_fund" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Specific Fund</label>
                                    <select name="specific_fund" id="specific_fund" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer" required>
                                        <option value="" disabled {{ old('specific_fund', $deposit->specific_fund ?? '') == '' ? 'selected' : '' }} class="text-slate-900">
                                            -- Select Specific Fund --
                                        </option>
                                        @foreach(\App\Models\Transaction::SPECIFIC_FUNDS as $fund)
                                            <option value="{{ $fund }}" {{ (old('specific_fund') ?? ($deposit->specific_fund ?? '')) == $fund ? 'selected' : '' }} class="text-slate-900">
                                                {{ $fund }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('specific_fund')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="deposit_date" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Deposit Date</label>
                                    <input type="date" name="deposit_date" id="deposit_date" value="{{ old('deposit_date', $deposit->deposit_date->format('Y-m-d')) }}" 
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-slate-900 p-3 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:bg-white focus:border-transparent outline-none transition hover:bg-slate-100" required>
                                    @error('deposit_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="description" value="{{ $deposit->description }}">
                        <input type="hidden" name="status" value="{{ $deposit->status }}">

                        <div class="flex items-center justify-center mt-4 pt-2 border-t border-slate-200 space-x-4">
                            <a href="{{ route('deposits.index') }}" class="px-6 py-3 text-slate-600 font-bold hover:text-slate-900 border border-slate-200 rounded-xl hover:bg-slate-50 transition-all duration-300 cursor-pointer">
                                Cancel
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-black py-3 px-8 rounded-xl transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-lg">
                                Update Deposit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>