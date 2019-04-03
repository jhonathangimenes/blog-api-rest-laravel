<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogAddresses extends Model
{
    protected $fillable = [
        'cep', 'state', 'city', 'desc', 'number'
    ];

    protected $table = 'blog_addresses';

    public $rules = [
        'cep' => 'required|max:100',
        'state' => 'required|max:100',
        'city' => 'required|max:100',
        'desc' => 'required|max:100',
        'number' => 'required|max:100'
    ];
}
