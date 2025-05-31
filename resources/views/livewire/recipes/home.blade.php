<?php

use function Livewire\Volt\{state, with};
use App\Models\Recipe;

state([
    'totalRecipes' => 0,
    'publicRecipes' => 0,
    'recentRecipes' => [],
]);

with([
    'totalRecipes' => function () {
        return Recipe::count();
    },
    'publicRecipes' => function () {
        return Recipe::where('is_public', true)->count();
    },
    'recentRecipes' => function () {
        return Recipe::with(['ingredients', 'tags'])
            ->latest()
            ->take(5)
            ->get();
    },
]);

?>

<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Welcome to Recipe Manager</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Quick Stats --}}
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Quick Stats</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Recipes</p>
                        <p class="text-2xl font-bold">{{ $totalRecipes }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Public Recipes</p>
                        <p class="text-2xl font-bold">{{ $publicRecipes }}</p>
                    </div>
                </div>
            </div>

            {{-- Recent Recipes --}}
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Recent Recipes</h2>
                <div class="space-y-4">
                    @forelse($recentRecipes as $recipe)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium">{{ $recipe->title }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $recipe->category }}</p>
                            </div>
                            {{-- <a href="{{ route('recipes.show', $recipe) }}"
                                class="text-indigo-600 hover:text-indigo-800">View</a> --}}
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">No recipes yet</p>
                    @endforelse
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
                <div class="space-y-4">
                    {{-- <a href="{{ route('recipes.create') }}"
                        class="block w-full px-4 py-2 text-center bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Create New Recipe
                    </a> --}}
                    <a href="{{ route('myRecipes') }}"
                        class="block w-full px-4 py-2 text-center bg-gray-100 dark:bg-zinc-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-zinc-600">
                        View All Recipes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
