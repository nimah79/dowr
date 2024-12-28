<?php

declare(strict_types=1);

arch('factories')
    ->expect('Database\Factories')
    ->toExtend(\Illuminate\Database\Eloquent\Factories\Factory::class)
    ->ignoring('Database\Factories\Concerns')
    ->toHaveMethod('definition')
    ->ignoring('Database\Factories\Concerns')
    ->toOnlyBeUsedIn([
        'App\Models',
    ]);
