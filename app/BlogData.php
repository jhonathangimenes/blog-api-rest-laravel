<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogData extends Model
{
    protected $fillable = [
        'name', 'img', 'desc'
    ];

    protected $table = 'blog_data';
}
