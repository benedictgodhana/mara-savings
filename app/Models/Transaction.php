<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'savings_account_id',
        'reference_number',
        'amount',
        'type',
        'status',
        'goal_id',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate a unique reference number before creating a new transaction
        static::creating(function ($transaction) {
            if (!$transaction->reference_number) {
                $transaction->reference_number = 'TRX-' . strtoupper(Str::random(10));
            }
        });
    }

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the savings account that the transaction belongs to.
     */
    public function savingsAccount()
    {
        return $this->belongsTo(SavingsAccount::class, 'savings_account_id');
    }

    /**
     * Get the savings goal associated with the transaction, if any.
     */
    public function goal()
    {
        return $this->belongsTo(SavingsGoal::class, 'goal_id');
    }

    /**
     * Scope a query to only include completed transactions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include pending transactions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include deposits.
     */
    public function scopeDeposits($query)
    {
        return $query->where('type', 'deposit');
    }

    /**
     * Scope a query to only include withdrawals.
     */
    public function scopeWithdrawals($query)
    {
        return $query->where('type', 'withdrawal');
    }

    /**
     * Scope a query to only include transfers.
     */
    public function scopeTransfers($query)
    {
        return $query->where('type', 'transfer');
    }

    /**
     * Scope a query to only include interest payments.
     */
    public function scopeInterest($query)
    {
        return $query->where('type', 'interest');
    }

    /**
     * Check if the transaction is a deposit.
     */
    public function isDeposit()
    {
        return $this->type === 'deposit';
    }

    /**
     * Check if the transaction is a withdrawal.
     */
    public function isWithdrawal()
    {
        return $this->type === 'withdrawal';
    }

    /**
     * Check if the transaction is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the transaction is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the transaction is failed.
     */
    public function isFailed()
    {
        return $this->status === 'failed';
    }

    /**
     * Mark the transaction as completed.
     */
    public function markAsCompleted()
    {
        $this->status = 'completed';
        return $this->save();
    }

    /**
     * Mark the transaction as failed.
     */
    public function markAsFailed()
    {
        $this->status = 'failed';
        return $this->save();
    }

    /**
     * Mark the transaction as reversed.
     */
    public function markAsReversed()
    {
        $this->status = 'reversed';
        return $this->save();
    }
}
