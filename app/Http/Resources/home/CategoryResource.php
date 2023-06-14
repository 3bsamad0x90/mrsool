<?php

namespace App\Http\Resources\home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language');
        $data = [
            'id' => $this->id,
            'name' => $lang == 'ar' ? $this->name_ar : $this->name_en,
            'icon' => asset('uploads/categories/' .$this->id .'/' . $this->image),
        ];
        if($this->mainCategory != '0'){
            $data['location'] = 'loc';
            $data['rating'] = '0';
            $data['open'] = $this->isOpen();
        }
        return $data;
    }
}
