<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'difficulty_level' => $this->difficulty_level,
            'duration' => $this->duration,
            'image_url' => $this->image_url,
            'new' => $this->new,
            'free' => $this->free,
            'language' => optional($this->whenLoaded('language'))->name,
            'instructors' => SimpleInstructorResource::collection($this->whenLoaded('instructors')),
        ];
    }
}
