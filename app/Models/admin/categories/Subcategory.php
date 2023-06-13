<?php

namespace App\Models\admin\categories;

use App\Models\categories\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $fillable = [
        "category_id",
        "description_ar",
        "description_en",
        "cover",
        "start_work",
        "end_work",
        "lat",
        "lng",
    ];
    public function photoLink()
    {
        $image = asset('uploads/default/default.png');
        if ($this->cover) {
            $image = asset('uploads/subcategories/' . $this->id . '/' . $this->cover);
        }
        return $image;
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
}
