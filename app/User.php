<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements JWTSubject, AuthenticatableContract, CanResetPasswordContract
{
    use Notifiable, Authenticatable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $rulesStore = [
        'first_name' => 'required|max:100',
        'last_name' => 'required|max:100',
        'email' => 'required|email|unique:users|max:150',
        'password' => 'required|min:6|max:100'
    ];

    public $rulesUpdate = [
        'first_name' => 'sometimes|required|max:100',
        'last_name' => 'sometimes|required|max:100',
        'email' => 'sometimes|required|email|unique:users|max:150',
        'password' => 'sometimes|required|min:6|max:100'
    ];

    public function post()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function like()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function dislike()
    {
        return $this->hasMany(Dislike::class, 'user_id');
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function postChanges()
    {
        return $this->hasMany(PostChanges::class, 'user_id');
    }
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
