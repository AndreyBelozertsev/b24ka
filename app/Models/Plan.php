<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plan extends Model
{
    protected $fillable = [
        'staff_id',
        'start_period',
        'summ',
        'status',
        'conversion',
        'salary',
        'options'
    ];

    protected $casts = [
        'start_at' => 'date',
        'options' => 'array'
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    
}