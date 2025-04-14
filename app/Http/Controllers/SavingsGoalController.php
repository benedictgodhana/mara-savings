<?php
namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use App\Models\SavingsAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavingsGoalController extends Controller
{
    public function index()
    {
        $goals = SavingsGoal::with(['user', 'savingsAccount'])->get();
        return view('savings_goals.index', compact('goals'));
    }

    public function create()
    {
        $accounts = SavingsAccount::all();
        return view('savings_goals.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'savings_account_id' => 'required|exists:savings_accounts,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:1',
            'target_date' => 'nullable|date|after:today',
            'status' => 'in:active,completed,cancelled',
        ]);

        SavingsGoal::create([
            'user_id' => Auth::id(), // or $request->user_id if provided from form
            'savings_account_id' => $request->savings_account_id,
            'name' => $request->name,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'target_date' => $request->target_date,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('savings-goals.index')->with('success', 'Savings goal created successfully.');
    }

    public function edit(SavingsGoal $savingsGoal)
    {
        $accounts = SavingsAccount::all();
        return view('savings_goals.edit', compact('savingsGoal', 'accounts'));
    }

    public function update(Request $request, SavingsGoal $savingsGoal)
    {
        $request->validate([
            'savings_account_id' => 'required|exists:savings_accounts,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:1',
            'target_date' => 'nullable|date|after:today',
            'status' => 'in:active,completed,cancelled',
        ]);

        $savingsGoal->update($request->all());

        return redirect()->route('savings-goals.index')->with('success', 'Savings goal updated.');
    }

    public function destroy(SavingsGoal $savingsGoal)
    {
        $savingsGoal->delete();
        return redirect()->route('savings-goals.index')->with('success', 'Savings goal deleted.');
    }
}
