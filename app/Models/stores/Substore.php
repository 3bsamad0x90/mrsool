<?php

namespace App\Models\stores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substore extends Model
{
    use HasFactory;
    protected $table = 'substores';
    protected $fillable = [
        "store_id",
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
            $image = asset('uploads/substores/' . $this->id . '/' . $this->cover);
        }
        return $image;
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    public function hasStore()
    {
        return $this->store()->count() > 0;
    }
    public function isOpen()
    {
        $now = date('H:i:s');
        if ($now >= $this->start_work && $now <= $this->end_work) {
            return true;
        }
        return false;
    }
}
