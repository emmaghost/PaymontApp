<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;

class CourseDetail extends Component
{
    public $course;
    public $videoCount;

    public function mount($courseId)
    {
        $this->course = Course::with('videos')->findOrFail($courseId);
        $this->videoCount = $this->course->videos->count();
    }

    public function isUserEnrolled($courseId)
    {
        return auth()->user() && auth()->user()->courses()->where('course_id', $courseId)->exists();
    }

    public function enroll()
    {
        auth()->user()->courses()->attach($this->course->id);
        session()->flash('message', '¡Te has inscrito exitosamente en el curso!');
    }

    public function render()
    {
        return view('livewire.course-detail');
    }

    public function likeVideo($videoId)
    {
        if ($this->isUserEnrolled($this->course->id)) {
            // Código para dar like al video
        } else {
            session()->flash('message', 'Debes estar inscrito en el curso para dar like a los videos.');
        }
    }

    public function commentOnVideo($videoId, $comment)
    {
        if ($this->isUserEnrolled($this->course->id)) {
            // Código para agregar el comentario
        } else {
            session()->flash('message', 'Debes estar inscrito en el curso para comentar en los videos.');
        }
    }
}
