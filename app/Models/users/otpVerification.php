<?php

namespace App\Models\users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otpVerification extends Model
{
    use HasFactory;
    protected $table = 'otp_verifications';
    protected $fillable = [
        'otp',
        'phone_number',
        'country_code',
        'country_id',
        'is_active'
    ];

}
