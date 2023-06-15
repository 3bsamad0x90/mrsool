<?php

namespace App\Models\country;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    protected $fillable = ['name_ar', 'name_en', 'iso', 'iso3', 'phone_code', 'max_number', 'flag'];

    public function getFlagAttribute($value)
    {
        return asset('uploads/countries/' . $this->id .'/' .$value);
    }
    public function users()
    {
        return $this->hasMany(User::class, 'country_id', 'id');
    }
}
