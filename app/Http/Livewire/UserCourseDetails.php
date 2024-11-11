<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Like;



class UserCourseDetails extends Component
{
    public $course;
    public $courseId;
    public $videos;
    public $isEnrolled = false;
    public $comment = ''; // Cambia el parámetro a una propiedad pública

    public $showCommentModal = false;
    public $likedVideos = [];
    public $selectedVideoId;
    public $completedVideos = []; // Declaramos $completedVideos


    



    public function mount($courseId)
    {
        $this->courseId = $courseId;
        $this->course = Course::with('category', 'ageGroup')->findOrFail($courseId);
        $this->videos = Video::where('course_id', $courseId)->get();
        $this->isEnrolled = auth()->check() && auth()->user()->courses()->where('course_id', $courseId)->exists();
        if ($this->isEnrolled) {
            $this->completedVideos = \DB::table('videos')
            ->join('video_user', 'videos.id', '=', 'video_user.video_id')
            ->where('video_user.user_id', auth()->id())
            ->where('video_user.is_completed', true)
            ->pluck('videos.id')
            ->toArray();
            $this->likedVideos = Like::where('user_id', auth()->id())
                ->whereIn('video_id', $this->videos->pluck('id'))
                ->pluck('video_id')
                ->toArray();
        }

    }

    public function markVideoAsCompleted($videoId)
    {
        $user = auth()->user();

        if (!$this->isEnrolled) {
            session()->flash('error', 'Debes estar inscrito en el curso para marcar videos como completados.');
            return;
        }

        // Verificar si ya existe un registro en la tabla `video_user`
        $existingCompletion = \DB::table('video_user')
            ->where('user_id', $user->id)
            ->where('video_id', $videoId)
            ->first();

        if (!$existingCompletion) {
            // Crear registro si no existe
            $user->videos()->attach($videoId, ['is_completed' => true]);
            session()->flash('message', 'Video marcado como completado.');
        } else {
            // Si ya existe, actualizar el campo `is_completed`
            $user->videos()->updateExistingPivot($videoId, ['is_completed' => true]);
            session()->flash('message', 'Video ya estaba marcado como completado.');
        }

        // Actualizar la lista de videos completados y recalcular el progreso
        $this->updateCompletedVideos();
        $this->calculateProgress();
    }

    // Método para actualizar la lista de videos completados
    protected function updateCompletedVideos()
    {
        $this->completedVideos = \DB::table('videos')
            ->join('video_user', 'videos.id', '=', 'video_user.video_id')
            ->where('video_user.user_id', auth()->id())
            ->where('video_user.is_completed', true)
            ->pluck('videos.id')
            ->toArray();
    }

    // Método para calcular y actualizar el progreso en course_user
    protected function calculateProgress()
    {
        $totalVideos = $this->videos->count();
        $completedCount = count($this->completedVideos);
        $progress = $totalVideos > 0 ? ($completedCount / $totalVideos) * 100 : 0;

        auth()->user()->courses()->updateExistingPivot($this->courseId, ['progress' => $progress]);
    }
    public function likeVideo($videoId)
    {
        if ($this->isEnrolled) {
            $like = Like::where('user_id', auth()->id())->where('video_id', $videoId)->first();

            if ($like) {
                $like->delete();
                $this->likedVideos = array_diff($this->likedVideos, [$videoId]);
            } else {
                Like::create([
                    'user_id' => auth()->id(),
                    'video_id' => $videoId,
                ]);
                $this->likedVideos[] = $videoId;
            }
        }
    }

    public function hasComment($videoId)
    {
        return Comment::where('video_id', $videoId)
                    ->where('user_id', auth()->id())
                    ->exists();
    }

    public function getComment($videoId)
    {
        $comment = Comment::where('video_id', $videoId)
                        ->where('user_id', auth()->id())
                        ->first();

        return $comment ? $comment->comment : '';
    }

    public function commentOnVideo($videoId)
    {
        if ($this->isEnrolled) {
            if (!$this->hasComment($videoId)) {
                $this->selectedVideoId = $videoId;
                $this->showCommentModal = true;
            }
        }
    }

    

    public function addComment()
    {
        if ($this->comment && $this->isEnrolled) {
            Comment::create([
                'video_id' => $this->selectedVideoId,
                'user_id' => auth()->id(),
                'comment' => $this->comment,
                'approved' => false, // El comentario queda pendiente de aprobación                
            ]);
            $this->comment = '';
            $this->showCommentModal = false;
            session()->flash('message', 'Comentario agregado y pendiente de aprobación.');
        } else {
            session()->flash('error', 'No tienes permiso para comentar en este curso.');
        }
    }

    public function enroll()
    {
        $user = Auth::user();
        
        if (!$user->courses->contains($this->courseId)) {
            $user->courses()->attach($this->courseId, ['progress' => 0]);
            session()->flash('message', 'Inscrito en el curso con éxito.');
        } else {
            session()->flash('message', 'Ya estás inscrito en este curso.');
        }
    }

    public function isUserEnrolled($courseId)
    {
        return auth()->user() && auth()->user()->courses()->where('course_id', $courseId)->exists();
    }

    public function render()
    {
        return view('livewire.user-course-details', [
            'isEnrolled' => $this->isEnrolled,
            'course' => $this->course,
            'videos' => $this->videos,
            'completedVideos' => $this->completedVideos, ]);
    }

   
    
    public function getYouTubeID($url)
    {
        preg_match('/(youtu\.be\/|v=|\/v\/|embed\/|watch\?v=|\&v=)([a-zA-Z0-9_-]{11})/', $url, $matches);
        return $matches[2] ?? null;
    }

}
