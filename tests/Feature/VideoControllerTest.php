<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\AgeGroup;

class VideoControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        // Crea una categoría y un grupo de edad predefinidos
        Category::firstOrCreate(['id' => 1, 'name' => 'Default Category']);
        AgeGroup::firstOrCreate(['id' => 1, 'name' => 'Default Age Group', 'min_age' => 5, 'max_age' => 8]);
    }
    /**
     * Prueba para obtener videos de un curso.
     *
     * @return void
     */
    public function testGetVideosOfCourse()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        Video::factory()->count(3)->create(['course_id' => $course->id]);
    
        // Autenticar al usuario para la solicitud
        $response = $this->actingAs($user, 'sanctum')->getJson('/api/courses/' . $course->id . '/videos');
    
        // Verificar el estado de la respuesta y el contenido
        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    /**
     * Prueba para marcar un video como completado.
     *
     * @return void
     */
    public function testMarkVideoAsCompleted()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $video = Video::factory()->create(['course_id' => $course->id]);

        // Registrar al usuario en el curso
        $user->courses()->attach($course->id);

        // Autenticar al usuario y realizar la solicitud para marcar el video como completado
        $response = $this->actingAs($user, 'sanctum')->postJson('/api/videos/' . $video->id . '/complete');

        $response->assertStatus(200)
                ->assertJson(['message' => 'Video marked as completed']);

        // Verificar que el registro esté en la tabla `video_user`
        $this->assertDatabaseHas('video_user', [
            'user_id' => $user->id,
            'video_id' => $video->id,
            'is_completed' => true,
        ]);
    }
}
