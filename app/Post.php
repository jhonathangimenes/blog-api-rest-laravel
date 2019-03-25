<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'desc', 'img', 'status', 'user_id' 
    ];

    protected $table = 'posts';

    public $rulesStore = [
        'title' => 'required|max:100',
        'desc' => 'required|max:100',
        'img' => 'sometimes|required',
        'status' => 'required|max:100',
        'user_id' => 'required|max:100'
    ];

    public $rulesUpdate = [
        'title' => 'sometimes|required|max:100',
        'desc' => 'sometimes|required|max:100',
        'img' => 'sometimes|required',
        'status' => 'sometimes|required|max:100',
        'user_id' => 'sometimes|required|max:100'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->hasMany(Post::class, 'post_id');
    }

    public function like()
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    public function dislike()
    {
        return $this->hasMany(Dislike::class, 'post_id');
    }

    public function postChanges()
    {
        return $this->hasMany(PostChanges::class, 'post_id');
    }


}
