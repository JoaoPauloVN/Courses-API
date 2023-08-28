<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->userStatus($request->user()->id)->pivot;

        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'content' => $this->content,
            'type' => $this->type,
            'duration' => $this->duration,
            'assets' => $this->whenLoaded('assets'),
            'user_data' => [
                'complete' => $data->complete,
                'duration' => $data->duration,
                'progress' => $this->progress()
            ]
        ];
    }
}
