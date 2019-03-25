<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
{
    protected $fillable = [
        'dislike', 'post_id', 'comment_id', 'user_id' 
    ];

    protected $table = 'likes';

    public $rules = [
        'dislike' => 'required|max:100',
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
