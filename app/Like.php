<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'like', 'post_id', 'user_id' 
    ];

    protected $table = 'likes';

    public $rules = [
        'like' => 'required|max:100',
        'post_id' => 'required|max:100',
        'user_id' => 'required|max:100',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

}
