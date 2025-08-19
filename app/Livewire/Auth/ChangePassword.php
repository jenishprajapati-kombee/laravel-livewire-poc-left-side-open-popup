<?php

namespace App\Livewire\Auth;

use App\Livewire\Breadcrumb;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Helper;

class ChangePassword extends Component
{
    public $old_password;
    public $new_password;
    public $confirm_password;

    /**
     * login
     *
     * @return void
     */
    public function __construct()
    {
        // Init layout file
        app(config('settings.KT_THEME_BOOTSTRAP.default'))->init();
    }

    /**
     * @return void
     */
    public function mount()
    {
        /* begin::Set breadcrumb */
        $segmentsData = [
            'title' => __('messages.login.change_password_title')
        ];
        $this->dispatch('breadcrumbList', $segmentsData)->to(Breadcrumb::class);
        /* end::Set breadcrumb */

        $this->dispatch('autoFocusElement', elId: 'new_name');
    }

    public function rules()
    {
        return [
            'old_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    return $fail(__('The old password is incorrect.'));
                }
            }],
            'new_password' => [
                'required',
                'required_with:confirm_password',
                'same:confirm_password',
                'different:old_password',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#@&:%]).*$/',
                'min:8',
                'max:255',
            ],
            'confirm_password' => [
                'required',
                'min:6',
                'max:255',
            ],
        ];
    }

    public function messages()
    {
        return [
            'new_password.regex' => __('messages.login.invalid_new_password_error'),
        ];
    }

    public function changePassword()
    {
        $this->validate();
        $data = [
            'old_password' => trim($this->old_password),
            'new_password' => trim($this->new_password),
            'confirm_password' => trim($this->confirm_password)
        ];

        $user = auth('web')->user();
        $masterUser = User::where('email', $user->email)->first();

        if (Hash::check($data['old_password'], $masterUser->password)) {
            $masterData['password'] = bcrypt($data['new_password']);
            //update user password in master user table
            if ($masterUser->update($masterData)) {

                session()->flash('success', __('messages.login.change_password_success'));

                return $this->redirect('/users', navigate: true); // redirect to user listing

            } else {
                Helper::logError(static::class, __FUNCTION__, __('messages.common_error_message'), ['email' => $user->email], $masterUser);
                session()->flash('error', __('messages.common_error_message'));
            }
        } else {
            Helper::logError(static::class, __FUNCTION__, __('messages.login.wrong_password'), ['email' => $user->email]);
            session()->flash('error', __('messages.common_error_message'));
        }
    }

    /**
     * cancel
     *
     * @return void
     */
    public function cancel()
    {
        return $this->redirect('/users', navigate: true); // redirect to users listing page
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.auth.change-password')->title(__('messages.meta_titles.change_passowrd'));
    }
}
