<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'min_age',
        'max_age',
        
        
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
