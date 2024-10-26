<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

        $user = User::where('email', $this->email)->first();
        if (!is_null($user)) {
            $this->addError('email', 'E-mail já está cadastrado!');
            return;
        }
        User::create($this->all());
        return redirect()->route('home');
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user =Auth::user();
            session()->put('user', $user);
            return redirect()->route('home')->with('success', 'Login realizado com sucesso.');
        } else {
            $this->addError('email', 'E-mail ou senha incorretos.');
            return;
        }
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
