<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'desc' 
    ];

    protected $table = 'permissions';

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
