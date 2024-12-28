<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Events\WordSolved;
use App\Models\Game;
use App\Models\GameUserWord;
use App\Models\Team;
use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class GamePage extends Component
{
    #[Locked]
    public Game $game;

    #[Locked]
    public Collection $teams;

    #[Locked]
    public Word $word;

    #[Locked]
    public bool $isMyTurn = false;

    #[Locked]
    public ?Team $winnerTeam = null;

    public function getListeners(): array
    {
        return [
            "echo-presence:game.{$this->game->id},WordSolved" => 'resetPage',
        ];
    }

    public function mount(): void
    {
        $this->resetPage();
    }

    public function getTeams(): void
    {
        $this->teams = $this->game
            ->teams()
            ->with('users')
            ->orderBy('id')
            ->get();
    }

    public function getWinnerTeam(): void
    {
        $winnerCandidates = $this->teams
            ->filter(fn (Team $team): bool => $team->remaining_time > 0);
        if ($winnerCandidates->count() === 1) {
            $this->winnerTeam = $winnerCandidates->first();
        }
    }

    public function getWord(): void
    {
        $word = Word::whereHas('gameUserWords', function (Builder $query): void {
            $query->whereBelongsTo($this->game)
                ->whereNull('solved_at');
        })
            ->first();
        if (is_null($word)) {
            $word = Word::whereDoesntHave('gameUserWords', function (Builder $query): void {
                $query->whereBelongsTo($this->game);
            })
                ->inRandomOrder()
                ->first();
            if (is_null($word)) {
                abort(418);
            }
            GameUserWord::createOrFirst([
                'game_id' => $this->game->id,
                'user_id' => $this->getCurrentUser()->id,
                'word_id' => $word->id,
            ]);
        }
        $this->word = $word;
        $this->isMyTurn = auth()->id() === $this->getCurrentUser()->id;
    }

    public function getCurrentUser(): User
    {
        return $this->teams[$this->game->turn_index]
            ->users
            ->sortBy('id')
            ->{$this->game->is_on_left_users ? 'last' : 'first'}();
    }

    public function solve(): void
    {
        $solvedAt = now();
        $gameUserWord = $this->game
            ->gameUserWords()
            ->whereNull('solved_at')
            ->first();
        $gameUserWord->solved_at = $solvedAt;
        $gameUserWord->save();

        $team = $this->teams[$this->game->turn_index];
        $team->remaining_time -= $gameUserWord->created_at->diffInSeconds($solvedAt);
        $team->save();

        if ($this->game->turn_index === $this->teams->count() - 1) {
            $this->game->turn_index = 0;
            $this->game->is_on_left_users = ! $this->game->is_on_left_users;
            $this->game->save();
        } else {
            $nextTeamIndex = null;
            for ($i = $this->game->turn_index + 1; $i < $this->teams->count(); $i++) {
                if ($this->teams[$i]->remaining_time > 0) {
                    $nextTeamIndex = $i;
                    break;
                }
            }
            if (! is_null($nextTeamIndex)) {
                for ($i = 0; $i < $this->game->turn_index; $i++) {
                    if ($this->teams[$i]->remaining_time > 0) {
                        $nextTeamIndex = $i;
                        break;
                    }
                }
            }
            $this->game->turn_index = $nextTeamIndex;
            $this->game->save();
        }
        broadcast(new WordSolved($this->game));
    }

    public function resetPage(): void
    {
        $this->getTeams();
        $this->getWord();
        $this->getWinnerTeam();
    }

    public function render(): View
    {
        return view('livewire.game-page');
    }
}
