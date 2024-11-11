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
    Route::get('/laravel-user-management', UserManagement::class)->name('user-management');
});

// Rutas específicas para el rol de usuario
Route::middleware(['auth', 'role:user'])->group(function () {
    // Opcional: agrega rutas exclusivas para el rol `user` aquí, si es necesario.
    Route::get('/laravel-user-profile', UserProfile::class)->name('user-profile');
});

Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');