<?php

namespace App\Http\Resources\category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language');
        $subCat = $this->Subcategory->first();
        return [
            'id' => $this->id,
            'name' => $lang == 'ar' ? $this->name_ar : $this->name_en,
            'description' => $lang == 'ar' ? $subCat->description_ar : $subCat->description_en,
            'icon' => asset('uploads/categories/' .$this->id .'/' . $this->image),
            'cover' => asset('uploads/subcategories/' . $this->id . '/' . $subCat->cover),
            'location' => 'loc',
            'rating' => '0',
            'open' => $subCat->isOpen(),
        ];
    }
}
