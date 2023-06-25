<?php

namespace App\Http\Resources\users;

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
        $token = $this->createToken('authToken')->plainTextToken;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' =>$this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
            'image' => $this->image,
            'token' => $token,
        ];
    }
}
