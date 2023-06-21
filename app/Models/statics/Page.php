<?php

namespace App\Models\statics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $table = 'pages';
    protected $fillable = [
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
    ];
}
