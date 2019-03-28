<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPhone extends Model
{
    protected $fillable = [
        'desc'
    ];

    protected $table = 'blog_phones';
}
