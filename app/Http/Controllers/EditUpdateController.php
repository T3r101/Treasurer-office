<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Http\Request;

class EditUpdateController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q', '');

        // Kuhanin ang mga unique na kamakailang Payees para sa search suggestions
        $recentPayees = Transaction::latest()->take(20)->pluck('payee')
            ->merge(Deposit::latest()->take(20)->pluck('payee'))
            ->unique()
            ->filter()
            ->values();

        // Kuhanin ang mga unique na kamakailang Check/Cheque Numbers para sa search suggestions
        $recentNumbers = Transaction::latest()->take(20)->pluck('check_no')
            ->merge(Deposit::latest()->take(20)->pluck('cheque_number'))
            ->unique()
            ->filter()
            ->values();

        if ($query) {
            $transactions = Transaction::where('check_no', 'like', "%{$query}%")
                ->orWhere('payee', 'like', "%{$query}%")
                ->get();
            $deposits = Deposit::where('cheque_number', 'like', "%{$query}%")
                ->orWhere('payee', 'like', "%{$query}%")
                ->get();
        } else {
            $transactions = Transaction::latest()->take(5)->get();
            $deposits = Deposit::latest()->take(5)->get();
        }

        return view('edit-update.index', compact('query', 'transactions', 'deposits', 'recentPayees', 'recentNumbers'));
    }
}
