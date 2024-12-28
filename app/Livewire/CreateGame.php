<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\WordCategory;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class CreateGame extends Component
{
    #[Locked]
    public Collection $categories;

    public array $selectedCategories = [];

    public function mount(): void
    {
        $this->categories = WordCategory::all();
    }

    public function submit(): void
    {
        $categoryIds = array_keys(
            array_filter($this->selectedCategories)
        );
        if ($categoryIds === []) {
            $categoryIds = $this->categories
                ->pluck('id')
                ->toArray();
        }
        $game = auth()->user()
            ->games()
            ->create();
        $game->categories()->sync($categoryIds);
        $this->redirect(
            route('game.lobby', ['game' => $game])
        );
    }

    public function render(): View
    {
        return view('livewire.create-game');
    }
}
