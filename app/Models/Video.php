<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'subtitle', 'url', 'duration','description'];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'video_user')
                    ->withPivot('is_completed')
                    ->withTimestamps();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function incrementViews()
    {
        $this->increment('views');
    }
}
