<?php

namespace App\Models\stores;

use App\Models\ads\Advertisement;
use App\Models\stores\Appointment;
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
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'substore_id');
    }
    public function isOpen()
    {
        $day = date('l');
        $time = date('H:i:s');
        $appointment = $this->appointments()->where('day', $day)->first();
        if ($appointment) {
            if ($appointment->start_work <= $time && $appointment->end_work >= $time) {
                return true;
            }
        }
        return false;
    }
    public function advertisements()
    {
        return $this->morphMany(Advertisement::class, 'imageable');
    }
}
