<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Transaction; // Import Transaction model to access SPECIFIC_FUNDS
use Illuminate\Validation\Rule; // Import Rule class for validation
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DepositController extends Controller
{
/**
     * Display a listing of the resource.
     * Optimized: Added select() to reduce payload and improve performance
     */
    public function index(Request $request)
    {
        // Only select needed columns to reduce memory usage and speed up queries
        $query = Deposit::where('user_id', Auth::id())
            ->select('id', 'cheque_number', 'payee', 'nature_of_payment', 'amount', 'specific_fund', 'description', 'deposit_date', 'status', 'created_at');

        // Search by Cheque Number
        if ($request->filled('search')) {
            $query->where('cheque_number', 'like', "%{$request->search}%");
        }

        $deposits = $query->orderBy('created_at', 'desc')->paginate(6)->withQueryString();

        return view('deposits.index', compact('deposits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('deposits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'cheque_number' => 'nullable|string|max:255',
            'payee' => 'nullable|string|max:255',
            'nature_of_payment' => 'nullable|string',
            'specific_fund' => [
                'required',
                Rule::in(Transaction::SPECIFIC_FUNDS),
            ],
            'deposit_date' => 'required|date',
        ]);

        Deposit::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'cheque_number' => $request->cheque_number,
            'payee' => $request->payee,
            'nature_of_payment' => $request->nature_of_payment,
            'specific_fund' => $request->specific_fund,
            'deposit_date' => $request->deposit_date,
        ]);

        return redirect()->route('deposits.index')->with('success', 'Deposit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $deposit = Deposit::where('user_id', Auth::id())->findOrFail($id);

        return view('deposits.show', compact('deposit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $deposit = Deposit::where('user_id', Auth::id())->findOrFail($id);

        return view('deposits.edit', compact('deposit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $deposit = Deposit::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'cheque_number' => 'nullable|string|max:255',
            'payee' => 'nullable|string|max:255',
            'nature_of_payment' => 'nullable|string',
            'specific_fund' => [
                'required',
                Rule::in(Transaction::SPECIFIC_FUNDS),
            ],
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'deposit_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $deposit->update($request->only(['cheque_number', 'payee', 'nature_of_payment', 'specific_fund', 'amount', 'description', 'deposit_date', 'status']));

        return redirect()->route('deposits.index')->with('success', 'Deposit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deposit = Deposit::where('user_id', Auth::id())->findOrFail($id);

        $deposit->delete();

        return redirect()->route('deposits.index')->with('success', 'Deposit deleted successfully.');
    }
}
