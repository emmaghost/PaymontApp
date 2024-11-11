<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;
use App\Http\Livewire\Admin\CourseManager;
use App\Http\Livewire\Admin\CourseUserProgress;
use App\Http\Livewire\Admin\VideoManager;
use App\Http\Livewire\Admin\VideoCommentsManager;
use App\Http\Livewire\CourseSearch;
use App\Http\Livewire\UserCourseDetails;



use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\LaravelExamples\UserManagement;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect('/login');
});

Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');

Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

// Rutas protegidas por autenticación para todos los usuarios
Route::middleware('auth')->group(function () {
    // Rutas accesibles para ambos roles
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/billing', Billing::class)->name('billing');
});

// Rutas específicas para el rol de administrador
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/tables', Tables::class)->name('tables'); // Si es una vista administrativa
    Route::get('/rtl', Rtl::class)->name('rtl'); // Opcional según tus necesidades
    Route::get('/admin/courses', CourseManager::class)->name('admin.courses');
    Route::get('/admin/categories', App\Http\Livewire\Admin\CategoryManager::class)->name('admin.categories');
    Route::get('/admin/age-groups', App\Http\Livewire\Admin\AgeGroupManager::class)->name('admin.age-groups');
    Route::get('/admin/courses/{courseId}/videos', VideoManager::class)->name('admin.video-manager');
    Route::get('/laravel-user-profile', UserProfile::class)->name('user-profile');
    Route::get('/laravel-user-management', UserManagement::class)->name('user-management');
    Route::get('/admin/course/{courseId}/progress', CourseUserProgress::class)->name('course.user.progress');

    Route::get('/admin/course/{courseId}/user-progress', CourseUserProgress::class) ->name('admin.course-user-progress');     
    Route::get('/admin/video-comments/{videoId}', VideoCommentsManager::class)->name('admin.video-comments');




});

// Rutas específicas para el rol de usuario
Route::middleware(['auth', 'role:user'])->group(function () {
    // Opcional: agrega rutas exclusivas para el rol `user` aquí, si es necesario.
    Route::get('/laravel-user-profile', UserProfile::class)->name('user-profile');
    //Route::get('/courses', CourseSearch::class)->name('user.course.search');
    Route::get('/courses', App\Http\Livewire\CourseCatalog::class)->name('courses.catalog');

    Route::get('/courses/{courseId}/register', [CourseController::class, 'register'])->name('user.course.register');
    Route::get('/curso/{courseId}', UserCourseDetails::class)->name('course.detail');
    Route::get('/mis-cursos', \App\Http\Livewire\UserCourses::class)->name('user.courses');




});

Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');



