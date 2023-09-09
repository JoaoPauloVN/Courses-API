<?php

namespace App\Models;

use App\Enums\DifficultyLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'difficulty_level' => DifficultyLevel::class
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'category',
        'language'
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'new' => true,
        'free' => false,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'difficulty_level',
        'duration',
        'image_url',
        'new',
        'free',
        'price',
        'category_id',
        'language_id',
    ];

    /**
     * Generate a slug before create and update
     * 
     * @param \App\Models\Course $course
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::creating(function ($course) {
            $course->slug = Str::slug($course->name);
        });

        static::updating(function ($course) {
            $course->slug = Str::slug($course->name);
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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function learnings(): HasMany
    {
        return $this->hasMany(Learning::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'reviews')->withPivot(['rating', 'comment']);
    }

    public function reviewsAvg(): int
    {
        return round($this->reviews()->avg('rating'), 1);
    }

    public function instructors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_instructor');
    }

    public function students(): BelongsToMany
    {
        return $this->users();
    }

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    public function lessonsCompleted(int $user): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, Module::class)
            ->whereHas('user', function ($query) use ($user){
                $query->where('user_id', $user)
                    ->where('complete', 1);
            });
    }

    public function currentLesson(int $user)
    {
        $currentLesson = $this->hasManyThrough(Lesson::class, Module::class)
            ->doesntHave('user')
            ->orWhereHas('user', function ($query) use ($user){
                $query->where('user_id', $user)
                    ->where('complete', 0);
            })->first();

        if(!$currentLesson)
            $currentLesson = $this->lessonsCompleted($user)->latest('id')->first();

        return $currentLesson;
    }
}
