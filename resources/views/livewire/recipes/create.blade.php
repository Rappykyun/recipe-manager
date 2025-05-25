<?php

use function Livewire\Volt\{state, rules, Validate};
use App\Models\Recipe;
use Livewire\WithFileUploads;

WithFileUploads::class;

state([
    'showModal' => false,
    'title' => '',
    'description' => '',
    'category' => '',
    'prep_time' => '',
    'is_public' => false,
    'tags' => [],
    'ingredients' => [['name' => '', 'quantity' => '']],
    'image' => null,
]);

rules([
    'title' => 'required|min:3',
    'category' => 'required',
    'prep_time' => 'nullable|integer|min:1',
    'ingredients' => 'required|array|min:1',
    'ingredients.*.name' => 'required|string',
    'ingredients.*.quantity' => 'required|string',
    'image' => 'nullable|image|max:1024',
]);

$save = function () {
    $this->validate();

    $recipe = Recipe::create([
        'title' => $this->title,
        'description' => $this->description,
        'category' => $this->category,
        'prep_time' => $this->prep_time,
        'is_public' => $this->is_public,
        'user_id' => auth()->id(),
    ]);

    if ($this->image) {
        $path = $this->image->store('recipes', 'public');
        $recipe->update(['image_path' => $path]);
    }

    foreach ($this->ingredients as $ingredients) {
        $recipe->ingredients()->create($ingredients);
    }

    $this->reset();
    $this->dispatch('closeModal');
    $this->dispatch('recipeCreated');
};

?>

<div>
    <button wire:click="$set('showModal', true)"
        class="hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md">
        Add Recipe
    </button>

    <x-modal-add-recipe :show="$showModal">
        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label for="title" class="dark:text-gray-300 block text-sm font-medium text-gray-700">Title</label>
                <input type="text" wire:model="title" id="title"
                    class="focus:border-indigo-500 focus:ring-indigo-500 block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                @error('title')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="description"
                    class="dark:text-gray-300 block text-sm font-medium text-gray-700">Description</label>
                <textarea wire:model="description" id="description" rows="3"
                    class="focus:border-indigo-500 focus:ring-indigo-500 block w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                @error('description')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="category"
                    class="dark:text-gray-300 block text-sm font-medium text-gray-700">Category</label>
                <select wire:model="category" id="category"
                    class="focus:border-indigo-500 focus:ring-indigo-500 block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                    <option value="">Select a category</option>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Dinner">Dinner</option>
                    <option value="Dessert">Dessert</option>
                </select>
                @error('category')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="prep_time" class="dark:text-gray-300 block text-sm font-medium text-gray-700">Prep Time
                    (minutes)</label>
                <input type="number" wire:model="prep_time" id="prep_time"
                    class="focus:border-indigo-500 focus:ring-indigo-500 block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                @error('prep_time')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div x-data="{
                previewUrl: null,
                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.previewUrl = URL.createObjectURL(file);
                    }
                }
            }">
                <label for="image" class="dark:text-gray-300 block text-sm font-medium text-gray-700">Recipe
                    Image</label>
                <input type="file" wire:model="image" id="image" @change="handleFileSelect"
                    class="block w-full mt-1">
                <template x-if="previewUrl">
                    <img :src="previewUrl" class="object-cover w-32 h-32 mt-2 rounded">
                </template>
                @error('image')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="dark:text-gray-300 block text-sm font-medium text-gray-700">Ingredients</label>
                <template x-for="(ingredient, index) in ingredients" :key="index">
                    <div class="flex gap-2 mt-2">
                        <input type="text" x-model="ingredient.name"
                            wire:model.defer="ingredients.{{ index }}.name" placeholder="Name"
                            class="focus:border-indigo-500 focus:ring-indigo-500 flex-1 border-gray-300 rounded-md shadow-sm">
                        <input type="text" x-model="ingredient.quantity"
                            wire:model.defer="ingredients.{{ index }}.quantity" placeholder="Quantity"
                            class="focus:border-indigo-500 focus:ring-indigo-500 flex-1 border-gray-300 rounded-md shadow-sm">
                        <button type="button" @click="removeIngredient(index)" class="hover:text-red-700 text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
                <button type="button" @click="addIngredient" class="hover:text-indigo-800 mt-2 text-indigo-600">
                    + Add Ingredient
                </button>
                @error('ingredients')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" wire:model="is_public" id="is_public"
                    class="focus:border-indigo-500 focus:ring-indigo-500 text-indigo-600 border-gray-300 rounded shadow-sm">
                <label for="is_public" class="dark:text-gray-300 block ml-2 text-sm font-medium text-gray-700">
                    Make Recipe Public
                </label>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" wire:click="$set('showModal', false)"
                    class="hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm">
                    Cancel
                </button>
                <button type="submit"
                    class="hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm">
                    Save Recipe
                </button>
            </div>
        </form>
    </x-modal-add-recipe>
</div>
