<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SavingsAccount;
use App\Models\SavingsGoal;
use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with appropriate stats based on user permissions
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $data = [];

        if ($user->can('view any dashboard stats')) {
            // For admins, managers, and super-admins who can view all stats
            $data = [
                'totalUsers' => \App\Models\User::count(),
                'totalSavingsAccounts' => SavingsAccount::count(),
                'totalSavingsGoals' => SavingsGoal::count(),
                'totalTransactions' => Transaction::count(),
                'recentTransactions' => Transaction::latest()->take(10)->get(),
                'accountBalanceSum' => SavingsAccount::sum('balance'),
                'pendingTransactions' => Transaction::where('status', 'pending')->count(),
                'goalCompletionRate' => $this->calculateGoalCompletionRate(),

                // Optional for UI reuse
                'totalBalance' => null, // prevent undefined key error
            ];
        } else if ($user->can('view own dashboard stats')) {
            // For regular users who can only view their own stats
            $data = [
                'savingsAccounts' => $user->savingsAccounts()->get(),
                'savingsAccountsCount' => $user->savingsAccounts()->count(),
                'totalBalance' => $user->savingsAccounts()->sum('balance'),
                'savingsGoals' => $user->savingsGoals()->get(),
                'savingsGoalsCount' => $user->savingsGoals()->count(),
                'goalProgress' => $this->calculateUserGoalProgress($user->id),
                'recentTransactions' => $user->transactions()->latest()->take(5)->get(),
                'transactionsCount' => $user->transactions()->count(),
                'pendingTransactions' => $user->transactions()->where('status', 'pending')->count(),
            ];
        }

        return view('dashboard', compact('data'));
    }


    /**
     * Calculate completion rate of savings goals across the system
     *
     * @return float
     */
    private function calculateGoalCompletionRate()
    {
        $totalGoals = SavingsGoal::count();
        if ($totalGoals === 0) {
            return 0;
        }

        $completedGoals = SavingsGoal::where('current_amount', '>=', 'target_amount')->count();
        return ($completedGoals / $totalGoals) * 100;
    }

    /**
     * Calculate goal progress for a specific user
     *
     * @param int $userId
     * @return array
     */
    private function calculateUserGoalProgress($userId)
    {
        $goals = SavingsGoal::where('user_id', $userId)->get();
        $progress = [];

        foreach ($goals as $goal) {
            if ($goal->target_amount > 0) {
                $percentage = min(100, ($goal->current_amount / $goal->target_amount) * 100);
            } else {
                $percentage = 0;
            }

            $progress[] = [
                'id' => $goal->id,
                'name' => $goal->name,
                'percentage' => $percentage,
                'current_amount' => $goal->current_amount,
                'target_amount' => $goal->target_amount,
                'remaining' => max(0, $goal->target_amount - $goal->current_amount),
            ];
        }

        return $progress;
    }
}
