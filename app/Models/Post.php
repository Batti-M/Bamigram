<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'img_url',
        'user_id'
    ];
    protected function getImgUrlAttribute()
    {
        return asset('storage/' . $this->attributes['img_url']);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
