<?php

namespace App\Models\stores;

use App\Models\stores\Substore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'day',
        'start_work',
        'end_work',
        'substore_id',
    ];
    public function substore()
    {
        return $this->belongsTo(Substore::class, 'substore_id');
    }
}
