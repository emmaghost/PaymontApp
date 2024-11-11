<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Course;
use App\Models\User;
class CourseUserProgress extends Component
{
    public $courseId;
    public $course;
    public $users;


    public function mount($courseId)
    {
        $this->courseId = $courseId;        
        
        $this->course = Course::with(relations: ['users', 'videos'])->findOrFail($courseId);

        if ($this->course) {
            $this->loadUserProgress();
        } else {
            $this->users = collect(); // Para evitar errores si el curso no existe
        }
    }


    public function loadUserProgress()
    {
        // Cargar los usuarios inscritos con el progreso
        //$this->users = $this->course->users()->withPivot('progress')->get();

        $this->users = $this->course->users->map(function ($user) {
            $totalVideos = $this->course->videos()->count();
            $completedVideos = $user->videos()->whereIn('video_id', $this->course->videos->pluck('id'))->wherePivot('is_completed', true)->count();

            // Calcular el progreso como un porcentaje
            $progress = $totalVideos > 0 ? ($completedVideos / $totalVideos) * 100 : 0;

            // Agregar el progreso al usuario
            $user->progress = round($progress, 2);
            $user->last_video = $user->videos()->wherePivot('is_completed', true)->latest('video_user.updated_at')->first();

            return $user;
        });
    }


    public function render()
    {
        return view('livewire.admin.course-user-progress');
    }
}
