<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeSocialNetwork extends Model
{
    protected $fillable = [
        'desc'
    ];

    protected $table = 'type_social_networks';
}
