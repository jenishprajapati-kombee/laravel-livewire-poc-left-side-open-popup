<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Livewire\Attributes\Layout;

#[Layout('components.layout.auth')]

class ResetPassword extends Component
{
    public $token;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ];

    public function __construct()
    {
        // Init layout file
        app(config('settings.KT_THEME_BOOTSTRAP.auth'))->init();
    }

    public function mount($token)
    {
        $this->token = $token;
    }

    public function resetPassword()
    {
        $this->validate();

        $status = Password::broker('users')->reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            session()->flash('success', __('messages.login.reset_password_success'));
            return $this->redirect('/', navigate: true);
        } else {
            session()->flash('error', __('messages.login.invalid_email_error'));
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password')->title(__('messages.meta_titles.reset_passowrd'));
    }
}
