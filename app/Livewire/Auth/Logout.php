<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Logout extends Component
{

    public function logout()
    {

        // Invalidate the session (destroys all session data)
        session()->invalidate();
        session_start();
        session_unset();
        Session::flush();
        Auth::logout();

        return $this->redirect('/', navigate: true); // redirect to login

    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
