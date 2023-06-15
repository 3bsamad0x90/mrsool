<?php

namespace App\Http\Resources\home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoresResource extends JsonResource
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
        $data = [
            'id' => $this->id,
            'name' => $lang == 'ar' ? $this->name_ar : $this->name_en,
            'icon' => asset('uploads/stores/' .$this->id .'/' . $this->image),
        ];
        if($this->mainCategory != '0'){
            $data['cover'] = asset('uploads/substores/' . $subStore->id . '/' . $subStore->cover);
            $data['location'] = 'loc';
            $data['rating'] = '0';
            $data['open'] = $subStore->isOpen();
        }
        return $data;
    }
}
