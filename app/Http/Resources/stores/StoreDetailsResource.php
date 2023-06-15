<?php

namespace App\Http\Resources\stores;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language');
        $subStore = $this->subStore->first();
        return [
            'id' => $this->id,
            'name' => $lang == 'ar' ? $this->name_ar : $this->name_en,
            'description' => $lang == 'ar' ? $subStore->description_ar : $subStore->description_en,
            'icon' => asset('uploads/categories/' .$this->id .'/' . $this->image),
            'cover' => asset('uploads/substores/' . $subStore->id . '/' . $subStore->cover),
            'location' => 'loc',
            'rating' => '0',
            'open' => $subStore->isOpen(),
        ];
    }
}
