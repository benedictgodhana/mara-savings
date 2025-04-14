<?php

namespace App\Http\Controllers;

use App\Models\GoalContribution;
use App\Models\SavingsAccount;
use App\Models\SavingsGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MySavingsGoalController extends Controller
{



    public function index()
    {
        $user = auth()->user();

        $goals = SavingsGoal::where('user_id', $user->id)
            ->orderBy('is_completed')
            ->orderBy('target_date')
            ->paginate(9);

        $activeGoals = SavingsGoal::where('user_id', $user->id)
            ->where('is_completed', false)
            ->count();

        $completedGoals = SavingsGoal::where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();

        $totalSaved = SavingsGoal::where('user_id', $user->id)
            ->sum('current_amount');

        $savingsAccount = SavingsAccount::where('user_id', $user->id)->first();

        return view('user.my-saving-goals', compact(
            'goals',
            'activeGoals',
            'completedGoals',
            'totalSaved',
            'savingsAccount' // 👈 include this
        ));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'initial_amount' => 'nullable|numeric|min:0',
            'target_date' => 'required|date|after:today',
            'description' => 'nullable|string',
            'savings_account_id' => 'required|exists:savings_accounts,id',
        ]);

        $user = auth()->user();
        $initialAmount = $request->initial_amount ?? 0;

        DB::beginTransaction();

        try {
            $goal = SavingsGoal::create([
                'user_id' => $user->id,
                'savings_account_id' => $request->savings_account_id,
                'name' => $request->name,
                'description' => $request->description,
                'target_amount' => $request->target_amount,
                'current_amount' => $initialAmount,
                'target_date' => $request->target_date,
                'status' => ($initialAmount >= $request->target_amount) ? 'completed' : 'ongoing',
            ]);

            if ($initialAmount > 0) {
                GoalContribution::create([
                    'goal_id' => $goal->id,
                    'amount' => $initialAmount,
                    'source' => 'external',
                    'description' => 'Initial contribution',
                ]);
            }

            DB::commit();

            return redirect()->route('my-savings-goals.index')
                ->with('success', 'Savings goal created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error
            Log::error('Failed to create savings goal', [
                'user_id' => $user->id,
                'goal_name' => $request->name,
                'target_amount' => $request->target_amount,
                'initial_amount' => $initialAmount,
                'savings_account_id' => $request->savings_account_id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Failed to create savings goal: ' . $e->getMessage());
        }
    }


    public function contribute(Request $request)
    {
        $request->validate([
            'goal_id' => 'required|exists:savings_goals,id',
            'amount' => 'required|numeric|min:1',
            'source' => 'required|in:savings,external',
        ]);

        $user = auth()->user();
        $goal = SavingsGoal::where('user_id', $user->id)
            ->findOrFail($request->goal_id);

        DB::beginTransaction();

        try {
            if ($request->source === 'savings') {
                // Retrieve the user's savings account
                $account = SavingsAccount::where('user_id', $user->id)
                    ->where('type', 'savings')
                    ->first();

                if (!$account) {
                    // Optionally, create a savings account if none exists
                    $account = SavingsAccount::create([
                        'user_id' => $user->id,
                        'type' => 'savings',
                        'balance' => 0, // Set initial balance to 0
                    ]);

                    Log::info("Created new savings account for user ID: {$user->id}");
                }

                // Check if the account has sufficient funds
                if ($account->balance < $request->amount) {
                    return back()->with('error', 'Insufficient funds in your savings account.');
                }

                // Deduct the amount from the savings account
                $account->balance -= $request->amount;
                $account->save();

                // Optionally log this transaction if you have a transaction system
                // Transaction::create([...]);

                // Log the deduction for debugging
                Log::info("Deducted " . $request->amount . " from savings account. New balance: " . $account->balance);
            }

            // Add the contribution to the goal
            $goal->current_amount += $request->amount;

            // Check if the goal is now completed
            if ($goal->current_amount >= $goal->target_amount && !$goal->is_completed) {
                $goal->is_completed = true;
            }

            // Save the updated goal
            $goal->save();

            // Record the contribution in the GoalContribution table
            GoalContribution::create([
                'goal_id' => $goal->id,
                'amount' => $request->amount,
                'source' => $request->source,
                'description' => 'Contribution to ' . $goal->name,
            ]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('my-savings-goals.index')
                ->with('success', 'Contribution of KES ' . number_format($request->amount) . ' added to goal successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error while contributing to goal: " . $e->getMessage());
            return back()->with('error', 'Failed to contribute to goal. Please try again.');
        }
    }

    /**
     * Update a savings goal
     */
    public function update(Request $request)
    {
        $request->validate([
            'goal_id' => 'required|exists:savings_goals,id',
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'target_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $user = auth()->user();
        $goal = SavingsGoal::where('user_id', $user->id)
            ->findOrFail($request->goal_id);

        try {
            $goal->name = $request->name;
            $goal->description = $request->description;
            $goal->target_amount = $request->target_amount;
            $goal->target_date = $request->target_date;

            // Check if goal completion status has changed
            if ($goal->current_amount >= $goal->target_amount && !$goal->is_completed) {
                $goal->is_completed = true;
            } elseif ($goal->current_amount < $goal->target_amount && $goal->is_completed) {
                $goal->is_completed = false;
            }

            $goal->save();

            return redirect()->route('my-savings-goals.index')
                ->with('success', 'Savings goal updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update savings goal. Please try again.');
        }
    }

    /**
     * Delete a savings goal
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'goal_id' => 'required|exists:savings_goals,id',
        ]);

        $user = auth()->user();
        $goal = SavingsGoal::where('user_id', $user->id)
            ->findOrFail($request->goal_id);

        try {
            // You might want to transfer remaining funds back to the savings account
            // before deleting the goal, depending on your business logic

            $goal->delete();

            return redirect()->route('my-savings-goals.index')
                ->with('success', 'Savings goal deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete savings goal. Please try again.');
        }
    }

    /**
     * Get goal details (for AJAX)
     */
    public function getGoalDetails(Request $request)
    {
        $request->validate([
            'goal_id' => 'required|exists:savings_goals,id',
        ]);

        $user = auth()->user();
        $goal = SavingsGoal::where('user_id', $user->id)
            ->findOrFail($request->goal_id);

        return response()->json([
            'name' => $goal->name,
            'description' => $goal->description,
            'target_amount' => $goal->target_amount,
            'current_amount' => $goal->current_amount,
            'target_date' => $goal->target_date->format('Y-m-d'),
        ]);
    }
}
