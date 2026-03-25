<?php

namespace App\Http\Resources\Api\v1;

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
            'type' => "author",
            'id' => $this->id,
            'attributes' => [
                'fullname' => $this->fullname,
                'date_of_birth' => $this->date_of_birth,
                'date_of_death' => $this->date_of_death,
                'portrait' => $this->portrait,
                $this->mergeWhen(
                    !$request->routeIs('author.index'),
                    [
                        'biography' => $this->biography,
                        'languages' => $this->languages

                    ]
                )
            ],
            'links' => route('author.show', ['author' => $this->id])
        ];
    }
}
