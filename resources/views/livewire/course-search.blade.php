<div class="container my-4">
    <h4 class="mb-4">Buscar Cursos Disponibles</h4>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-md-3">
            <select class="form-control" wire:model="ageGroup">
                <option value="">Seleccione Grupo de Edad</option>
                @foreach($ageGroups as $age)
                    <option value="{{ $age->id }}">{{ $age->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-control" wire:model="category">
                <option value="">Seleccione Categoría</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" placeholder="Buscar por nombre" wire:model="name">
        </div>
    </div>

    <!-- Cursos Disponibles -->
    <div class="row">
        @forelse($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->title }}</h5>
                        <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                        <p><strong>Grupo de Edad:</strong> {{ $course->ageGroup->name }}</p>
                        <p><strong>Categoría:</strong> {{ $course->category->name }}</p>
                        <a href="{{ route('user.course.register', $course->id) }}" class="btn btn-primary btn-sm">Registrarse</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No se encontraron cursos con los filtros seleccionados.</p>
            </div>
        @endforelse
    </div>
</div>
