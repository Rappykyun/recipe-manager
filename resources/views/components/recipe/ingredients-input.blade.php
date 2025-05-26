@props([
    'ingredients' => [],
])

<div>
    <label class="block text-sm font-medium text-gray-700">Ingredients *</label>
    <div class="mt-3 space-y-3">
        @foreach ($ingredients as $i => $ingredient)
            <div class="flex gap-3">
                <input type="text" wire:model.defer="ingredients.{{ $i }}.name"
                    placeholder="Ingredient name"
                    class="flex-1 px-4 py-3 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <input type="text" wire:model.defer="ingredients.{{ $i }}.quantity"
                    placeholder="Quantity (e.g., 1 cup)"
                    class="flex-1 px-4 py-3 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @if (count($ingredients) > 1)
                    <button type="button" wire:click="removeIngredient({{ $i }})"
                        class="p-3 text-red-500 transition rounded-lg hover:bg-red-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>
        @endforeach
    </div>
    <button type="button" wire:click="addIngredient"
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