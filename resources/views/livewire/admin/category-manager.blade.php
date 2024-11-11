<div class="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Administración de Categorías</h5>
                        </div>
                        <button class="btn bg-gradient-primary btn-sm mb-0" wire:click="resetForm">
                            + Nueva Categoría
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
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td class="ps-4"><p class="text-xs font-weight-bold mb-0">{{ $category->id }}</p></td>
                                        <td><p class="text-xs font-weight-bold mb-0">{{ $category->name }}</p></td>
                                        <td class="text-center">
                                            <a href="#" wire:click="editCategory({{ $category->id }})" class="mx-3" data-bs-toggle="tooltip" title="Edit category">
                                                <i class="fas fa-edit text-secondary"></i>
                                            </a>
                                            <a href="#" wire:click="deleteCategory({{ $category->id }})" data-bs-toggle="tooltip" title="Delete category">
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

    <!-- Modal para Crear/Editar Categoría -->
    @if($showModal)
        <div class="modal fade show" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true" style="display: block; background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalLabel">{{ $categoryId ? 'Editar Categoría' : 'Nueva Categoría' }}</h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="saveCategory">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre de la Categoría</label>
                                <input type="text" class="form-control" id="name" wire:model="name" placeholder="Nombre">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Cerrar</button>
                                <button type="submit" class="btn btn-primary">{{ $categoryId ? 'Actualizar' : 'Guardar' }} Categoría</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
