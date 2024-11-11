<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\AgeGroup;

class AgeGroupManager extends Component
{
    public $ageGroups;
    public $name;
    public $ageGroupId;
    public $showModal = false;
    public $min_age = 15; // Edad mínima predeterminada
    public $max_age = 0;

    protected $rules = [
        'name' => 'required|string|max:255',
        'min_age' => 'required|integer|min:15', // min_age debe ser al menos 15
        'max_age' => 'nullable|integer|gte:min_age', // max_age debe ser mayor o igual a min_age si se establece
    ];

    protected $listeners = [
        'setMinAge' => 'updateMinAge',
        'setMaxAge' => 'updateMaxAge',
    ];

    /**
     * Inicializa el componente y carga los grupos de edad desde la base de datos.
     * Este método se ejecuta al montar el componente y garantiza que $ageGroups contenga todos los registros actuales.
     *
     * @return void
     */
    public function mount()
    {
        $this->loadAgeGroups();
    }

    /**
     * Carga todos los registros de grupos de edad desde la base de datos.
     * Este método asigna los registros a la propiedad $ageGroups para su uso en la vista.
     *
     * @return void
     */
    public function loadAgeGroups()
    {
        $this->ageGroups = AgeGroup::all();
    }

    /**
     * Valida y guarda el grupo de edad en la base de datos.
     * Este método valida los datos del formulario y crea o actualiza el registro correspondiente.
     * Si se trata de una edición, se actualiza el registro existente; de lo contrario, se crea uno nuevo.
     * Al finalizar, reinicia el formulario y recarga la lista de grupos de edad.
     *
     * @return void
     */
    public function saveAgeGroup()
    {
        $this->validate();
        AgeGroup::updateOrCreate(
            ['id' => $this->ageGroupId],
            [
                'name' => $this->name,
                'min_age' => $this->min_age,
                'max_age' => $this->max_age,
            ]
        );

        $this->resetForm();
        $this->loadAgeGroups();
        session()->flash('message', $this->ageGroupId ? 'Grupo de edad actualizado.' : 'Grupo de edad creado.');

        $this->showModal = false;
    }

    /**
     * Prepara los datos de un grupo de edad específico para edición.
     * Establece los valores de las propiedades del grupo en las variables del formulario, y abre el modal de edición.
     *
     * @param int $id ID del grupo de edad a editar
     * @return void
     */
    public function editAgeGroup($id)
    {
        $ageGroup = AgeGroup::findOrFail($id);
        $this->ageGroupId = $ageGroup->id;
        $this->name = $ageGroup->name;
        $this->min_age = $ageGroup->min_age;
        $this->max_age = $ageGroup->max_age;

        $this->showModal = true;
    }

    /**
     * Elimina un grupo de edad de la base de datos.
     * Recarga la lista de grupos de edad después de la eliminación y muestra un mensaje de confirmación.
     *
     * @param int $id ID del grupo de edad a eliminar
     * @return void
     */
    public function deleteAgeGroup($id)
    {
        AgeGroup::findOrFail($id)->delete();
        $this->loadAgeGroups();
        session()->flash('message', 'Grupo de edad eliminado.');
    }

    /**
     * Reinicia el formulario del grupo de edad y restablece las propiedades a sus valores iniciales.
     * Este método limpia todos los campos, reinicia las validaciones, y asegura que el modal esté cerrado.
     *
     * @return void
     */
    public function resetForm()
    {
        $this->name = '';
        $this->ageGroupId = null;
        $this->min_age = 15; // Restablece la edad mínima predeterminada a 15
        $this->max_age = 0;

        $this->resetValidation(); // Limpia los errores de validación
        $this->showModal = true; // Asegura que el modal esté cerrado
    }

    /**
     * Renderiza la vista del componente `age-group-manager`.
     * Retorna la vista asociada al componente, pasando los datos requeridos para la visualización.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.admin.age-group-manager');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
