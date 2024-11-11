<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'phone','facebook_url', 'twitter_url', 'other_social_url'];

    // Relación con los videos
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
