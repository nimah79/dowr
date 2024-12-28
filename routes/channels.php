<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('game.{gameId}', fn (User $user, int $gameId): array => [
    'id' => $user->id,
    'name' => $user->name,
    'gameId' => $gameId,
]);
