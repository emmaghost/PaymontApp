<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;

class CategoryManager extends Component
{
    public $categories;
    public $name;
    public $categoryId;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::all();
    }

    public function saveCategory()
    {
        $this->validate();

        Category::updateOrCreate(
            ['id' => $this->categoryId],
            ['name' => $this->name]
        );

        $this->resetForm();
        $this->loadCategories();
        session()->flash('message', $this->categoryId ? 'Categoría actualizada.' : 'Categoría creada.');

        $this->showModal = false;
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;

        $this->showModal = true;
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        $this->loadCategories();
        session()->flash('message', 'Categoría eliminada.');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->categoryId = null;

        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.admin.category-manager');
    }
}
