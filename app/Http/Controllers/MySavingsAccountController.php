<?php

namespace App\Http\Controllers;

use App\Models\SavingsAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MySavingsAccountController extends Controller
{
    /**
     * Display the user's savings account page
     */
    public function index()
    {
        $user = Auth::user();
        $account = SavingsAccount::where('user_id', $user->id)->firstOrFail();
        $transactions = Transaction::where('savings_account_id', $account->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get chart data for the last 6 months
        $chartData = $this->getAccountBalanceHistory($account->id);

        return view('user.my-savings-account', compact('account', 'transactions', 'chartData'));
    }

    /**
     * Process a deposit to the savings account
     */
    public function deposit(Request $request, $id)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'description' => 'nullable|string|max:255',
    ]);

    $account = SavingsAccount::findOrFail($id);

    // Ensure user owns this account
    if ($account->user_id !== Auth::id()) {
        return back()->with('error', 'Unauthorized action.');
    }

    try {
        DB::beginTransaction();

        // Update account balance
        $newBalance = $account->balance + $request->amount;
        $account->balance = $newBalance;
        $account->save();

        // Generate a unique reference number for the transaction
        $referenceNumber = 'REF-' . strtoupper(uniqid(date('Ymd') . '-', true));

        // Record transaction
        Transaction::create([
            'user_id' => Auth::id(),
            'savings_account_id' => $account->id,
            'reference_number' => $referenceNumber, // Store the reference number
            'amount' => $request->amount,
            'type' => 'deposit',
            'status' => 'completed', // You can modify this based on your application logic
            'goal_id' => $request->goal_id ?? null, // Optional: use if there's a goal ID tied to the transaction
            'description' => $request->description ?? 'Deposit to savings account',
        ]);

        DB::commit();

        return redirect()->route('savings.account')
            ->with('success', 'Successfully deposited KES ' . number_format($request->amount, 2) . ' to your savings account. Reference: ' . $referenceNumber);
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Transaction failed: ' . $e->getMessage());
    }
}

public function withdraw(Request $request, $id)
{
    $account = SavingsAccount::findOrFail($id);

    $request->validate([
        'amount' => 'required|numeric|min:1|max:' . $account->balance,
        'description' => 'nullable|string|max:255',
    ]);

    // Ensure user owns this account
    if ($account->user_id !== Auth::id()) {
        return back()->with('error', 'Unauthorized action.');
    }

    try {
        DB::beginTransaction();

        // Update account balance
        $newBalance = $account->balance - $request->amount;
        $account->balance = $newBalance;
        $account->save();

        // Generate a unique reference number for the transaction
        $referenceNumber = 'REF-' . strtoupper(uniqid(date('Ymd') . '-', true));

        // Record transaction
        Transaction::create([
            'user_id' => Auth::id(),
            'savings_account_id' => $account->id,
            'reference_number' => $referenceNumber, // Store the reference number
            'amount' => $request->amount,
            'type' => 'withdrawal',
            'status' => 'completed', // You can modify this based on your application logic
            'goal_id' => $request->goal_id ?? null, // Optional: use if there's a goal ID tied to the transaction
            'description' => $request->description ?? 'Withdrawal from savings account',
        ]);

        DB::commit();

        return redirect()->route('savings.account')
            ->with('success', 'Successfully withdrew KES ' . number_format($request->amount, 2) . ' from your savings account. Reference: ' . $referenceNumber);
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Transaction failed: ' . $e->getMessage());
    }
}


    /**
     * Get account balance history for chart
     */
    private function getAccountBalanceHistory($accountId)
    {
        // Get daily balance for the last 6 months
        $sixMonthsAgo = Carbon::now()->subMonths(6)->startOfDay();

        // Get all transactions in the period
        $transactions = Transaction::where('savings_account_id', $accountId)
            ->where('created_at', '>=', $sixMonthsAgo)
            ->orderBy('created_at')
            ->get();

        // If no transactions, return empty collection
        if ($transactions->isEmpty()) {
            return collect();
        }

        // Get initial balance (balance before the first transaction in our period)
        $initialBalance = 0;
        $firstTransaction = Transaction::where('savings_account_id', $accountId)
            ->where('created_at', '<', $sixMonthsAgo)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($firstTransaction) {
            $initialBalance = $firstTransaction->balance_after;
        }

        // Create data points for the chart (one per week)
        $startDate = $sixMonthsAgo->copy();
        $endDate = Carbon::now();
        $currentDate = $startDate->copy();
        $chartData = collect();
        $currentBalance = $initialBalance;
        $transactionIndex = 0;

        while ($currentDate <= $endDate) {
            // Process all transactions up to this date
            while ($transactionIndex < $transactions->count() &&
                  $transactions[$transactionIndex]->created_at <= $currentDate) {
                $currentBalance = $transactions[$transactionIndex]->balance_after;
                $transactionIndex++;
            }

            // Add data point
            $chartData->push([
                'date' => $currentDate->format('M d'),
                'balance' => $currentBalance
            ]);

            // Move to next week
            $currentDate->addWeek();
        }

        return $chartData;
    }

    /**
     * Calculate and add interest to the account (would be called by a scheduled task)
     */
    public function calculateInterest($accountId)
    {
        $account = SavingsAccount::findOrFail($accountId);

        // Simple interest calculation (monthly)
        $interestRate = $account->interest_rate / 100 / 12; // Convert annual rate to monthly
        $interestAmount = $account->balance * $interestRate;

        try {
            DB::beginTransaction();

            // Update account balance
            $newBalance = $account->balance + $interestAmount;
            $account->balance = $newBalance;
            $account->save();

            // Record transaction
            Transaction::create([
                'account_id' => $account->id,
                'type' => 'interest',
                'amount' => $interestAmount,
                'description' => 'Monthly interest credit',
                'balance_after' => $newBalance,
            ]);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
