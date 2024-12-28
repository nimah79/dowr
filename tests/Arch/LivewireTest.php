<?php

declare(strict_types=1);

arch('livewire components')
    ->expect('App\Livewire')
    ->toBeClasses()
    ->ignoring('App\Livewire\Traits')
    ->toOnlyBeUsedIn([
        'App\Http\Controllers',
        'App\Livewire',
        \App\Providers\LivewireServiceProvider::class,
    ])
    ->ignoring('App\Livewire\Traits')
    ->not->toUse(['redirect', 'to_route', 'back']);

arch('livewire traits')
    ->expect('App\Livewire\Traits')
    ->toBeTraits();
