<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Instructor;
use Illuminate\Validation\Rule;

class InstructorManager extends Component
{
    public $instructors;
    public $name, $facebook_url, $twitter_url, $other_social_url;
    public $instructorId;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'facebook_url' => 'nullable|url',
        'twitter_url' => 'nullable|url',
        'other_social_url' => 'nullable|url',
    ];

    public function mount()
    {
        $this->loadInstructors();
    }

    public function loadInstructors()
    {
        $this->instructors = Instructor::withTrashed()->get(); // Incluye los eliminados
    }

    public function saveInstructor()
    {
        $this->validate();

        Instructor::updateOrCreate(
            ['id' => $this->instructorId],
            [
                'name' => $this->name,
                'facebook_url' => $this->facebook_url,
                'twitter_url' => $this->twitter_url,
                'other_social_url' => $this->other_social_url,
            ]
        );

        $this->resetForm();
        $this->loadInstructors();
        session()->flash('message', $this->instructorId ? 'Instructor actualizado.' : 'Instructor creado.');
        $this->showModal = false;
    }

    public function editInstructor($id)
    {
        $instructor = Instructor::withTrashed()->findOrFail($id);
        $this->instructorId = $instructor->id;
        $this->name = $instructor->name;
        $this->facebook_url = $instructor->facebook_url;
        $this->twitter_url = $instructor->twitter_url;
        $this->other_social_url = $instructor->other_social_url;
        $this->showModal = true;
    }

    public function deleteInstructor($id)
    {
        Instructor::findOrFail($id)->delete();
        $this->loadInstructors();
        session()->flash('message', 'Instructor dado de baja.');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->facebook_url = '';
        $this->twitter_url = '';
        $this->other_social_url = '';
        $this->instructorId = null;
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.admin.instructor-manager');
    }
}
