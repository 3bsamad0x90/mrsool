<?php

namespace App\Models\categories;

use App\Models\admin\categories\Subcategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        "name_ar",
        "name_en",
        "status",
        "mainCategory",
        "parent_id",
        "image",
        "ordering",
    ];
    public function photoLink()
    {
        $image = asset('uploads/default/default.png');
        if ($this->image) {
            $image = asset('uploads/categories/' . $this->id . '/' . $this->image);
        }
        return $image;
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function Subcategory()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }
    // check main category
    public function isMainCategory() : bool
    {
        return $this->parent_id == 0;
    }
    // check sub category
    public function isSubCategory()
    {
        return $this->parent_id != 0;
    }
    // check if category has children
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }
    public function mainCategory()
    {
        $mainCategory = trans('common.mainCategory');
        if ($this->isMainCategory()) {
            return "<span class='badge badge-light-success'>$mainCategory</span>";
        } else {
            $parentName = $this->parent['name_'.app()->getLocale()];
            $subOf = trans('common.subOf');
            return "<span class='badge badge-light-primary'>$subOf : $parentName</span>";
        }
    }
    public function checkStatus()
    {
        if ($this->status == 'active')
        return "<span class='badge badge-light-success'>مفعل</span>";
        else
            return "<span class='badge badge-light-danger'>غير مفعل</span>";
    }
    public function isOpen(){
        $now = date('H:i:s');
        $subCat = $this->Subcategory()->first();
        if($now >= $subCat->start_work && $now <= $subCat->end_work){
            return true;
        }
        return false;
    }
}
