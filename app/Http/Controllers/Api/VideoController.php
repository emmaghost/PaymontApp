<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Video;

class VideoController extends Controller
{

    public function index($courseId)
    {
        $course = Course::with('videos')->find($courseId);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        return response()->json(['data' => $course->videos], 200);
    }
    /**
     * Obtener videos de un curso.
     *
     * @param  int  $courseId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVideos($courseId)
    {
        $videos = Video::where('course_id', $courseId)->get();
        return response()->json($videos);
    }

    /**
     * Marcar video como completado y actualizar progreso.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $videoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsCompleted(Request $request, $videoId)
    {
        $user = $request->user();

        $user->videos()->updateExistingPivot($videoId, ['is_completed' => true]);
        $this->updateCourseProgress($user, $videoId);

        return response()->json(['message' => 'Video marked as completed']);
    }

    /**
     * Calcular y actualizar el progreso en el curso.
     *
     * @param  \App\Models\User  $user
     * @param  int  $courseId
     * @return void
     */
    protected function updateCourseProgress($user, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $totalVideos = $course->videos()->count();
        $completedVideos = $user->videos()->wherePivot('is_completed', true)->where('course_id', $courseId)->count();

        $progress = $totalVideos > 0 ? ($completedVideos / $totalVideos) * 100 : 0;
        $user->courses()->updateExistingPivot($courseId, ['progress' => $progress]);
    }
}
