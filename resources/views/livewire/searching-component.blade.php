<div class="relative text-gray-600 focus-within:text-gray-400 md:w-4/5" style="width:200px;">
    <input type="search" wire:model="search" wire:keydown.enter="buscar"
        class="border-2 border-gray-400 py-2 text-sm bg-white rounded-full pr-10 pl-4 focus:outline-none focus:bg-white focus:text-gray-900 w-full"
        placeholder="Buscar" autocomplete="off">
    <span class="absolute inset-y-0 right-0 flex items-center pr-2">
        <button type="button" class="p-1 focus:outline-none focus:shadow-outline" wire:click="buscar">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                viewBox="0 0 24 24" class="w-4 h-4">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
    </span>
</div>
