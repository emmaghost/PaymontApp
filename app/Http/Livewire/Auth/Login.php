<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember_me = false;

    protected $rules = [
        'email' => 'required|email:rfc,dns',
        'password' => 'required',
    ];

    public function mount() {
        if(auth()->user()){
            redirect('/dashboard');
        }
        $this->fill(['email' => 'admin@softui.com', 'password' => 'secret']);
    }

    public function login() {
        $credentials = $this->validate();
        if(auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            $user = User::where(["email" => $this->email])->first();
            auth()->login($user, $this->remember_me);
             
            // Redirigir según el rol del usuario
            if ($user->hasRole('admin')) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->hasRole('user')) {
                return redirect()->intended('/dashboard');
            }
            // Redirección por defecto si no tiene rol específico
            return redirect()->intended('/dashboard');
        }
        else{
            return $this->addError('email', trans('auth.failed')); 
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
