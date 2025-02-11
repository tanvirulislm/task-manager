<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'activity',
        'activity_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
