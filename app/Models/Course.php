<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'age_group_id',
    ];

      // Relación muchos a muchos con User usando el modelo CourseUser
    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user')
                    ->using(CourseUser::class)
                    ->withTimestamps()
                    ->withPivot('progress');
    }

    // Relación inversa con Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación inversa con AgeGroup
    public function ageGroup()
    {
        return $this->belongsTo(AgeGroup::class);
    }
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

}
