<div class="card">
    <div class="card-header">
        <h5>Comentarios y Estadísticas del Video</h5>
        <p><strong>Vistas:</strong> {{ $viewsCount }}</p>
        <p><strong>Likes:</strong> {{ $likeCount }}</p>
    </div>
    <div class="card-body">
        <h6>Comentarios</h6>
        <table class="table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Comentario</th>
                    <th>Aprobado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                    <tr>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->content }}</td>
                        <td>{{ $comment->is_approved ? 'Sí' : 'No' }}</td>
                        <td>
                            @if(!$comment->is_approved)
                                <button wire:click="approveComment({{ $comment->id }})" class="btn btn-success btn-sm">Aprobar</button>
                            @else
                                <button wire:click="declineComment({{ $comment->id }})" class="btn btn-danger btn-sm">Rechazar</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No hay comentarios</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
