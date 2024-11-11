<div class="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Administración de Grupos de Edades</h5>
                        </div>
                        <button class="btn bg-gradient-primary btn-sm mb-0" wire:click="resetForm">
                            + Nuevo Grupo de Edad
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Edad Minima</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Edad Maxima</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ageGroups as $ageGroup)
                                    <tr>
                                        <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $ageGroup->id }}</p></td>
                                        <td><p class="text-xs font-weight-bold mb-0">{{ $ageGroup->name }}</p></td>
                                        <td><p class="text-xs font-weight-bold mb-0">{{ $ageGroup->min_age }}</p></td>
                                        <td><p class="text-xs font-weight-bold mb-0">{{ $ageGroup->max_age }}</p></td>
                                        <td class="text-center">
                                            <a href="#" wire:click="editAgeGroup({{ $ageGroup->id }})" class="mx-3" data-bs-toggle="tooltip" title="Edit age group">
                                                <i class="fas fa-edit text-secondary"></i>
                                            </a>
                                            <a href="#" wire:click="deleteAgeGroup({{ $ageGroup->id }})" data-bs-toggle="tooltip" title="Delete age group">
                                                <i class="fas fa-trash text-secondary"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Crear/Editar Grupo de Edad -->
    @if($showModal)
        <div class="modal fade show" id="ageGroupModal" tabindex="-1" role="dialog" aria-labelledby="ageGroupModalLabel" aria-hidden="true" style="display: block; background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ageGroupModalLabel">{{ $ageGroupId ? 'Editar Grupo de Edad' : 'Nuevo Grupo de Edad' }}</h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form wire:submit.prevent="saveAgeGroup">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del Grupo de Edad</label>
                            <input type="text" class="form-control" id="name" wire:model="name" placeholder="Nombre">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="min_age" class="form-label">Edad Mínima: <strong id="min_age_display">{{ $min_age }} años</strong></label>
                            <input type="range" id="min_age" wire:model="min_age" min="15" max="100" class="form-range">
                            @error('min_age') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="max_age" class="form-label">Edad Máxima (Opcional): <strong id="max_age_display">{{ $max_age }} años</strong></label>
                            <input type="range" id="max_age" wire:model="max_age" min="{{ $min_age }}" max="100" class="form-range">
                            @error('max_age') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">{{ $ageGroupId ? 'Actualizar' : 'Guardar' }} Grupo de Edad</button>
                        </div>
                    </form>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            initSliders();
        });

        function initSliders() {
            const minSlider = document.getElementById('min_age');
            const maxSlider = document.getElementById('max_age');
            const minAgeDisplay = document.getElementById('min_age_display');
            const maxAgeDisplay = document.getElementById('max_age_display');

            minSlider.oninput = function() {
                minAgeDisplay.innerText = `${this.value} años`;
                Livewire.emit('setMinAge', this.value); // Emite el valor a Livewire
                maxSlider.min = this.value; // Asegura que max_age sea mayor o igual a min_age
            };

            maxSlider.oninput = function() {
                maxAgeDisplay.innerText = `${this.value} años`;
                Livewire.emit('setMaxAge', this.value); // Emite el valor a Livewire
            };
        }

        initSliders();
    });
</script>
@endpush

 

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
