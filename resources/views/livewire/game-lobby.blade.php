<div class="p-20 flex flex-col gap-4 *:w-fit">
    <h1 class="text-5xl font-black ">
        {{ __('لابی بازی') }}
    </h1>
    <p>
        {{ __('شرکت‌کنندگان بازی:') }}
    </p>
    <div class="ps-4 flex flex-col justify-center">
        @foreach($teams as $team)
            <p>
                {{ $team->users->pluck('name')->implode(' - ') }}
            </p>
        @endforeach
    </div>
    @if($game->user_id === auth()->id())
        <button type="button"
                wire:click="shuffleUsers"
                wire:loading.attr="disabled"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            {{ __('شافل کردن بازیکن‌ها') }}
        </button>
        <button type="button"
                wire:click="start"
                wire:loading.attr="disabled"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            {{ __('شروع بازی') }}
        </button>
    @else
        <p>
            {{ __('در انتظار شروع بازی...') }}
        </p>
    @endif
</div>
