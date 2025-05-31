<?php

use function Livewire\Volt\{state, with, mount};
use App\Models\Recipe;

// State
state(['recipe']);

// Mount the component with the recipe
mount(function (Recipe $recipe) {
    // Check if user owns the recipe or if it's public
    if ($recipe->user_id !== auth()->id() && !$recipe->is_public) {
        abort(403, 'You do not have permission to view this recipe.');
    }

    $this->recipe = $recipe->load(['ingredients', 'tags', 'user']);
});

?>

<div>
    <!-- Header with back button -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('myRecipes') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Recipes
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $recipe->title }}</h1>
            </div>

            @if ($recipe->user_id === auth()->id())
                <div class="flex space-x-3">
                    <button wire:click="$dispatch('openEditModal', { recipeId: {{ $recipe->recipe_id }} })"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Recipe
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Recipe Content -->
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Recipe Image -->
            @if ($recipe->image_url)
                <div class="mb-8">
                    <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}"
                        class="object-cover w-full h-64 rounded-lg shadow-lg">
                </div>
            @endif

            <!-- Recipe Info -->
            <div class="p-6 mb-8 bg-white rounded-lg shadow">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div class="text-center">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-indigo-100 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Prep Time</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $recipe->prep_time ? $recipe->prep_time . ' min' : 'Not specified' }}
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Ingredients</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $recipe->ingredients->count() }}
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Category</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $recipe->category }}</p>
                    </div>
                </div>
            </div>

            <!-- Cooking Instructions -->
            @if ($recipe->description)
                <div class="p-6 mb-8 bg-white rounded-lg shadow">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900">Cooking Instructions</h2>
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $recipe->description }}</p>
                    </div>
                </div>
            @endif

            <!-- Tags -->
            @if ($recipe->tags->count() > 0)
                <div class="p-6 bg-white rounded-lg shadow">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900">Tags</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($recipe->tags as $tag)
                            <span class="px-3 py-1 text-sm font-medium text-indigo-700 bg-indigo-100 rounded-full">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Ingredients -->
            <div class="p-6 mb-8 bg-white rounded-lg shadow">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Ingredients</h2>
                <ul class="space-y-3">
                    @foreach ($recipe->ingredients as $ingredient)
                        <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium text-gray-900">{{ $ingredient->name }}</span>
                            <span class="text-sm text-gray-600">{{ $ingredient->quantity }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Recipe Info -->
            <div class="p-6 bg-white rounded-lg shadow">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Recipe Info</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Created by</span>
                        <span class="text-sm text-gray-900">{{ $recipe->user->name }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Visibility</span>
                        <span class="text-sm {{ $recipe->is_public ? 'text-green-600' : 'text-gray-600' }}">
                            {{ $recipe->is_public ? 'Public' : 'Private' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Created</span>
                        <span class="text-sm text-gray-900">{{ $recipe->created_at->format('M j, Y') }}</span>
                    </div>
                    @if ($recipe->updated_at != $recipe->created_at)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-500">Updated</span>
                            <span class="text-sm text-gray-900">{{ $recipe->updated_at->format('M j, Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
