<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TestResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'as' => $this->collection
        ];
    }

    public function paginationInformation($request) {
        $pagination = $this->resource->toArray();

        return [
            'current_page' => $pagination['current_page']
        ];
    }
}
