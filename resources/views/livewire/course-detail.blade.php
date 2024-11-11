<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h2>{{ $course->title }}</h2>
            <p>{{ $course->description }}</p>
            <p><strong>Categoría:</strong> {{ $course->category->name }}</p>
            <p><strong>Grupo de Edad:</strong> {{ $course->ageGroup->name }}</p>
            <p><strong>Total de Videos:</strong> {{ $videoCount }}</p>
        </div>
        <div class="col-md-4">
            @if(auth()->user()->courses->contains($course->id))
                <button class="btn btn-success" disabled>Ya estás inscrito</button>
            @else
                <button class="btn btn-primary" wire:click="enroll">Inscribirme</button>
            @endif
        </div>
    </div>

    @if(session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>
