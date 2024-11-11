<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\AgeGroup;
class InteractionControllerTest extends TestCase
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
     * Prueba para agregar un comentario a un video.
     *
     * @return void
     */
    public function testAddCommentToVideo()
    {
        $user = User::factory()->create();        

        $course = Course::factory()->create();
        $video = Video::factory()->create(['course_id' => $course->id]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/videos/' . $video->id . '/comments', [
            'comment' => 'Muy buen video',
        ]);

        $response->assertStatus(status: 201)
                 ->assertJson(['message' => 'Comment submitted for approval']);
        
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'video_id' => $video->id,
            'comment' => 'Muy buen video',
            'approved' => false,
        ]);
    }

    /**
     * Prueba para dar like a un video.
     *
     * @return void
     */
    public function testLikeVideo()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/videos/' . $video->id . '/like');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Video liked']);
        
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);
    }

    /**
     * Prueba para eliminar un like de un video.
     *
     * @return void
     */
    public function testUnlikeVideo()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $user->likes()->create(['video_id' => $video->id]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/videos/' . $video->id . '/like');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Like removed']);
        
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);
    }
}
