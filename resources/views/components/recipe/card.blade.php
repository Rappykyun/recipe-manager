@props(['recipe'])

<div class="relative overflow-hidden bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 cursor-pointer"
    wire:click="navigateToRecipe({{ $recipe->recipe_id }})">
    @if ($recipe->image_url)
        <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}" class="object-cover w-full h-48">
    @else
        <div class="flex items-center justify-center w-full h-48 bg-gray-200">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2z" />
            </svg>
        </div>
    @endif

    <div class="p-6">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">{{ $recipe->title }}</h3>
            <span class="px-2 py-1 text-sm text-indigo-700 bg-indigo-100 rounded-full">
                {{ $recipe->category }}
            </span>
        </div>

        @if ($recipe->description)
            <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $recipe->description }}</p>
        @endif

        <div class="mt-4">
            <div class="flex flex-wrap gap-2">
                @foreach ($recipe->tags as $tag)
                    <span class="px-2 py-1 text-xs text-gray-600 bg-gray-100 rounded-full">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <div class="flex items-center space-x-4 text-sm text-gray-500">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $recipe->prep_time ? $recipe->prep_time . ' min' : 'No time set' }}
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    {{ $recipe->ingredients_count }} ingredients
                </div>
            </div>
        </div>
    </div>

    <!-- Action buttons overlay -->
    <div class="absolute bottom-4 right-4 flex space-x-2">
        @if ($recipe->is_public)
            <span class="px-2 py-1 text-xs text-green-700 bg-green-100 rounded-full shadow-sm">
                Public
            </span>
        @endif
        <button wire:click.stop="openEditModal({{ $recipe->recipe_id }})"
            class="relative z-10 p-2 text-gray-600 bg-white rounded-lg shadow-sm transition hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </button>
        <button wire:click.stop="openDeleteModal({{ $recipe->recipe_id }})"
            class="relative z-10 p-2 text-red-600 bg-white rounded-lg shadow-sm transition hover:bg-red-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
    </div>
</div>
