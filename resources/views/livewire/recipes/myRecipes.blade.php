<?php

use function Livewire\Volt\{state, with};
use App\Models\Recipe;
use App\Models\Tag;
use Livewire\WithPagination;

// Use pagination
WithPagination::class;

// State
state([
    'search' => '',
    'category' => '',
    'tag' => '',
    'showModal' => false,
    'title' => '',
    'description' => '',
    'prep_time' => '',
    'is_public' => false,
    'ingredients' => [['name' => '', 'quantity' => '']],
    'image_url' => '',
    'selectedTags' => [],
]);

// Computed properties
with([
    'recipes' => function () {
        return Recipe::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
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
            ->latest()
            ->paginate(10) ?? collect([]);
    },
    'categories' => ['Breakfast', 'Lunch', 'Dinner', 'Dessert'],
    'tags' => fn() => Tag::all() ?? collect([]),
]);

// Methods
$updatingSearch = function () {
    $this->resetPage();
};

$save = function () {
    if (!auth()->check()) {
        $this->redirect(route('login'));
        return;
    }

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

    $recipe = Recipe::create([
        'title' => $this->title,
        'description' => $this->description,
        'category' => $this->category,
        'prep_time' => $this->prep_time,
        'is_public' => $this->is_public,
        'user_id' => auth()->id(),
        'image_path' => $this->image_url,
    ]);

    foreach ($this->ingredients as $ingredient) {
        $recipe->ingredients()->create($ingredient);
    }

    // Attach or create tags
    $tagIds = [];
    foreach ($this->selectedTags as $tagName) {
        $tag = \App\Models\Tag::firstOrCreate(['name' => $tagName]);
        $tagIds[] = $tag->id;
    }
    $recipe->tags()->sync($tagIds);

    $this->reset(['title', 'description', 'category', 'prep_time', 'is_public', 'ingredients', 'image_url', 'showModal', 'selectedTags']);
    $this->dispatch('recipe-created');
};

$addIngredient = function () {
    $this->ingredients[] = ['name' => '', 'quantity' => ''];
};

$removeIngredient = function ($index) {
    unset($this->ingredients[$index]);
    $this->ingredients = array_values($this->ingredients);
};

?>

<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-8">
        {{-- Search --}}
        <div class="flex-1 max-w-sm">
            <div class="relative">
                <input type="text" wire:model.live="search" placeholder="Search recipes..."
                    class="w-full pl-10 pr-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Add Recipe Button --}}
        <button wire:click="$set('showModal', true)"
            class="px-6 py-2 ml-4 font-semibold text-white transition bg-indigo-600 rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Recipe
            </div>
        </button>
    </div>

    <div class="flex gap-4 mb-8">
        {{-- Category Filter --}}
        <div class="w-48">
            <select wire:model.live="category"
                class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Categories</option>
                @foreach (is_iterable($categories) ? $categories : [] as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tag Filter --}}
        <div class="w-48">
            <select wire:model.live="tag"
                class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Tags</option>
                @foreach (is_iterable($tags) ? $tags : [] as $tag)
                    <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Recipes Grid --}}
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3">
        @foreach (is_iterable($recipes) ? $recipes : [] as $recipe)
            <x-recipe-card :recipe="$recipe" />
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $recipes->links() }}
    </div>

    {{-- Add Recipe Modal --}}
    <x-modal-add-recipe :show="$showModal">
        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" wire:model="title" id="title"
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('title')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea wire:model="description" id="description" rows="3"
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                @error('description')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                <select wire:model="category" id="category"
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Select a category</option>
                    @foreach (is_iterable($categories) ? $categories : [] as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="prep_time" class="block text-sm font-medium text-gray-700">Prep Time (minutes)</label>
                <input type="number" wire:model="prep_time" id="prep_time"
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('prep_time')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-700">Image URL</label>
                <input type="text" wire:model="image_url" id="image_url"
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="https://example.com/image.jpg">
                @error('image_url')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div x-data="{
                tags: @entangle('selectedTags').defer,
                tagInput: '',
                addTag() {
                    let tag = this.tagInput.trim();
                    if (tag && !this.tags.includes(tag)) {
                        this.tags.push(tag);
                    }
                    this.tagInput = '';
                },
                removeTag(index) {
                    this.tags.splice(index, 1);
                },
                handleInput(e) {
                    if (e.key === 'Enter' || e.key === ',') {
                        e.preventDefault();
                        this.addTag();
                    }
                }
            }" class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Tags</label>
                <div class="flex flex-wrap gap-2">
                    <template x-for="(tag, index) in tags" :key="tag">
                        <span class="flex items-center px-2 py-1 text-sm bg-indigo-100 text-indigo-700 rounded">
                            <span x-text="tag"></span>
                            <button type="button" class="ml-1 text-indigo-500 hover:text-red-500"
                                @click="removeTag(index)">×</button>
                        </span>
                    </template>
                </div>
                <input x-model="tagInput" @keydown="handleInput" @blur="addTag" type="text"
                    class="w-full px-4 py-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Type a tag and press Enter or comma">
                @error('selectedTags')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Ingredients</label>
                <div class="mt-2 space-y-3">
                    @foreach (is_iterable($ingredients) ? $ingredients : [] as $i => $ingredient)
                        <div class="flex gap-3">
                            <input type="text" wire:model.defer="ingredients.{{ $i }}.name"
                                placeholder="Name"
                                class="flex-1 px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <input type="text" wire:model.defer="ingredients.{{ $i }}.quantity"
                                placeholder="Quantity"
                                class="flex-1 px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <button type="button"
                                wire:click="{{ '$emit' }}('removeIngredient', {{ $i }})"
                                class="p-2 text-red-500 transition rounded-lg hover:bg-red-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
                <button type="button" wire:click="{{ '$emit' }}('addIngredient')"
                    class="flex items-center px-4 py-2 mt-3 text-sm font-medium text-indigo-600 transition rounded-lg hover:bg-indigo-50">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Ingredient
                </button>
                @error('ingredients')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" wire:model="is_public" id="is_public"
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <label for="is_public" class="block ml-2 text-sm font-medium text-gray-700">
                    Make Recipe Public
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" wire:click="$set('showModal', false)"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Save Recipe
                </button>
            </div>
        </form>
    </x-modal-add-recipe>
</div>
