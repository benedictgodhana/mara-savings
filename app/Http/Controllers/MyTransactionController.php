<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class MyTransactionController extends Controller
{
    public function index(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Start with query for user's transactions
        $query = Transaction::where('user_id', $user->id);

        // Apply filters if present
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Get transactions with pagination
        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate summary statistics
        $totalDeposits = Transaction::where('user_id', $user->id)
            ->where('type', 'deposit')
            ->where('status', 'completed')
            ->sum('amount');

        $totalWithdrawals = Transaction::where('user_id', $user->id)
            ->where('type', 'withdrawal')
            ->where('status', 'completed')
            ->sum('amount');

        $goalContributions = Transaction::where('user_id', $user->id)
            ->where('type', 'goal_contribution')
            ->where('status', 'completed')
            ->sum('amount');

        $netBalance = $totalDeposits - $totalWithdrawals;

        // Prepare chart data (last 6 months)
        $chartData = $this->prepareChartData($user->id);

        // Get all transaction details for the current page
        $transactionDetails = [];
        foreach ($transactions as $transaction) {
            // Get the savings account name
            $accountName = null;
            if ($transaction->savings_account_id) {
                $account = \App\Models\SavingsAccount::find($transaction->savings_account_id);
                $accountName = $account ? $account->name : 'Savings Account';
            } else {
                $accountName = 'Savings Account';
            }

            // Get the goal name if applicable
            $goalName = null;
            if ($transaction->goal_id) {
                $goal = \App\Models\SavingsGoal::find($transaction->goal_id);
                $goalName = $goal ? $goal->name : null;
            }

            // Store transaction details
            $transactionDetails[$transaction->id] = [
                'id' => $transaction->id,
                'reference_number' => $transaction->reference_number,
                'amount' => $transaction->amount,
                'type' => $transaction->type,
                'status' => $transaction->status,
                'description' => $transaction->description ?: 'No description provided',
                'created_at' => $transaction->created_at,
                'updated_at' => $transaction->updated_at,
                'account_name' => $accountName,
                'goal_name' => $goalName,
            ];
        }

        // Convert to JSON for use in JavaScript
        $transactionDetailsJson = json_encode($transactionDetails);

        return view('user.my-transactions', compact(
            'transactions',
            'totalDeposits',
            'totalWithdrawals',
            'goalContributions',
            'netBalance',
            'chartData',
            'transactionDetailsJson'
        ));
    }

    /**
     * Prepare chart data for transaction history visualization
     *
     * @param int $userId
     * @return array
     */
    private function prepareChartData($userId)
    {
        // Get data for the last 6 months
        $startDate = now()->subMonths(5)->startOfMonth();
        $endDate = now()->endOfMonth();

        // Generate month labels
        $labels = [];
        $deposits = [];
        $withdrawals = [];
        $contributions = [];

        $currentDate = clone $startDate;

        while ($currentDate <= $endDate) {
            $month = $currentDate->format('M Y');
            $labels[] = $month;

            // Get monthly data
            $monthStart = clone $currentDate;
            $monthEnd = clone $currentDate->endOfMonth();

            // Deposits for month
            $monthlyDeposits = Transaction::where('user_id', $userId)
                ->where('type', 'deposit')
                ->where('status', 'completed')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('amount');
            $deposits[] = $monthlyDeposits;

            // Withdrawals for month
            $monthlyWithdrawals = Transaction::where('user_id', $userId)
                ->where('type', 'withdrawal')
                ->where('status', 'completed')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('amount');
            $withdrawals[] = $monthlyWithdrawals;

            // Goal contributions for month
            $monthlyContributions = Transaction::where('user_id', $userId)
                ->where('type', 'goal_contribution')
                ->where('status', 'completed')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('amount');
            $contributions[] = $monthlyContributions;

            // Move to next month
            $currentDate->addMonth();
        }

        return [
            'labels' => $labels,
            'deposits' => $deposits,
            'withdrawals' => $withdrawals,
            'contributions' => $contributions
        ];
    }



    public function show(Transaction $transaction)
{
    // Check if the transaction belongs to the authenticated user
    if ($transaction->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Get the savings account name
    $accountName = null;
    if ($transaction->savings_account_id) {
        $account = \App\Models\SavingsAccount::find($transaction->savings_account_id);
        $accountName = $account ? $account->name : null;
    }

    // Get the goal name if applicable
    $goalName = null;
    if ($transaction->goal_id) {
        $goal = \App\Models\SavingsGoal::find($transaction->goal_id);
        $goalName = $goal ? $goal->name : null;
    }

    // Prepare transaction data
    $transactionData = [
        'id' => $transaction->id,
        'reference_number' => $transaction->reference_number,
        'amount' => $transaction->amount,
        'type' => $transaction->type,
        'status' => $transaction->status,
        'description' => $transaction->description,
        'created_at' => $transaction->created_at,
        'updated_at' => $transaction->updated_at,
        'account_name' => $accountName,
        'goal_name' => $goalName,
    ];

    return response()->json($transactionData);
}
}
