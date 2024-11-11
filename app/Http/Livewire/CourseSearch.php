<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use App\Models\AgeGroup;

class CourseSearch extends Component
{

    ##Comentarios 
    /* Este componente realiza lo siguiente:
        Al cargar (mount), obtiene todos los grupos de edad y categorías para poblar los filtros.
        Ejecuta la consulta loadCourses para cargar cursos según los filtros seleccionados.
        Usa updated para refrescar automáticamente la lista de cursos cuando los filtros cambian 
    */

    
    public $ageGroup;
    public $category;
    public $name;
    public $courses;
    public $ageGroups;
    public $categories;

    public function mount()
    {
        $this->ageGroups = AgeGroup::all();
        $this->categories = Category::all();
        $this->loadCourses();
    }

    public function loadCourses()
    {
        $query = Course::query();

        if ($this->ageGroup) {
            $query->where('age_group_id', $this->ageGroup);
        }

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        if ($this->name) {
            $query->where('title', 'like', '%' . $this->name . '%');
        }

        $this->courses = $query->get();
    }

    public function updated($field)
    {
        $this->loadCourses();
    }

    public function render()
    {
        return view('livewire.course-search');
    }
}
