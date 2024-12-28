<?php

declare(strict_types=1);

arch('commands')
    ->expect('App\Console\Commands')
    ->toExtend(\Illuminate\Console\Command::class)
    ->toHaveSuffix('Command')
    ->toHaveMethod('handle')
    ->not->toBeUsed();
