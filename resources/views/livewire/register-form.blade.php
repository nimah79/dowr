<div class="flex p-20">
    <div class="flex flex-col gap-2 mx-auto">
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                {{ __('اسم:') }}
            </label>
            <input type="text"
                   id="name"
                   wire:model="name"
                   class="p-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                   required />
        </div>
        <button type="submit"
                wire:click="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
            {{ __('ثبت‌نام') }}
        </button>
    </div>
</div>
