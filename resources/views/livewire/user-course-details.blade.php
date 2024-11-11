<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Videos para el curso: {{ $course->title }}</h5>
                            @if($isEnrolled)
                                <p>Estás inscrito en este curso.</p>
                            @else
                                <button class="btn bg-gradient-primary btn-sm" wire:click="enroll">
                                    Inscribirme
                                </button>
                            @endif
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
                                                <img src="https://img.youtube.com/vi/{{ $this->getYouTubeID($video->url) }}/0.jpg" alt="Miniatura" class="img-thumbnail" style="width: 120px;">
                                            </td>
                                            <td><p class="text-xs font-weight-bold mb-0">{{ $video->title }}</p></td>
                                            <td><p class="text-xs font-weight-bold mb-0">{{ $video->subtitle }}</p></td>
                                            <td><p class="text-xs font-weight-bold mb-0">{{ $video->duration }} mins</p></td>
                                            <td class="text-center">
                                                @if($isEnrolled)
                                                    <button wire:click="likeVideo({{ $video->id }})" class="btn btn-link" title="Dar Like">
                                                        <i class="fas fa-thumbs-up {{ in_array($video->id, $likedVideos) ? 'text-success' : 'text-secondary' }}"></i>
                                                    </button>
                                                    @if($this->hasComment($video->id))
                                                        <p class="text-xs text-muted">{{ $this->getComment($video->id) }}</p>
                                                    @else
                                                        <button wire:click="commentOnVideo({{ $video->id }})" class="btn btn-link" title="Comentar">
                                                            <i class="fas fa-comment text-secondary"></i>
                                                        </button>
                                                    @endif
                                                      <!-- Botón de Terminar Video -->
                                                    <button wire:click="markVideoAsCompleted({{ $video->id }})" class="btn btn-link" title="Marcar como Terminado">
                                                        <i class="fas fa-check-circle {{ in_array($video->id, $completedVideos) ? 'text-success' : 'text-secondary' }}"></i>
                                                        {{ in_array($video->id, $completedVideos) ? 'Terminado' : 'Terminar' }}
                                                    </button>
                                                @else
                                                    <span class="text-muted">Debes inscribirte para interactuar</span>
                                                @endif
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

        <!-- Modal para Comentarios -->
        @if($showCommentModal)
            <div class="modal fade show" tabindex="-1" role="dialog" style="display: block; background: rgba(0, 0, 0, 0.5);">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Agregar Comentario</h5>
                            <button type="button" class="btn-close" wire:click="$set('showCommentModal', false)" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <textarea wire:model="comment" class="form-control" placeholder="Escribe tu comentario aquí"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$set('showCommentModal', false)">Cerrar</button>
                            <button type="button" class="btn btn-primary" wire:click="addComment">Enviar Comentario</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

       <!-- Mensajes de Confirmación y Error -->
        @if(session()->has('message'))
            <div class="alert alert-success mt-4">
                {{ session('message') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger mt-4">
                {{ session('error') }}
            </div>
        @endif
    </div>
</main>
