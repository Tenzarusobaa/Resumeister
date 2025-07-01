<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey = 'UserID';
    protected $fillable = [
        'Username',
        'Password',
        'DisplayName',
        'Picture',
        'PicturePath',
        'TotalYears',
    ];
    
    protected $hidden = [
        'Password',
    ];
    
    public function posts()
    {
        return $this->hasMany(Post::class, 'UserID');
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'UserID');
    }
    
    public function replies()
    {
        return $this->hasMany(Reply::class, 'UserID');
    }
    
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'UserID');
    }
}