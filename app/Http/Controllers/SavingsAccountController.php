<?php

namespace App\Http\Controllers;

use App\Models\SavingsAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SavingsAccountController extends Controller
{

    public function index()
    {
        $accounts = SavingsAccount::with('user')->latest()->get();
        $users = User::all();

        return view('savings_accounts.index', compact('accounts', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,frozen',
            'type' => 'required|in:basic,goal_based,fixed_term',
            'interest_rate' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        $account = DB::transaction(function () use ($request) {
            $lastAccount = SavingsAccount::orderBy('id', 'desc')->lockForUpdate()->first(); // row lock

            $lastNumber = $lastAccount ? (int)substr($lastAccount->account_number, -6) : 0;
            $newAccountNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);

            return SavingsAccount::create([
                'user_id' => $request->user_id,
                'account_number' => $newAccountNumber,
                'balance' => 0,
                'status' => $request->status,
                'type' => $request->type,
                'interest_rate' => $request->interest_rate,
            ]);
        });

        // Notify user
        $user = \App\Models\User::find($request->user_id);
        $user->notify(new \App\Notifications\SavingsAccountCreated());

        return redirect()->route('savings-accounts.index')->with('success', 'Savings account created.');
    }

    public function update(Request $request, $id)
    {
        try {
            // Retrieve the savings account by its ID
            $account = SavingsAccount::findOrFail($id);

            // Validate the incoming request data
            $request->validate([
                'account_number' => 'required|unique:savings_accounts,account_number,' . $account->id,
                'balance' => 'required|numeric|min:0',
                'status' => 'required|in:active,inactive,frozen',
                'type' => 'required|in:basic,goal_based,fixed_term',
                'interest_rate' => 'required|numeric|min:0',
            ]);

            // Update the account with the validated data, excluding 'user_id' (it won't change)
            $account->update([
                'account_number' => $request->account_number,
                'balance' => $request->balance,
                'status' => $request->status,
                'type' => $request->type,
                'interest_rate' => $request->interest_rate,
            ]);

            // Return back to the index page with a success message
            return redirect()->route('savings-accounts.index')->with('success', 'Savings account updated.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Failed to update savings account. Error: ' . $e->getMessage());

            // Return back with an error message
            return redirect()->back()->with('error', 'Failed to update savings account. Please try again.');
        }
    }


public function destroy($id)
{
    $account = SavingsAccount::findOrFail($id);
    $account->delete();

    return redirect()->route('savings-accounts.index')->with('success', 'Savings account deleted.');
}

}
