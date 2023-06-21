<?php

namespace App\Http\Resources\statics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language');
        return [
            'id' => $this->id,
            'title' => $lang == 'ar' ? $this->title_ar : $this->title_en,
            'content' => $lang == 'ar' ? $this->content_ar : $this->content_en,
        ];
    }
}
