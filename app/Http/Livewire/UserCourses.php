<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class UserCourses extends Component
{
    public $userCourses = [];

    public function mount()
    {
        $this->loadUserCourses();
    }

    public function loadUserCourses()
    {
        $this->userCourses = Auth::user()->courses()
            ->with(['videos' => function($query) {
                $query->select('id', 'course_id'); // Traemos solo los campos necesarios
            }])
            ->get()
            ->map(function ($course) {
                $totalVideos = $course->videos->count();
                $completedVideos = $course->videos()
                    ->whereHas('users', function($query) use ($course) {
                        $query->where('user_id', Auth::id())
                              ->where('video_user.is_completed', true);
                    })
                    ->count();
    
                $course->user_progress = $totalVideos ? round(($completedVideos / $totalVideos) * 100, 2) : 0;
                return $course;
            });
    }
    

    public function render()
    {
        return view('livewire.user-courses');
    }
}
