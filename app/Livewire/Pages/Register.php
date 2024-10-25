<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Register extends Component
{
    public $listeners = [
        'save' => 'saveUser',
    ];

    public function saveUser(string $name = null, string $email = null, string $password = null)
    {
        if ($name && $email && $password) {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            $this->redirectRoute('home');
        }
    }

    public function render()
    {
        return view('livewire.pages.register');
    }
}
