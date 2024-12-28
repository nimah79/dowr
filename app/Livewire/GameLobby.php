<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Events\GameStarted;
use App\Events\GameUsersUpdated;
use App\Models\Game;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class GameLobby extends Component
{
    #[Locked]
    public Game $game;

    #[Locked]
    public Collection $teams;

    public function getListeners(): array
    {
        return [
            "echo-presence:game.{$this->game->id},here" => 'getTeams',
            "echo-presence:game.{$this->game->id},joining" => 'getTeams',
            "echo-presence:game.{$this->game->id},GameUsersUpdated" => 'getTeams',
            "echo-presence:game.{$this->game->id},GameStarted" => 'gameStarted',
        ];
    }

    public function mount(): void
    {
        $alreadyJoined = Team::whereBelongsTo($this->game)
            ->whereHas('users', function (Builder $query): void {
                $query->where('users.id', auth()->id());
            })
            ->exists();
        if (! $alreadyJoined) {
            $team = Team::whereBelongsTo($this->game)
                ->join('team_user', 'teams.id', '=', 'team_user.team_id')
                ->select('teams.*')
                ->selectRaw('count(*) as users_count')
                ->groupBy('teams.id')
                ->having('users_count', '=', 1)
                ->first();
            if (is_null($team)) {
                $team = $this->game->teams()->create([
                    'remaining_time' => Config::integer('game.initial_remaining_time'),
                ]);
            }
            $team->users()->syncWithoutDetaching([auth()->id()]);
        }
        $this->getTeams();
    }

    public function getTeams(): void
    {
        $this->teams = $this->game
            ->teams()
            ->with('users')
            ->get();
    }

    public function shuffleUsers(): void
    {
        $users = User::whereHas('teams', function (Builder $query): void {
            $query->whereBelongsTo($this->game);
        })
            ->pluck('id')
            ->shuffle();
        $this->game->teams()->delete();
        foreach ($users->chunk(2) as $userIds) {
            $team = $this->game
                ->teams()
                ->create([
                    'remaining_time' => Config::integer('game.initial_remaining_time'),
                ]);
            $team->users()->syncWithoutDetaching($userIds);
        }
        $this->getTeams();
        broadcast(new GameUsersUpdated($this->game))->toOthers();
    }

    public function start(): void
    {
        $this->game->started_at = now();
        $this->game->save();
        broadcast(new GameStarted($this->game));
    }

    public function gameStarted(): void
    {
        $this->redirect(
            route('game.page', ['game' => $this->game])
        );
    }

    public function render(): View
    {
        return view('livewire.game-lobby');
    }
}
