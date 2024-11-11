<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;

class CourseController extends Controller
{
    /**
     * Listar todos los cursos
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses, 200);
    }

    /**
     * Buscar cursos por categoría, rango de edad y nombre.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = Course::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('age_group_id')) {
            $query->where('age_group_id', $request->input('age_group_id'));
        }

        if ($request->has('name')) {
            $query->where('title', 'like', '%' . $request->input('name') . '%');
        }

        $courses = $query->get();

        return response()->json(['data' => $courses], 200);
    }

    /**
     * Registrar un usuario en un curso.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $courseId
     * @return \Illuminate\Http\JsonResponse
     */
    public function enroll(Request $request, $courseId)
    {
        $user = $request->user();

        if ($user->courses->contains($courseId)) {
            return response()->json(['message' => 'Already enrolled'], 400);
        }

        $user->courses()->attach($courseId, ['progress' => 0]);
        return response()->json(['message' => 'Enrolled successfully'], 201);
    }
}
