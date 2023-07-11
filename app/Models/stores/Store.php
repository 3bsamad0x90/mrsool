<?php

namespace App\Models\stores;

use App\Models\ads\Advertisement;
use App\Models\stores\Substore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        "name_ar",
        "name_en",
        "status",
        "mainStore",
        "parent_id",
        "image",
        "ordering",
    ];
    public function photoLink()
    {
        $image = asset('uploads/default/default.png');
        if ($this->image) {
            $image = asset('uploads/stores/' . $this->id . '/' . $this->image);
        }
        return $image;
    }
    public function parent()
    {
        return $this->belongsTo(Store::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Store::class, 'parent_id');
    }
    // sub Sore
    public function subStore()
    {
        return $this->hasMany(Substore::class, 'store_id');
    }
    // check main store
    public function isMainStore() : bool
    {
        return $this->parent_id == 0;
    }
    // check sub store
    public function isSubStore() : bool
    {
        return $this->parent_id != 0;
    }
    // check if store has children
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }
    public function mainStore()
    {
        $mainStore = trans('common.mainStore');
        if ($this->isMainStore()) {
            return "<span class='badge badge-light-success'>$mainStore</span>";
        } else {
            $parentName = $this->parent['name_' . app()->getLocale()];
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
    public function isOpen()
    {
        $now = date('H:i:s');
        $subCat = $this->Subcategory()->first();
        if ($now >= $subCat->start_work && $now <= $subCat->end_work) {
            return true;
        }
        return false;
    }
    public function advertisements()
    {
        return $this->morphMany(Advertisement::class, 'imageable');
    }

}
