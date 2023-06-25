<?php

namespace App\Http\Resources\home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'name' => strtoupper($this['name_' . $request->header('Accept-Language')]),
            'iso' => $this->iso,
            'iso3' => $this->iso3,
            'code' => $this->phone_code,
            'max_number' => $this->max_number,
            'flag' => $this->flag,
        ];
    }
}
