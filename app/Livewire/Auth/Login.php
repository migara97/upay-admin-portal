<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $password;
    public $email;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->intended(route('admin.dashboard'));
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');;
    }

    public function submit()
    {
        $this->validate();

        if (Auth::attempt(array('email' => $this->email, 'password' => $this->password))) {
            return redirect()->intended(route('admin.dashboard'));
        }
    }
}
