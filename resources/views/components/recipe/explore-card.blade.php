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

        <!-- Author -->
        <div class="flex items-center mt-2 text-sm text-gray-600">
            <div
                class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center text-xs font-bold text-gray-700 mr-2">
                {{ strtoupper(substr($recipe->user->name, 0, 1)) }}
            </div>
            <span>by {{ $recipe->user->name }}</span>
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

    <!-- Public badge -->
    <div class="absolute top-4 right-4">
        <span class="px-2 py-1 text-xs text-green-700 bg-green-100 rounded-full shadow-sm">
            Public
        </span>
    </div>

    <!-- Created date -->
    <div class="absolute bottom-4 right-4">
        <span class="px-2 py-1 text-xs text-gray-500 bg-white rounded-full shadow-sm">
            {{ $recipe->created_at->diffForHumans() }}
        </span>
    </div>
</div>
