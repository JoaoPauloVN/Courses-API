<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'content',
        'type',
        'url',
        'duration',
        'module_id',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Generate a slug before create and update
     * 
     * @param \App\Models\Lesson $lesson
     * @return void
     */
    protected static function boot() {
        parent::boot();

        static::creating(function ($lesson) {
            $lesson->slug = Str::slug($lesson->name);
        });

        static::updating(function ($lesson) {
            $lesson->slug = Str::slug($lesson->name);
        });
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(LessonAsset::class);
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['complete', 'duration']);
    }
        
    public function userStatus(int $id): ?User
    {
        return $this->user()->where('user_id', $id)->first();
    }

    public function complete(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->wherePivot('user_id', 21)->wherePivot('complete', 1);
    }

    public function course(): BelongsToThrough
    {
        return $this->belongsToThrough(Course::class, Module::class);
    }

    public function progress(): int
    {
        $completed = $this->loadCount('complete')->complete_count;

        $total_lessons = $this->load('course')->course->lessons()->count();

        return floor(($completed * 100) / $total_lessons);
    }

    public function prevLesson(Course $course): ?string
    {
        $lesson = Lesson::where('module_id', $this->module_id)->where('id', '<', $this->id)->latest('id')->first();

        if(!$lesson) {
            $module = Module::where('id', $this->module_id)->first();

            $prevModule = Module::where('course_id', $module->course_id)->where('id', '<', $module->id)->latest('id')->first();

            if($prevModule)
                $lesson = Lesson::where('module_id', $prevModule->id)->latest('id')->first();
        }

        return $lesson ? route('courses.lesson', [$course, $lesson]) : null;
    }

    public function nextLesson(Course $course): ?string
    {
        $lesson = Lesson::where('module_id', $this->module_id)->where('id', '>', $this->id)->first();

        if(!$lesson) {
            $module = Module::where('id', $this->module_id)->first();

            $nextModule = Module::where('course_id', $module->course_id)->where('id', '>', $module->id)->first();

            if($nextModule)
                $lesson = Lesson::where('module_id', $nextModule->id)->first();
        }

        return $lesson ? route('courses.lesson', [$course, $lesson]) : null;
    }
}
