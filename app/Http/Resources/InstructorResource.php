<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->full_name,
            'slug' => $this->slug,
            'email' => $this->email,
            'biography' => $this->biography,
            'contact' => $this->contact,
            'profile_image' => $this->profile_image,
            'language' => $this->language,
            'site' => $this->site,
            'facebook' => $this->facebook,
            'linkedin' => $this->linkedin,
            'youtube' => $this->youtube,
            'instagram' => $this->instagram,
        ];
    }
}
