<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
}
