<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'gender',
        'age',
        'country_id',
        'city_id',
        'height',
        'hobbies',
        'avatar',
    ];

    protected function casts(): array
    {
        return [
            'hobbies' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function userMatches(): HasManyThrough
    {
        return $this->hasManyThrough(
            UserMatch::class,
            User::class,
            'id', // Foreign key on users table
            'user_id', // Foreign key on user_matches table
            'user_id', // Local key on profiles table
            'id' // Local key on users table
        );
    }
}
