<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegisterForm extends Component
{
    #[Validate('required')]
    public string $name = '';

    #[Locked]
    public string $redirectUrl;

    public function mount(): void
    {
        $this->redirectUrl = url()->previous() ?: route('game.create');
    }

    public function submit(): void
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
        ]);

        Auth::login($user, true);

        $this->redirect($this->redirectUrl);
    }

    public function render(): View
    {
        return view('livewire.register-form');
    }
}
