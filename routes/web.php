<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MySavingsAccountController;
use App\Http\Controllers\MySavingsGoalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavingsAccountController;
use App\Http\Controllers\SavingsGoalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::put('/savings-accounts/{account}', [SavingsAccountController::class, 'update'])->name('savings-accounts.update');
    Route::delete('/savings-accounts/{account}', [SavingsAccountController::class, 'destroy'])->name('savings-accounts.destroy');
    Route::get('/savings-accounts/{account}/edit', [SavingsAccountController::class, 'edit'])->name('savings-accounts.edit');
    Route::get('/savings-accounts/create', [SavingsAccountController::class, 'create'])->name('savings-accounts.create');
    Route::post('/savings-accounts', [SavingsAccountController::class, 'store'])->name('savings-accounts.store');
    Route::get('/savings-accounts', [SavingsAccountController::class, 'index'])->name('savings-accounts.index');
    Route::get('/savings-accounts/{account}', [SavingsAccountController::class, 'show'])->name('savings-accounts.show');


    Route::get('/savings-goals/create', [\App\Http\Controllers\SavingsGoalController::class, 'create'])->name('savings-goals.create');
    Route::post('/savings-goals', [\App\Http\Controllers\SavingsGoalController::class, 'store'])->name('savings-goals.store');
    Route::get('/savings-goals/{savingsGoal}/edit', [\App\Http\Controllers\SavingsGoalController::class, 'edit'])->name('savings-goals.edit');
    Route::put('/savings-goals/{savingsGoal}', [\App\Http\Controllers\SavingsGoalController::class, 'update'])->name('savings-goals.update');
    Route::delete('/savings-goals/{savingsGoal}', [\App\Http\Controllers\SavingsGoalController::class, 'destroy'])->name('savings-goals.destroy');
    Route::get('/savings-goals', [\App\Http\Controllers\SavingsGoalController::class, 'index'])->name('savings-goals.index');



    Route::get('/my-savings-account', [MySavingsAccountController::class, 'index'])->name('my-savings-account.index');
    Route::post('/my-savings-account/{id}/deposit', [MySavingsAccountController::class, 'deposit'])->name('savings.deposit');
    Route::post('/my-savings-account/{id}/withdraw', [MySavingsAccountController::class, 'withdraw'])->name('savings.withdraw');
    Route::get('/my-savings-account/{id}/transactions', [MySavingsAccountController::class, 'transactions'])->name('savings.transactions');
    Route::get('/my-savings-account/{id}/transactions/{transaction}', [MySavingsAccountController::class, 'transactionDetails'])->name('savings.transaction-details');
    Route::post('/my-savings-account/{id}/transfer', [MySavingsAccountController::class, 'transfer'])->name('my-savings-account.transfer');
    Route::get('/my-savings-account/{id}/transfer/create', [MySavingsAccountController::class, 'createTransfer'])->name('my-savings-account.transfer.create');
    Route::get('/my-savings-account/{id}/transfer/{transaction}', [MySavingsAccountController::class, 'transferDetails'])->name('my-savings-account.transfer-details');


    Route::get('/my-savings-goals', [MySavingsGoalController::class, 'index'])->name('my-savings-goals.index');
    Route::post('/my-savings-goals', [ MySavingsGoalController::class, 'store'])->name('savings.goals.store');
    Route::post('/my-savings-goals/contribute', [ MySavingsGoalController::class, 'contribute'])->name('savings.goals.contribute');
    Route::put('/my-savings-goals', [ MySavingsGoalController::class, 'update'])->name('savings.goals.update');
    Route::delete('/my-savings-goals', [ MySavingsGoalController::class, 'destroy'])->name('savings.goals.delete');
    Route::post('/my-savings-goals/details', [ MySavingsGoalController::class, 'getGoalDetails'])->name('savings.goals.details');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/my-transactions', [\App\Http\Controllers\MyTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/my-transactions/{transaction}/edit', [\App\Http\Controllers\MyTransactionController::class, 'edit'])->name('my-transactions.edit');
    Route::put('/my-transactions/{transaction}', [\App\Http\Controllers\MyTransactionController::class, 'update'])->name('my-transactions.update');
    Route::delete('/my-transactions/{transaction}', [\App\Http\Controllers\MyTransactionController::class, 'destroy'])->name('my-transactions.destroy');
    Route::post('/transactions/export', [App\Http\Controllers\MyTransactionController::class, 'export'])
    ->name('transactions.export');

    Route::get('/transactions/{transaction}', [App\Http\Controllers\MyTransactionController::class, 'show'])
        ->name('transactions.show');


        Route::get('/profile/skip-completion', [App\Http\Controllers\ProfileController::class, 'skipProfileCompletion'])
        ->name('skip-profile-completion');

        Route::post('/profile/complete', [App\Http\Controllers\ProfileController::class, 'completeProfile'])
        ->name('profile.complete');


           // User preferences
    Route::put('/preferences/update', [App\Http\Controllers\PreferencesController::class, 'update'])
    ->name('preferences.update');

    // User preferences
    Route::put('/preferences', [App\Http\Controllers\PreferencesController::class, 'reset'])
    ->name('preferences.reset');


    // Update profile information
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])
        ->name('profile.update');

    // Update profile photo
    Route::post('/profile/photo', [App\Http\Controllers\ProfileController::class, 'updatePhoto'])
        ->name('profile.photo');

    // Password update
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])
        ->name('password.update');






});

require __DIR__.'/auth.php';
