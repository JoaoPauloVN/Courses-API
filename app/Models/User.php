<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'surname',
        'contact',
        'profile_image',
        'language',
        'biography',
        'site',
        'facebook',
        'linkedin',
        'youtube',
        'instagram',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Generate a slug before create and update
     * 
     * @param \App\Models\User $user
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::creating(function ($user) {
            $user->slug = Str::slug("$user->name $user->surname");
        });

        static::updating(function ($user) {
            $user->slug = Str::slug("$user->name $user->surname");
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)->withPivot('status')->where('status', 1);
    }

    public function lessonsCompleted(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->wherePivot('status', 'complete');
    }

    public function assessments(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'assessments');
    }
}
