<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\AgeGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use  Database\Seeders\TestCategorySeeder;
use  Database\Seeders\TestAgeGroupSeeder;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba para listar todos los cursos.
     *
     * @return void
     */

     protected function setUp(): void
    {
        parent::setUp();

        // Ejecuta el seeder para la categoría sin borrar la base de datos
        $this->seed(TestAgeGroupSeeder::class);
        $this->seed(TestCategorySeeder::class); // Si también necesitas la categoría
    }
    public function testListCourses()
    {
        Course::factory()->count(3)->create();

        // Realizar la solicitud GET para obtener la lista de cursos
        $response = $this->actingAs(User::factory()->create(), 'sanctum')->getJson('/api/courses');

        // Verificar el estado de la respuesta y el contenido
        $response->assertStatus(200)
                 ->assertJsonCount(3); // Verifica que se reciban 3 cursos
    }

    /**
     * Prueba para buscar cursos por categoría, rango de edad y nombre.
     *
     * @return void
     */
    public function testSearchCourses()
    {
        $category = Category::factory()->create();
        Course::factory()->count(2)->create(['category_id' => $category->id]);

        // Realizar la solicitud GET con parámetros de búsqueda
        $response = $this->actingAs(User::factory()->create(), 'sanctum')->getJson('/api/courses/search?category_id=' . $category->id);

        // Verificar el estado de la respuesta y la cantidad de cursos retornados
        $response->assertStatus(200)
                ->assertJsonCount(2, 'data'); // Verifica que se reciban 2 cursos de la categoría específica
    }

    /**
     * Prueba para registrar un usuario en un curso.
     *
     * @return void
     */
    public function testEnrollUserInCourse()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
    
        // Realizar la solicitud POST para inscribir al usuario en el curso
        $response = $this->actingAs($user, 'sanctum')->postJson("/api/courses/{$course->id}/enroll");
    
        // Verificar que la inscripción se haya realizado correctamente
        $response->assertStatus(201)
                 ->assertJson(['message' => 'Enrolled successfully']);
    
        $this->assertDatabaseHas('course_user', [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }
}
