<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Video;
use App\Models\Comment;

class VideoCommentsManager extends Component
{
    public $videoId;
    public $comments;
    public $video;

    public function mount($videoId)
    {
        $this->videoId = $videoId;
        $this->loadComments();
    }

    public function loadComments()
    {
        $this->video = Video::with('comments.user', 'likes')->find($this->videoId);
        $this->comments = $this->video->comments;
    }

    public function approveComment($commentId)
    {
        $comment = Comment::find($commentId);
        if ($comment) {
            $comment->is_approved = true;
            $comment->save();
            $this->loadComments();
        }
    }

    public function declineComment($commentId)
    {
        $comment = Comment::find($commentId);
        if ($comment) {
            $comment->is_approved = false;
            $comment->save();
            $this->loadComments();
        }
    }

    public function render()
    {
        return view('livewire.admin.video-comments-manager', [
            'video' => $this->video,
            'comments' => $this->comments,
            'likeCount' => $this->video->likes->count(),
            'viewsCount' => $this->video->views,
        ]);
    }
}
