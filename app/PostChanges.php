<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostChanges extends Model
{
    protected $fillable = [
        'post_id', 'user_id'
    ];

    protected $table = 'post_changes';

    public function post()
    {
        return $this->belongTo(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongTo(User::class, 'user_id');
    }
}
