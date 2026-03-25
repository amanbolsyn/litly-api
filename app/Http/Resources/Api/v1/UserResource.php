<?php

namespace App\Http\Resources\Api\v1;

use App\Http\Resources\Api\v1\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => "user",
            'id' => $this->id,
            'attributes' => [
                'fullname' => $this->fullname,
                'email' => $this->email,
                'profile_image' => $this->profile_image, 
                $this->mergeWhen(
                    $request->routeIs('user.show'),
                    [
                        'created_at' => $this->created_at,
                    ]
                )
            ],
            'links' => [
                'self' => route("user.show", ['user' => $this->id])
            ],
           'included' => 
                $this->when(
                    $request->routeIs("user.show"),
                    RoleResource::collection($this->roles)
                ),
        ];
    }
}
