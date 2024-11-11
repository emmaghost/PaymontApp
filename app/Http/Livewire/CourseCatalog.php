<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use App\Models\AgeGroup;
use Livewire\WithPagination;


class CourseCatalog extends Component
{
    use WithPagination;

    public $courses;
    public $search = '';
    public $selectedCategory = '';
    public $selectedAgeGroup = '';
    public $categories;
    public $ageGroups;
    public $age_group_id;

    public $category_id = null;



    public function mount()
    {
        $this->categories = Category::all();
        $this->ageGroups = AgeGroup::all();
        $this->loadCourses();
    }

    public function loadCourses()
    {
        $this->courses = Course::with(['category', 'ageGroup'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->when($this->selectedAgeGroup, function ($query) {
                $query->where('age_group_id', $this->selectedAgeGroup);
            })
            ->get();
    }

    public function getCoursesProperty()
    {
        $query = Course::query();
    
        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }
    
        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }
    
        if ($this->age_group_id) {
            $query->where('age_group_id', $this->age_group_id);
        }
    
        return $query->get();
    }
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'age_group_id'])) {
            $this->resetPage(); // Este método reseteará la paginación a la primera página
            $this->getCoursesProperty(); // Llama al método que actualiza los cursos
        }
    }
    public function render()
    {
        return view('livewire.course-catalog');
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Reiniciar la paginación al actualizar la búsqueda
    }
}
