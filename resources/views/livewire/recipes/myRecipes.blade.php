<?php

use function Livewire\Volt\{state, with, uses};
use App\Models\Recipe;
use App\Models\Tag;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

// Use pagination and file uploads
uses([WithPagination::class, WithFileUploads::class]);

// State
state([
    'search' => '',
    'category' => '',
    'tag' => '',
    'modalOpen' => false,
    'modalMode' => '', // 'add', 'edit', 'delete'
    'editingRecipe' => null,
    'title' => '',
    'description' => '',
    'prep_time' => '',
    'is_public' => false,
    'ingredients' => [['name' => '', 'quantity' => '']],
    'image_url' => '',
    'selectedTags' => [],
    'deleteRecipeId' => null,
]);

// Computed properties
with([
    'recipes' => function () {
        return Recipe::query()
            ->where('user_id', auth()->id())
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
            ->with(['ingredients', 'tags'])
            ->withCount('ingredients')
            ->latest()
            ->paginate(10);
    },
    'categories' => ['Breakfast', 'Lunch', 'Dinner', 'Dessert'],
    'tags' => fn() => Tag::all(),
]);

// Methods
$updatingSearch = function () {
    $this->resetPage();
};

$openAddModal = function () {
    $this->resetForm();
    $this->modalMode = 'add';
    $this->modalOpen = true;
};

$openEditModal = function ($recipeId) {
    $this->resetForm();

    $recipe = Recipe::with(['ingredients', 'tags'])->find($recipeId);
    if ($recipe && $recipe->user_id === auth()->id()) {
        $this->editingRecipe = $recipe;
        $this->title = $recipe->title;
        $this->description = $recipe->description;
        $this->category = $recipe->category;
        $this->prep_time = $recipe->prep_time;
        $this->is_public = $recipe->is_public;
        $this->image_url = $recipe->image_url;
        $this->ingredients = $recipe->ingredients->map(fn($i) => ['name' => $i->name, 'quantity' => $i->quantity])->toArray();
        $this->selectedTags = $recipe->tags->pluck('name')->toArray();

        $this->modalMode = 'edit';
        $this->modalOpen = true;
    }
};

$openDeleteModal = function ($recipeId) {
    $this->deleteRecipeId = $recipeId;
    $this->modalMode = 'delete';
    $this->modalOpen = true;
};

$closeModal = function () {
    $this->modalOpen = false;
    $this->modalMode = '';
    $this->resetForm();
    $this->resetErrorBag();
    $this->resetValidation();
};

$resetForm = function () {
    $this->reset(['title', 'description', 'category', 'prep_time', 'is_public', 'ingredients', 'image_url', 'selectedTags', 'editingRecipe', 'deleteRecipeId']);
    $this->ingredients = [['name' => '', 'quantity' => '']];
    $this->selectedTags = [];
    $this->is_public = false;
};

$save = function () {
    $this->validate([
        'title' => 'required|min:3',
        'category' => 'required',
        'prep_time' => 'nullable|integer|min:1',
        'ingredients' => 'required|array|min:1',
        'ingredients.*.name' => 'required|string',
        'ingredients.*.quantity' => 'required|string',
        'image_url' => 'nullable|url',
        'selectedTags' => 'array',
    ]);

    $recipeData = [
        'title' => $this->title,
        'description' => $this->description,
        'category' => $this->category,
        'prep_time' => $this->prep_time,
        'is_public' => (bool) $this->is_public,
        'image_url' => $this->image_url,
    ];

    if ($this->editingRecipe) {
        $this->editingRecipe->update($recipeData);
        $recipe = $this->editingRecipe;
        $message = 'Recipe updated successfully!';
    } else {
        $recipeData['user_id'] = auth()->id();
        $recipe = Recipe::create($recipeData);
        $message = 'Recipe created successfully!';
    }

    // Sync ingredients
    $recipe->ingredients()->delete();
    foreach ($this->ingredients as $ingredient) {
        if (!empty($ingredient['name']) && !empty($ingredient['quantity'])) {
            $recipe->ingredients()->create($ingredient);
        }
    }

    // Sync tags
    $tagIds = [];
    foreach ($this->selectedTags as $tagName) {
        if (!empty($tagName)) {
            $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
            $tagIds[] = $tag->id;
        }
    }
    $recipe->tags()->sync($tagIds);

    // Close modal and reset state
    $this->modalOpen = false;
    $this->modalMode = '';
    $this->resetForm();

    // Flash message and refresh
    session()->flash('message', $message);
    $this->dispatch('recipe-saved');
};

$deleteRecipe = function () {
    if ($this->deleteRecipeId) {
        $recipe = Recipe::find($this->deleteRecipeId);
        if ($recipe && $recipe->user_id === auth()->id()) {
            $recipe->delete();
            session()->flash('message', 'Recipe deleted successfully!');
        }
    }

    // Close modal and reset state
    $this->modalOpen = false;
    $this->modalMode = '';
    $this->resetForm();
    $this->resetErrorBag();
    $this->resetValidation();
};

$addIngredient = function () {
    $this->ingredients[] = ['name' => '', 'quantity' => ''];
};

$removeIngredient = function ($index) {
    if (count($this->ingredients) > 1) {
        unset($this->ingredients[$index]);
        $this->ingredients = array_values($this->ingredients);
    }
};

$removeTag = function ($index) {
    if (isset($this->selectedTags[$index])) {
        unset($this->selectedTags[$index]);
        $this->selectedTags = array_values($this->selectedTags);
    }
};

$navigateToRecipe = function ($recipeId) {
    return redirect()->route('recipes.show', $recipeId);
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
            <x-recipe.page-header title="My Recipes" />

            <main>
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        
                    <x-recipe.search-filters :search="$search" :category="$category" :tag="$tag" :categories="$categories"
                        :tags="$tags" />

   
                    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse ($recipes as $recipe)
                            <x-recipe.card :recipe="$recipe" />
                        @empty
                            <x-recipe.empty-state :search="$search" :category="$category" :tag="$tag" />
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

    <x-recipe.form-modal :modalOpen="$modalOpen" :modalMode="$modalMode" :categories="$categories" :selectedTags="$selectedTags"
        :ingredients="$ingredients" />
</div>
