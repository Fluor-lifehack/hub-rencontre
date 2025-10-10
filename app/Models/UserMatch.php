<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'user_id',
        'matched_user_id',
        'compatibility_score',
        'is_mutual',
        'uuid',
    ];

    protected function casts(): array
    {
        return [
            'compatibility_score' => 'decimal:2',
            'is_mutual' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function matchedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'matched_user_id');
    }
}
