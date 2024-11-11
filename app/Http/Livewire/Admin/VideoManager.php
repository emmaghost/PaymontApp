<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Video;
use App\Models\Course;

class VideoManager extends Component
{
    public $courseId;
    public $videos;
    public $title, $subtitle, $url, $duration,$description;
    public $videoId;
    public $showModal = false;
    public $videoUrl; // Propiedad para almacenar la URL del video a mostrar


    protected $rules = [
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'url' => 'required|url',
        'description' => 'required|string',
        'duration' => 'required|integer|min:1', // Duración mínima de 1 minuto
    ];

    public function mount($courseId)
    {
        $this->courseId = $courseId;
        $this->loadVideos();
    }

    public function loadVideos()
    {
        $this->videos = Video::where('course_id', $this->courseId)->get();
    }

    public function saveVideo()
    {
        $this->validate();

        Video::updateOrCreate(
            ['id' => $this->videoId],
            [
                'course_id' => $this->courseId,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'description' => $this->description,
                'url' => $this->url,
                'duration' => $this->duration,
            ]
        );

        $this->resetForm();
        $this->loadVideos();
        session()->flash('message', $this->videoId ? 'Video actualizado.' : 'Video creado.');

        $this->showModal = false;
    }

    public function editVideo($id)
    {
        $video = Video::findOrFail($id);
        $this->videoId = $video->id;
        $this->title = $video->title;
        $this->subtitle = $video->subtitle;
        $this->url = $video->url;
        $this->duration = $video->duration;

        $this->showModal = true;
    }

    public function deleteVideo($id)
    {
        Video::findOrFail($id)->delete();
        $this->loadVideos();
        session()->flash('message', 'Video eliminado.');
    }

    public function resetForm()
    {
        $this->title = '';
        $this->subtitle = '';
        $this->url = '';
        $this->duration = '';
        $this->videoId = null;

        $this->showModal = true;
    }

    public function showVideo($url)
    {
        $this->videoUrl = $url; // Establece la URL del video que se mostrará en el modal
    }
    public function getYouTubeID($url)
    {
        preg_match('/(youtu\.be\/|v=|\/v\/|embed\/|watch\?v=|\&v=)([a-zA-Z0-9_-]{11})/', $url, $matches);
        return $matches[2] ?? null;
    }
    public function render()
    {
        return view('livewire.admin.video-manager', [
            'course' => Course::find($this->courseId),
        ]);

        
    }
}
