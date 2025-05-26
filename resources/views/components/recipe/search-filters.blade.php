@props([
    'search' => '',
    'category' => '',
    'tag' => '',
    'categories' => [],
    'tags' => [],
])

<div class="mt-8 bg-white rounded-lg shadow p-6">
    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
        <div class="flex-1 max-w-sm">
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Search recipes, ingredients, or tags..."
                    class="w-full pl-10 pr-4 py-3 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex space-x-4">
            <select wire:model.live="category"
                class="w-48 px-4 py-3 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>

            <select wire:model.live="tag"
                class="w-48 px-4 py-3 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Tags</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                @endforeach
            </select>

            <button type="button" wire:click="openAddModal"
                class="px-6 py-3 font-semibold text-white transition bg-indigo-600 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Recipe
                </div>
            </button>
        </div>
    </div>
</div>
