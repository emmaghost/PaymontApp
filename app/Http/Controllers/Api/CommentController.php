<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function addComment(Request $request, $videoId)
    {
        $request->validate(['comment' => 'required|string']);
        $user = Auth::user();

        Comment::create([
            'video_id' => $videoId,
            'user_id' => $user->id,
            'comment' => $request->comment,
            'approved' => false,
        ]);

        return response()->json(['message' => 'Comment added and pending approval']);
    }
}
