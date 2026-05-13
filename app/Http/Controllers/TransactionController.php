<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Validation\Rule; // Import Rule class for validation
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionController extends Controller
{
/**
     * Display a listing of the resource.
     * Optimized: Added select() to reduce payload and improve performance
     */
    public function index(Request $request)
    {
        // Only select needed columns to reduce memory usage and speed up queries
        $query = Transaction::withoutGlobalScopes()->select('id', 'check_no', 'office', 'payee', 'nature_of_payment', 'amount_issued', 'account_code', 'specific_fund', 'current_prior', 'amount', 'type', 'description', 'transaction_date', 'status', 'created_at');

        // Search by Check No, Payee, or Office
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('check_no', 'like', "%{$search}%")
                  ->orWhere('payee', 'like', "%{$search}%")
                  ->orWhere('office', 'like', "%{$search}%");
            });
        }

        // Filter by Specific Fund
        if ($request->filled('specific_fund')) {
            $query->where('specific_fund', $request->specific_fund);
        }

        // Filter by Fund Category (Current/Prior/Continuing)
        if ($request->filled('current_prior')) {
            $query->where('current_prior', $request->current_prior);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(6)->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Export transactions to Excel (CSV format).
     */
    public function exportExcel(Request $request)
    {
        $query = Transaction::withoutGlobalScopes();

        // Apply the same filters as the index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('check_no', 'like', "%{$search}%")
                  ->orWhere('payee', 'like', "%{$search}%")
                  ->orWhere('office', 'like', "%{$search}%");
            });
        }

        if ($request->filled('specific_fund')) {
            $query->where('specific_fund', $request->specific_fund);
        }

        if ($request->filled('current_prior')) {
            $query->where('current_prior', $request->current_prior);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="transactions_' . date('Ymd_His') . '.xls"', // Changed extension to .xls
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Check No', 'Office', 'Payee', 'Nature of Payment', 'Amount Issued', 
                'Account Code', 'Specific Fund', 'Category', 'Date'
            ]);

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->check_no ?? '-', $transaction->office ?? '-', $transaction->payee, 
                    $transaction->nature_of_payment ?? '', number_format($transaction->amount_issued, 2),
                    $transaction->account_code ?? '-', $transaction->specific_fund, $transaction->current_prior ?? 'Current',
                    $transaction->transaction_date->format('M d, Y'),
                ]);
            }
            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'check_no' => 'nullable|string|max:255',
            'office' => 'nullable|string|max:255',
            'payee' => 'nullable|string|max:255',
            'nature_of_payment' => 'nullable|string',
            'amount_issued' => 'nullable|numeric|min:0',
            'account_code' => 'nullable|string|max:255',
            'specific_fund' => [
                'required',
                Rule::in(Transaction::SPECIFIC_FUNDS),
            ],
            'current_prior' => 'nullable|in:Current,Prior,Continuing',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'check_no' => $request->check_no,
            'office' => $request->office,
            'payee' => $request->payee,
            'nature_of_payment' => $request->nature_of_payment,
            'amount_issued' => $request->amount_issued,
            'account_code' => $request->account_code,
            'specific_fund' => $request->specific_fund,
            'current_prior' => $request->current_prior,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::findOrFail($id);

        $request->validate([
            'check_no' => 'nullable|string|max:255',
            'office' => 'nullable|string|max:255',
            'payee' => 'nullable|string|max:255',
            'nature_of_payment' => 'nullable|string',
            'amount_issued' => 'nullable|numeric|min:0',
            'account_code' => 'nullable|string|max:255',
            'specific_fund' => [
                'required',
                Rule::in(Transaction::SPECIFIC_FUNDS),
            ],
            'current_prior' => 'nullable|in:Current,Prior,Continuing',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $transaction->update($request->only(['check_no', 'office', 'payee', 'nature_of_payment', 'amount_issued', 'account_code', 'specific_fund', 'current_prior', 'amount', 'type', 'description', 'transaction_date', 'status']));

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->delete();

        return redirect()->back()->with('success', 'Transaction deleted successfully.');
    }
}
