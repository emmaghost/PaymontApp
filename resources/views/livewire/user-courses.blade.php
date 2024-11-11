<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
    <style>
            .progress {
                height: 20px;
                background-color: #e9ecef;
                border-radius: 8px;
            }
            .progress-bar {
                font-size: 0.85rem;
                font-weight: bold;
                height: 11px;
                color: #fff;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        </style>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h5 class="mb-0">Mis Cursos</h5>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Título del Curso</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progreso</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userCourses as $course)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $course->title }}</p>
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $course->user_progress }}%;" aria-valuenow="{{ $course->user_progress }}" aria-valuemin="0" aria-valuemax="100">{{ $course->user_progress }}%</div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('course.detail', ['courseId' => $course->id]) }}" class="btn btn-sm btn-primary">Ver Curso</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($userCourses->isEmpty())
                                <div class="text-center py-4">
                                    <p>No estás registrado en ningún curso actualmente.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
