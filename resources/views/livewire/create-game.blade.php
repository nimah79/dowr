<div class="p-20 flex flex-col gap-4 *:w-fit">
    <p class="font-black">
        {{ __('خوش اومدی :name!', ['name' => auth()->user()->name]) }}
    </p>

    <h1 class="text-5xl font-black">
        {{ __('ساخت بازی جدید') }}
    </h1>
    <p class="font-bold">
        {{ __('دسته‌بندی‌ها رو انتخاب کن:') }}
    </p>
    <div class="ps-4 flex flex-col justify-center">
        @foreach($categories as $category)
            <div class="flex items-center mb-4">
                <input id="category_{{ $category->id }}"
                       wire:model="selectedCategories.{{ $category->id }}"
                       type="checkbox"
                       value="{{ $category->id }}"
                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500   focus:ring-2">
                <label for="category_{{ $category->id }}"
                       class="ms-2 text-sm font-medium text-gray-900">
                    {{ $category->name }}
                </label>
            </div>
        @endforeach
    </div>
    <button type="button"
            wire:click="submit"
            wire:loading.attr="disabled"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-hidden dark:focus:ring-blue-800">
        {{ __('ساخت بازی') }}
    </button>
</div>
