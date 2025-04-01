<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use MoonShine\Laravel\Models\MoonshineUser as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MoonShine\Permissions\Traits\HasMoonShinePermissions;


class MoonshineUser extends Model
{
        /** @use HasFactory<\Database\Factories\UserFactory> */
        use Notifiable, HasMoonShinePermissions;

        /**
         * The attributes that are mass assignable.
         *
         * @var list<string>
         */
        protected $fillable = [
            'name',
            'email',
            'password',
        ];
    
        /**
         * The attributes that should be hidden for serialization.
         *
         * @var list<string>
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];
    
}
