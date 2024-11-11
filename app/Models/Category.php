<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', // Agrega este campo
        'name',
    ];

     // Relación uno a muchos con Course
     public function courses()
     {
         return $this->hasMany(Course::class);
     }
}
