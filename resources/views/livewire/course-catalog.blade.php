<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-4">
            <input type="text" class="form-control" wire:model.lazy="search" placeholder="Buscar por nombre de curso">
        </div>
        <div class="col-md-3">
            <select wire:model="selectedCategory" class="form-control">
                <option value="">Selecciona una categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select wire:model="age_group_id" class="form-control">
                <option value="">Selecciona un grupo de edad</option>
                @foreach($ageGroups as $ageGroup)
                    <option value="{{ $ageGroup->id }}">{{ $ageGroup->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100" wire:click="loadCourses">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </div>

    <div class="row">
        @forelse($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->title }}</h5>
                        <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                        <p class="text-muted">{{ $course->category->name }} | {{ $course->ageGroup->range }}</p>
                        <a href="{{ route('course.detail', ['courseId' => $course->id]) }}" class="btn btn-primary">Ver Curso</a>
                        </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p>No se encontraron cursos con los filtros aplicados.</p>
            </div>
        @endforelse
    </div>
</div>
