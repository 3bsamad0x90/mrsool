<?php

namespace App\Models\ads;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    protected $table = 'advertisements';
    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'image_url',
        'type',
    ];
    public function imageable()
    {
        return $this->morphTo();
    }
}
