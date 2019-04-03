<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogData extends Model
{
    protected $fillable = [
        'name', 'img', 'desc'
    ];

    protected $table = 'blog_data';

    public $rules = [
        'name' => 'required|max:100',
        'img' => 'sometimes|required',
        'desc' => 'required|max:100'
    ];
}
