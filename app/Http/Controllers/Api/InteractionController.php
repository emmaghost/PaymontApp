<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Video;

class InteractionController extends Controller
{
    /**
     * Subir un comentario a un video.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $videoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addComment(Request $request, Video $video)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);
    
        // Crea el comentario asociado al video
        $video->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'approved' => false, // pendiente de aprobación
        ]);
    
        return response()->json(['message' => 'Comment submitted for approval'], 201);
    }

    /**
     * Dar like a un video.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $videoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeVideo(Request $request, $videoId)
    {
        $user = $request->user();

        $like = Like::where('user_id', $user->id)->where('video_id', $videoId)->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Like removed']);
        } else {
            Like::create([
                'user_id' => $user->id,
                'video_id' => $videoId
            ]);
            return response()->json(['message' => 'Video liked']);
        }
    }
    public function markAsCompleted($videoId)
    {
        $user = auth()->user();

        // Crear o actualizar el registro en la tabla pivot con `is_completed` como verdadero
        $user->videos()->syncWithoutDetaching([$videoId => ['is_completed' => true]]);

        return response()->json(['message' => 'Video marked as completed'], 200);
    }
}
