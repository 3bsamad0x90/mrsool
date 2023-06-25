<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\country\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'language',
        'gender',
        'role',
        'image',
        'country_id',
        'dob',
        'device_token',
        'active',
        'otp',
        'is_verified',
        'country_code',
        'lat',
        'lng',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // public function hisRole()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function hasRole($name): bool
    {
        $lang = app()->getLocale();
        return $this->role()->where('guard', $name)->exists();
    }
    public function getImageAttribute($value)
    {   $image = asset('uploads/default/vector.png');
        if($value != null){
            $image = asset('uploads/users/' . $this->id . '/' . $value);
        }
        return $image;
    }
    public function photoLink()
    {
        $image = asset('uploads/default/vector.png');

        if ($this->image != '') {
            $image = asset('uploads/users/' . $this->id . '/' . $this->image);
        }

        return $image;
    }
    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
}
