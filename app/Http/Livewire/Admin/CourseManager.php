<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Course;
use App\Models\Category;
use App\Models\AgeGroup;

class CourseManager extends Component
{
    public $courses;
    public $title, $description, $category_id, $age_group_id;
    public $courseId;
    public $showModal = false; // Nueva propiedad para controlar el modal

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'age_group_id' => 'required|exists:age_groups,id',
    ];

    public function mount()
    {
        $this->loadCourses();
    }

    public function loadCourses()
    {
        $this->courses = Course::with('category', 'ageGroup')->get();
    }

    public function saveCourse()
    {
        $this->validate();

        Course::updateOrCreate(
            ['id' => $this->courseId],
            [
                'title' => $this->title,
                'description' => $this->description,
                'category_id' => $this->category_id,
                'age_group_id' => $this->age_group_id,
            ]
        );

        $this->resetForm();
        $this->loadCourses();
        session()->flash('message', $this->courseId ? 'Curso actualizado.' : 'Curso creado.');

        // Cierra el modal después de guardar
        $this->showModal = false;
    }

    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        $this->courseId = $course->id;
        $this->title = $course->title;
        $this->description = $course->description;
        $this->category_id = $course->category_id;
        $this->age_group_id = $course->age_group_id;

        // Abre el modal
        $this->showModal = true;
    }

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->category_id = '';
        $this->age_group_id = '';
        $this->courseId = null;

        // Abre el modal para nuevo curso
        $this->showModal = true;
    }

    public function deleteCourse($id)
    {
        Course::findOrFail($id)->delete();
        $this->loadCourses();
        session()->flash('message', 'Curso eliminado.');
    }

    public function render()
    {
        return view('livewire.admin.course-manager', [
            'categories' => Category::all(),
            'ageGroups' => AgeGroup::all(),
        ]);
    }
}
