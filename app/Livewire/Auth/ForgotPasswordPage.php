<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Forgot-Password - Dress Zone')]
class ForgotPasswordPage extends Component
{
    public $email;
    public function sendMail()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email'
        ]);
        $status = Password::sendResetLink(['email' => $this->email]);
        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Reset password link sent to your email');
            $this->email = '';
        }
    }
    public function render()
    {
        return view('livewire.auth.forgot-password-page');
    }
}
