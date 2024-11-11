<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Videos para el curso: {{ $course->title }}</h5>
                            <button class="btn bg-gradient-primary btn-sm" wire:click="resetForm">+ Nuevo Video</button>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Miniatura</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Título</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subtítulo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Duración</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($videos as $video)
                                        <tr>
                                            <td>
                                                <a href="#" wire:click="showVideo('{{ $video->url }}')" data-bs-toggle="modal" data-bs-target="#videoModal">
                                                    <img src="https://img.youtube.com/vi/{{ $this->getYouTubeID($video->url) }}/0.jpg" alt="Miniatura" class="img-thumbnail" style="width: 120px;">
                                                </a>
                                            </td>
                                            <td><p class="text-xs font-weight-bold mb-0">{{ $video->title }}</p></td>
                                            <td><p class="text-xs font-weight-bold mb-0">{{ $video->subtitle }}</p></td>
                                            <td><p class="text-xs font-weight-bold mb-0">{{ $video->duration }} mins</p></td>
                                            <td class="text-center">
                                            <a href="{{ route('admin.video-comments', ['videoId' => $video->id]) }}" class="mx-3" data-bs-toggle="tooltip" title="Ver Comentarios">
                                                <i class="fas fa-comments text-secondary"></i> <!-- Icono de comentarios -->
                                            </a>
                                        </td>
                                            <td class="text-center">
                                                <a href="#" wire:click="editVideo({{ $video->id }})" class="mx-3" data-bs-toggle="tooltip" title="Edit video">
                                                    <i class="fas fa-edit text-secondary"></i>
                                                </a>
                                                <a href="#" wire:click="deleteVideo({{ $video->id }})" data-bs-toggle="tooltip" title="Delete video">
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

        <!-- Modal para Crear/Editar Video -->
        @if($showModal)
            <div class="modal fade show" tabindex="-1" role="dialog" style="display: block; background: rgba(0, 0, 0, 0.5);">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $videoId ? 'Editar Video' : 'Nuevo Video' }}</h5>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="saveVideo">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Título</label>
                                    <input type="text" id="title" wire:model="title" class="form-control" placeholder="Título del video">
                                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="subtitle" class="form-label">Subtítulo</label>
                                    <input type="text" id="subtitle" wire:model="subtitle" class="form-control" placeholder="Subtítulo del video">
                                    @error('subtitle') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripcion</label>
                                    <input type="text" id="description" wire:model="description" class="form-control" placeholder="Descripcion del video">
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="url" class="form-label">URL</label>
                                    <input type="url" id="url" wire:model="url" class="form-control" placeholder="URL del video">
                                    @error('url') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Duración (minutos)</label>
                                    <input type="number" id="duration" wire:model="duration" class="form-control" placeholder="Duración en minutos">
                                    @error('duration') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">{{ $videoId ? 'Actualizar' : 'Guardar' }} Video</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal para Ver Video -->
        <div wire:ignore.self class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="videoModalLabel">Ver Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $videoUrl }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensaje de confirmación -->
        @if(session()->has('message'))
            <div class="alert alert-success mt-4">
                {{ session('message') }}
            </div>
        @endif
    </div>
</main>
