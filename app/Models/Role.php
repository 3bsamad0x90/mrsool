<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'guard',
    ];
    protected $table  = 'roles';
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function hasPermissions($name): bool
    {
        return $this->permissions()->where('name', $name)->exists();
    }
}
