<?php

declare(strict_types=1);

arch('globals')
    ->expect([
        'dd',
        'dump',
        'ray',
        'die',
        'var_dump',
        'sleep',
        'dispatch_sync',
        'debugbar',
    ])
    ->not->toBeUsed()
    ->ignoring([
        \Laravel\Nova\Http\Controllers\NotificationDeleteAllController::class,
    ]);
