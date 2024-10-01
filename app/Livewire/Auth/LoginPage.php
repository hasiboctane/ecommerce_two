<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login - Dress Zone')]
class LoginPage extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        if (!auth()->guard()->attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('error','Invalid Credentials');
            return;
        }

        return redirect()->intended();
    }
    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
