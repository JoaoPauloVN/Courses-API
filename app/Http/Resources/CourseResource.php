<?php

namespace App\Http\Resources;

use App\Models\DifficultyLevel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'difficulty_level' => $this->difficulty_level,
            'duration' => $this->duration,
            'image_url' => $this->image_url,
            'is_new' => $this->is_new,
            'is_free' => $this->is_free,
            'language' => optional($this->whenLoaded('language'))->name,
            'category' => optional($this->whenLoaded('category'))->name,
            'students' => optional($this->students)->count(),
            'ratings' => [
                'course_rating' => $this->reviewsAvg(),
                'total_reviews' => $this->whenLoaded('reviews')->count() 
            ],
            'instructors' => InstructorBasicResource::collection($this->whenLoaded('instructors')),
            'learnings' => $this->whenLoaded('learnings'),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'modules' => ModuleResource::collection($this->whenLoaded('modules')),
        ];
    }
}
