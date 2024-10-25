<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use Livewire\Component;

class Login extends Component
{
    public $listeners = [
        'save' => 'saveUser',
    ];

    public UserForm $form;

    public function login()
    {
        $this->form->login();
    }

    public function render()
    {
        return view('livewire.pages.login');
    }
}
