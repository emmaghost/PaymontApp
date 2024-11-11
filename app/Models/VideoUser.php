<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoUser extends Model
{
    use HasFactory;

    protected $table = 'video_user';

    protected $fillable = [
        'user_id',
        'video_id',
        'is_completed',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Video
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
