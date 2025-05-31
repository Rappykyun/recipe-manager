@props([
    'categories' => [],
    'selectedTags' => [],
    'ingredients' => [],
    'modalMode' => '',
])

<form wire:submit.prevent="save" class="space-y-6">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
            <input type="text" wire:model="title" id="title"
                class="block w-full px-4 py-3 mt-1 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('title')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
            <select wire:model="category" id="category"
                class="block w-full px-4 py-3 mt-1 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Select a category</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
            @error('category')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Cooking Instruction/Description</label>
        <textarea wire:model="description" id="description" rows="3"
            class="block w-full px-4 py-3 mt-1 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Describe your recipe..."></textarea>
        @error('description')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="prep_time" class="block text-sm font-medium text-gray-700">Prep Time (minutes)</label>
            <input type="number" wire:model="prep_time" id="prep_time" min="1"
                class="block w-full px-4 py-3 mt-1 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('prep_time')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="image_url" class="block text-sm font-medium text-gray-700">Image URL</label>
            <input type="url" wire:model="image_url" id="image_url"
                class="block w-full px-4 py-3 mt-1 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="https://example.com/image.jpg">
            @error('image_url')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <x-recipe.tag-input :selectedTags="$selectedTags" />

    <x-recipe.ingredients-input :ingredients="$ingredients" />

    <div class="flex items-center">
        <input type="checkbox" wire:model="is_public" id="is_public"
            class="w-4 h-4 text-indigo-600 border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <label for="is_public" class="block ml-3 text-sm font-medium text-gray-700">
            Make Recipe Public (others can view this recipe)
        </label>
    </div>

    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
        <button type="button" wire:click="closeModal"
            class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Cancel
        </button>
        <button type="submit"
            class="px-6 py-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            @if ($modalMode === 'add')
                Save Recipe
            @elseif($modalMode === 'edit')
                Update Recipe
            @else
                Save
            @endif
        </button>
    </div>
</form>
