<?php

declare(strict_types=1);

arch()->preset()->php()
    ->ignoring(\Laravel\Nova\Fields\ResourceRelationshipGuesser::class);

arch()->preset()->security()
    ->ignoring([
        \App\Models\User::class,
        \Laravel\Nova\Asset::class,
        \Laravel\Nova\Auth\Adapters\SessionImpersonator::class,
        \Laravel\Nova\Dashboard::class,
        \Laravel\Nova\Fields\Gravatar::class,
        \Laravel\Nova\Menu\MenuGroup::class,
        \Laravel\Nova\Menu\MenuSection::class,
        \Laravel\Nova\Metrics\Metric::class,
    ]);

arch()->preset()->laravel()
    ->ignoring([
        'App\Http\Controllers',
        'App\Http\Middleware',
        'App\Notifications\Channels',
        \App\Providers\TelescopeServiceProvider::class,
    ]);

arch('strict types')
    ->expect('App')
    ->toUseStrictTypes();

arch('avoid open for extension')
    ->expect('App')
    ->classes()
    ->toBeFinal()
    ->ignoring([
        'App\Livewire',
        'App\Nova',
        'App\Services',
        \App\Http\Controllers\Controller::class,
    ]);

test('ensure no extends')
    ->expect('App')
    ->classes()
    ->not->toBeAbstract()
    ->ignoring([
        'App\Nova',
        'App\RedisResolvers',
        'App\Services',
    ]);

arch('avoid mutation')
    ->expect('App')
    ->classes()
    ->toBeReadonly()
    ->ignoring([
        'App\Console\Commands',
        'App\Events',
        'App\Exceptions',
        'App\Http\Requests',
        'App\Jobs',
        'App\Listeners',
        'App\Livewire',
        'App\Mail',
        'App\Models',
        'App\Notifications',
        'App\Nova',
        'App\Providers',
        'App\RedisResolvers',
        \App\Rules\ValidFormProblemRegex::class,
        'App\Services',
        'App\View',
        App\Services\Autocomplete::class,
    ]);

arch('avoid inheritance')
    ->expect('App')
    ->classes()
    ->toExtendNothing()
    ->ignoring([
        'App\Console\Commands',
        'App\Exceptions',
        'App\Http\Requests',
        'App\Jobs',
        'App\Livewire',
        'App\Mail',
        'App\Models',
        'App\Notifications',
        'App\Nova',
        'App\Providers',
        'App\RedisResolvers',
        'App\Services',
        'App\View',
    ]);
