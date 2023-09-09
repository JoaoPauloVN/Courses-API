<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Module extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'course_id'
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'development' => true,
        'released' => false,
    ];

    /**
     * Generate a slug before create and update
     * 
     * @param \App\Models\Module $module
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::creating(function ($module) {
            $module->slug = Str::slug($module->name);
        });

        static::updating(function ($module) {
            $module->slug = Str::slug($module->name);
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

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
