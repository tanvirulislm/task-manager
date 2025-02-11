<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'due_date',
        'priority',
        'status',
        'is_completed',
        'completed_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
