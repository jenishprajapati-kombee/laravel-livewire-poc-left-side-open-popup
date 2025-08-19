<?php

namespace App\Livewire\Auth;

use App\Rules\ReCaptcha;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Helper;

#[Layout('components.layout.auth')]

class Login extends Component
{
    // Settings variables
    public $email;

    public $password;

    public $passwordVisible = false;

    public $recaptchaToken;

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

    public function login()
    {

        $this->email = str_replace(' ', '', $this->email);

        // Validate parameters
        $this->validate([
            'email' => 'required|email|max:191',
            'password' => 'required|min:6|max:191',
        ]);

        if (App::environment(['production', 'uat'])) {
            $recaptchaResponse = ReCaptcha::verify($this->recaptchaToken);
            if (! $recaptchaResponse['success']) {
                $this->clearForm(); //clear all form data
                session()->flash('error', __('messages.login.recaptchaError'));
            }
        }

        $email = Str::lower($this->email);

        $credentials = [
            'email' => $email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) { // User Found
            $user = Auth::user();

            session_start();
            $_SESSION['user_id'] = $user->id;

            if (App::environment(['production', 'uat'])) {
                Auth::logoutOtherDevices($email); // Logout all other sessions
            }

            $this->clearForm(); //clear all form data

            if ($user->status != config('constants.user.status.key.active')) {
                //INACTIVE user error handling
                session()->flash('error', __('messages.login.unverified_account'));
            } elseif ($user->role_id == null) {
                //INVALID user error handling
                session()->flash('error',  __('messages.login.email_invalid_error'));
            } else {
                session()->flash('success', __('messages.login.success'));

                // add successfully login attempt for historical data
                //User::addUserAuthHistory($user->emp_code, $this->device_token, config('constants.auth_history_type.key.login'));

                return $this->redirect('/dashboard', navigate: true); // redirect to user listing
            }
        } else {
            Helper::logInfo(static::class, __FUNCTION__, __('messages.login.invalid_credentials_error'), ['email' => $email]);
            session()->flash('error', __('messages.login.invalid_credentials_error'));
        }

    }

    public function render()
    {
        return view('livewire.auth.login')->title(__('messages.meta_titles.login'));
    }

    /**p
     * clearForm
     *
     * @return void
     */
    public function clearForm()
    {
        $this->email = '';
        $this->password = '';
    }

    public function togglePasswordVisibility()
    {
        $this->passwordVisible = ! $this->passwordVisible;
    }
}
