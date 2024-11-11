<div class="main-content">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h5 class="mb-0">Progreso de Usuarios para el Curso: {{ $course ? $course->title : 'No disponible' }}</h5>
                        <button class="btn bg-gradient-primary btn-sm">Mandar Promo</button>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if($users && $users->isNotEmpty())
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Progreso</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Último Video Completado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td class="ps-4">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $user->id }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $user->name }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $user->progress }}%</p>
                                                </td>
                                                <td>
                                                    @if($user->last_video)
                                                        <p class="text-xs font-weight-bold mb-0">{{ $user->last_video->title }}</p>
                                                    @else
                                                        <p class="text-xs font-weight-bold text-muted">No ha completado ningún video</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center my-4">
                                <p class="text-secondary font-weight-bold mb-0">No hay usuarios inscritos en este curso.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
