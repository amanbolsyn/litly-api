<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => "book",
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'cover_img' => $this->cover_img, 
                'publication_year' => $this->publication_year, 
                $this->mergeWhen(
                    $request->routeIs('book.show'), 
                    [
                      'isbn' => $this->isbn, 
                      'description' => $this->description, 

                    ],
                )
            ],
            'authors' => [
                AuthorResource::collection($this->authors),
            ],
            'categories' => [
                CategoryResource::collection($this->categories),
            ],
            'links' => [
                'self' => route('book.show', ['book' => $this->id]),
            ]
        ];
    }
}
