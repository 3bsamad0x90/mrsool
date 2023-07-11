<?php

namespace App\Models\ads;

use App\Models\stores\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $table = 'banners';
    protected $fillable = [
        'image',
        'ordering',
        'status',
        'type',
        'store_id',
        'product_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function scopeStore($query)
    {
        return $query->where('type', 'store');
    }

    public function scopeProduct($query)
    {
        return $query->where('type', 'product');
    }

    public function getTypeAttribute($value){
        if($value == "store"){
            return "<span class='badge badge-light-success'>" . trans('common.store') . "</span>";
        }
        return "<span class='badge badge-light-success'>" . trans('common.product') . "</span>";
    }

    public function status()
    {
        if ($this->status == 1) {
            return "<span class='badge badge-light-success'>" . trans('common.active') . "</span>";
        }
        return "<span class='badge badge-light-danger'>" . trans('common.inactive') . "</span>";
    }

    public function getImageAttribute($value)
    {
        return asset('uploads/banners/' .$this->id .'/' . $value);
    }

}
