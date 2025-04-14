<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'savings_account_id',
        'name',
        'description',
        'target_amount',
        'current_amount',
        'target_date',
        'status',
        'is_completed',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savingsAccount()
    {
        return $this->belongsTo(SavingsAccount::class);
    }
}
