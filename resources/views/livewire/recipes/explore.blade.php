<?php

use function Livewire\Volt\{state, with, uses};
use App\Models\Recipe;
use App\Models\Tag;
use Livewire\WithPagination;

// Use pagination
uses([WithPagination::class]);

// State
state([
    'search' => '',
    'category' => '',
    'tag' => '',
]);

// Computed properties
with([
    'recipes' => function () {
        return Recipe::query()
            ->where('is_public', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhereHas('ingredients', function ($ingredientQuery) {
                            $ingredientQuery->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('tags', function ($tagQuery) {
                            $tagQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->category, function ($query) {
                $query->where('category', $this->category);
            })
            ->when($this->tag, function ($query) {
                $query->whereHas('tags', function ($query) {
                    $query->where('name', $this->tag);
                });
            })
            ->with(['ingredients', 'tags', 'user'])
            ->withCount('ingredients')
            ->latest()
            ->paginate(10);
    },
    'categories' => ['Breakfast', 'Lunch', 'Dinner', 'Dessert'],
    'tags' => fn() => Tag::whereHas('recipes', function ($query) {
        $query->where('is_public', true);
    })->get(),
]);

// Methods
$updatingSearch = function () {
    $this->resetPage();
};

$navigateToRecipe = function ($recipeId) {
    return redirect()->route('exploreRecipes.show', $recipeId);
};

?>

<div>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <div class="min-h-screen bg-gray-50">
        <div class="py-8">
            <x-recipe.page-header title="Explore Recipes" />

            <main>
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

                    <x-recipe.explore-search-filters :search="$search" :category="$category" :tag="$tag"
                        :categories="$categories" :tags="$tags" />


                    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse ($recipes as $recipe)
                            <x-recipe.explore-card :recipe="$recipe" />
                        @empty
                            <x-recipe.explore-empty-state :search="$search" :category="$category" :tag="$tag" />
                        @endforelse
                    </div>

                    @if ($recipes->hasPages())
                        <div class="mt-8">
                            {{ $recipes->links() }}
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</div>
