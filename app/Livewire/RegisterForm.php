<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegisterForm extends Component
{
    #[Validate('required')]
    public string $name = '';

    public function submit()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
        ]);

        Auth::login($user, true);

        $this->redirect(
            route('game.create')
        );
    }

    public function render(): View
    {
        return view('livewire.register-form');
    }
}
