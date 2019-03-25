<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'desc', 'status', 'post_id','user_id' 
    ];

    protected $table = 'comments';

    public $rulesStore = [
        'desc' => 'required|max:100',
        'status' => 'required|max:100',
        'post_id' => 'required|max:100',
        'user_id' => 'required|max:100'
    ];

    public $rulesUpdate = [
        'desc' => 'sometimes|required|max:100',
        'status' => 'sometimes|required|max:100',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function like()
    {
        return $this->hasMany(Like::class, 'comment_id');
    }

    public function dislike()
    {
        return $this->hasMany(Dislike::class, 'comment_id');
    }

}
