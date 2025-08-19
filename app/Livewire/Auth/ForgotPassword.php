<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\RateLimiter;
use App\Helper;

#[Layout('components.layout.auth')]

class ForgotPassword extends Component
{
    // Settings variables
    public $email;

    /**
     * login
     *
     * @return void
     */
    public function __construct()
    {
        // Init layout file
        app(config('settings.KT_THEME_BOOTSTRAP.auth'))->init();
    }

    public function mount()
    {
        $this->dispatch('autoFocusElement', elId: 'email');
    }

    public function forgotPassword()
    {
        $this->email = str_replace(' ', '', $this->email);

        // Validate parameters
        $this->validate([
            'email' => 'required|email:rfc,dns|max:191',
        ]);

        //Rate Limitor For Resend Otp 5 times PerMinute
        $ipPerDay = RateLimiter::tooManyAttempts('ip_restrication'.request()->ip(), config('constants.rate_limiting.limit.ip_attempt_limit'));
        if ($ipPerDay == true) {
            session()->flash('error', __('messages.login.ratelimit_ip_restrication'));
        }

        $mailPerDay = RateLimiter::tooManyAttempts('email_restrication'.$this->email, config('constants.rate_limiting.limit.email_attempt_limit'));
        if ($mailPerDay == true) {
            session()->flash('error', __('messages.login.ratelimit_email_restrication'));
        }

        $executed = RateLimiter::attempt(
            'FGT'.$this->email,
            $perMinute = 1,
            function () {
                // Send message...
            },
            config('constants.rate_limiting.limit.forgot_password')
        );

        if (! $executed) {
            $this->clearForm();
            Helper::logError(static::class, __FUNCTION__, __('messages.login.ratelimit_forgot_password'), ['email' => $this->email]);
            session()->flash('error', __('messages.login.ratelimit_forgot_password'));
        }

        $status = Password::broker('users')->sendResetLink(
            ['email' => $this->email]
        );

        if ($status == Password::RESET_LINK_SENT) {
            // Increment the rate limiter attempts
            RateLimiter::hit('ip_restrication'.request()->ip(), config('constants.rate_limiting.limit.one_day'));
            RateLimiter::hit('email_restrication'.$this->email, config('constants.rate_limiting.limit.one_day'));

            session()->flash('success', __('messages.login.forgot_password_success'));
            return $this->redirect('/', navigate: true); // redirect to user listing
        } else {
            Helper::logError(static::class, __FUNCTION__, __('messages.login.invalid_email_error'), ['email' => $this->email]);
            session()->flash('error', __('messages.login.invalid_email_error'));
        }
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.auth.forgot-password')->title(__('messages.meta_titles.forgot_passowrd'));
    }

    /**
     * clearForm
     *
     * @return void
     */
    public function clearForm()
    {
        $this->email = '';
    }
}
