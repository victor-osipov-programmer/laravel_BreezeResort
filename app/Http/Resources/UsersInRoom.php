<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersInRoom extends JsonResource
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
            'userdata' => array_map(fn($user) => [
                'fio' => $user->fio,
                'phonenumber'=> $user->phone
            ], $this->users->all())
        ];
    }
}
