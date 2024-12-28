<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('game.{gameId}', function (User $user, int $gameId) {
    return [
        'id' => $user->id,
        'name' => $user->name,
        'gameId' => $gameId,
    ];
});
