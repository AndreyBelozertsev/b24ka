<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'name',
        'bitrix_user_id',
        'status'
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

}
