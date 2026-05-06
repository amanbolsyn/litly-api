<?php

namespace App\Http\Resources\Api\v1;

use App\Http\Resources\Api\v1\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            'fullname' => $this->fullname,
            'date_of_birth' => $this->date_of_birth,
            'date_of_death' => $this->date_of_death,
            'portraits' => FileResource::collection($this->files),
            $this->mergeWhen(
                $request->routeIs('author.show', 'author.store', 'author.update'),
                [
                    'biography' => $this->biography,
                    'languages' => $this->languages
                ]
            ),
            'links' => route('author.show', ['author' => $this->id])
        ];
    }
}

