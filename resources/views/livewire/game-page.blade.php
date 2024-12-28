<div class="p-20 flex flex-col gap-4 *:w-fit">
    @if($winnerTeam)
        {{ __('تیم برنده: :team', ['team' => $winnerTeam->users->pluck('name')->implode(' - ')]) }}
    @else
        @assets
        <script>
            function toFarsiNumber(n) {
                const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

                return n
                    .toString()
                    .replace(/\d/g, x => farsiDigits[x]);
            }

            function timer(expiry) {
                return {
                    expiry: expiry,
                    remaining: null,
                    init() {
                        this.setRemaining()
                        setInterval(() => {
                            this.setRemaining();
                        }, 1000);
                    },
                    setRemaining() {
                        const diff = this.expiry - new Date().getTime();
                        this.remaining = parseInt(diff / 1000);
                    },
                }
            }
        </script>
        @endassets

        <div class="ps-4 flex flex-col justify-center">
            @foreach($teams as $team)
                <p class="text-2xl font-bold">
                    @if($team->remaining_time <= 0)
                        <span class="text-red-600">
                            {{ $team->users->pluck('name')->implode(' - ') }}
                        </span>
                    @else
                        <span
                            class="{{ (! $game->is_on_left_users && $game->turn_index === $loop->index) ? 'text-green-600 font-black' : '' }}">{{ $team->users->first()->name }}</span>
                        -
                        <span
                            class="{{ ($game->is_on_left_users && $game->turn_index === $loop->index) ? 'text-green-600 font-black' : '' }}">{{ $team->users->last()->name }}</span>:
                        @if($game->turn_index === $loop->index)
                            <span class="timer" x-data="timer(new Date(new Date().getTime() + {{ $team->remaining_time * 1000 }}))"
                                  x-init="init();">
                                <span x-text="toFarsiNumber(remaining)"></span>
                            </span>
                        @else
                            {{ to_persian_digits($team->remaining_time) }}
                        @endif
                    @endif
                </p>
            @endforeach
        </div>
        @if($isMyTurn)
            <div class="flex flex-col gap-10 justify-center items-center mx-auto">
                <p class="mx-auto text-4xl">
                    {{ $word->name }}
                </p>
                <button type="button"
                        wire:click="solve"
                        wire:loading.attr="disabled"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    {{ __('گفتم') }}
                </button>
            </div>
        @endif
    @endif
</div>
