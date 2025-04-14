<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_number',
        'balance',
        'status',
        'type',
        'interest_rate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
