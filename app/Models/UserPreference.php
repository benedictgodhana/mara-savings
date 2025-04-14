<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'email_notifications',
        'sms_notifications',
        'marketing_communications',
        'currency_display',
        'date_format',
        'dark_mode',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'marketing_communications' => 'boolean',
        'dark_mode' => 'boolean',
    ];

    /**
     * Get the user that owns the preferences.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
