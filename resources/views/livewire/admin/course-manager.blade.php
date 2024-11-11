<div class="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Administración de Cursos</h5>
                        </div>
                        <button class="btn bg-gradient-primary btn-sm mb-0" wire:click="resetForm">
                            + Nuevo Curso
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Título
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Descripción
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Categoría
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Grupo de Edad
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Usuarios Registrados al Curso
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Acción
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $course->id }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $course->title }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ Str::limit($course->description, 50) }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $course->category->name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $course->ageGroup->name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.course-user-progress', ['courseId' => $course->id]) }}" class="text-xs font-weight-bold text-decoration-underline">
                                                {{ $course->users()->count() }} Usuarios
                                            </a>
                                        </td>
                                       
                                        <td class="text-center">
                                            <a href="#" wire:click="editCourse({{ $course->id }})" class="mx-3" data-bs-toggle="tooltip" title="Edit course">
                                                <i class="fas fa-edit text-secondary"></i>
                                            </a>
                                            <a href="#" wire:click="deleteCourse({{ $course->id }})" data-bs-toggle="tooltip" title="Delete course">
                                                <i class="fas fa-trash text-secondary"></i>
                                            </a>
                                            <a href="{{ route('admin.video-manager', ['courseId' => $course->id]) }}" class="mx-3" data-bs-toggle="tooltip" title="Manage Videos">
                                            <i class="fas fa-video text-secondary"></i> <!-- Icono para el manejo de videos -->
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

    <!-- Modal para Crear/Editar Curso -->
    @if($showModal)
    <div class="modal fade show" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="courseModalLabel" aria-hidden="true" style="display: block; background: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="courseModalLabel">{{ $courseId ? 'Editar Curso' : 'Nuevo Curso' }}</h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveCourse">
                        <!-- Campos del formulario -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="title" wire:model="title" placeholder="Título del curso">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" wire:model="description" placeholder="Descripción del curso"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Categoría</label>
                            <select class="form-select" id="category_id" wire:model="category_id">
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="age_group_id" class="form-label">Grupo de Edad</label>
                            <select class="form-select" id="age_group_id" wire:model="age_group_id">
                                <option value="">Selecciona un grupo de edad</option>
                                @foreach($ageGroups as $ageGroup)
                                    <option value="{{ $ageGroup->id }}">{{ $ageGroup->name }}</option>
                                @endforeach
                            </select>
                            @error('age_group_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Cerrar</button>
                            <button type="submit" class="btn btn-primary">{{ $courseId ? 'Actualizar' : 'Guardar' }} Curso</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

</div>
