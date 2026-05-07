<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
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
            'organization' => $this->organization,
            'city' => $this->city,
            'logo' => FileResource::collection($this->files),
            $this->mergeWhen(
                !$request->routeIs('orgz.index'),
                [
                    'address' => $this->address,
                    'allow_purchase' => $this->allow_purchase,
                    'allow_borrow' => $this->allow_borrow,
                    'allow_borrow_days' => $this->allow_borrow_days,
                ]
            ),
            'links' => [
                'self' => route('orgz.show', ['organization' => $this->id])
            ]
        ];
    }
}
