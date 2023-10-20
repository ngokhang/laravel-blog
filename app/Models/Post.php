<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'content', 'accepted', 'slug', 'user_id'];


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasOne(Image::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeWithPostAccepted($query)
    {
        return $query->with(['categories', 'user.comments', 'comments.replies'])->where('accepted', 1)->paginate(10);
    }

    public function scopeYourPost($query)
    {
        return $query->with(['categories', 'user.comments', 'comments.replies'])->where('user_id', Auth::user()->id)->paginate(10);
    }

    public function scopeAdminManagePost($query)
    {
        return $query->with(['categories', 'user.comments', 'comments.replies'])->paginate(10);
    }
}
