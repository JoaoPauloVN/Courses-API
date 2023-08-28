<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'name',
        'file'
    ];

    public $timestamps = false;

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
