<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;

class Register extends Component
{
    public $listeners = [
        'save' => 'saveUser',
    ];

    public UserForm $form;

    public function saveUser()
    {
        $this->form->save();
    }

    public function render()
    {
        return view('livewire.pages.register');
    }
}
