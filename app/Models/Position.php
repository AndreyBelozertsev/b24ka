<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Position extends Model
{
    protected $fillable = [
        'title',
        'status',
        'sort',
    ];

    public function staffs():Staff
    {
        return $this->hasMany(Staff::class);
    }
}
