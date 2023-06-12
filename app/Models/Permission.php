<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
    ];
    protected $table  = 'permissions';
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
}
