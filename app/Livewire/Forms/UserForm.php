<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    #[Validate('required')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:8')]
    public string $password = '';

    public function save()
    {
        $this->validate();

        User::create($this->all());
        redirect()->route('home');
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'email.required' => 'O campo e-mail é obrigatório',
            'email.email' => 'Digite um e-mail válido',
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'A senha deve ter ao menos 8 caracteres',
        ];
    }
}
