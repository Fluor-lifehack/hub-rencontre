<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_certified',
        'last_login_at',
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_certified' => 'boolean',
        ];
    }

    // Relationships
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function preferences()
    {
        return $this->hasOne(Preference::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritesAsFavorite()
    {
        return $this->hasMany(Favorite::class, 'favorite_id');
    }

    public function conversationsAsUserOne()
    {
        return $this->hasMany(Conversation::class, 'user_one');
    }

    public function conversationsAsUserTwo()
    {
        return $this->hasMany(Conversation::class, 'user_two');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function viewsAsViewer()
    {
        return $this->hasMany(View::class, 'viewer_id');
    }

    public function viewsAsViewed()
    {
        return $this->hasMany(View::class, 'viewed_id');
    }

    public function matchesAsUser()
    {
        return $this->hasMany(UserMatch::class, 'user_id');
    }

    public function matchesAsMatched()
    {
        return $this->hasMany(UserMatch::class, 'matched_user_id');
    }

    public function blocksAsBlocker()
    {
        return $this->hasMany(Block::class, 'blocker_id');
    }

    public function blocksAsBlocked()
    {
        return $this->hasMany(Block::class, 'blocked_id');
    }

    public function reportsAsReporter()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function reportsAsReported()
    {
        return $this->hasMany(Report::class, 'reported_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Relation pour toutes les conversations de l'utilisateur
    public function conversations()
    {
        return $this->conversationsAsUserOne()->union($this->conversationsAsUserTwo());
    }
}
