<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogAddresses extends Model
{
    protected $fillable = [
        'cep', 'state', 'city', 'desc', 'number'
    ];

    protected $table = 'blog_addresses';
}
