<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalContribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'amount',
        'source',
        'description',
    ];

    public function goal()
    {
        return $this->belongsTo(SavingsGoal::class, 'goal_id');
    }
}
