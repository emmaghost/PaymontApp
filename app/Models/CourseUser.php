<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseUser extends Pivot
{
    protected $table = 'course_user'; // Nombre de la tabla intermedia

    protected $fillable = [
        'user_id',
        'course_id',
        'progress', // Campo adicional para el progreso en el curso
    ];
}
